<?php 
  session_start();
  require_once('./../../components/navbar.php');
  require_once('./../../components/footer.php');
  require_once('./../../auth/settings.php');
  require_once('./../../auth/connect_db.php');
  require_once('./result_functions.php');

  if(!isset($_SESSION['username'])) {
    header('Location: ./../../login.php');
    die();
  }
  
  if(!isset($_GET['id'])) {
    header('Location: ./../select_category.php');
    die();
  }

  if(!$_SESSION['admin']) {
    if(!checkIdOfResult($_GET['id'], $_SESSION['username'], $conn)) {
      header('Location: ./../select_category.php');
      die();
    }
  }

  $userId = getUserIdByQuizId($_GET['id'], $conn);
  $quizInfo = getQuizIdData($_GET['id'], $conn);
  $quizAverageInfo = getGlobalQuizIdData($userId, $conn);
  $time = 0;
  $timePerQuestion = 0;
  $timeFinished = 0;
  $classes = array(
    'timeDif' => 'result_equal',
    'score' => 'result_equal',
    'timePerQuestion' => 'result_equal'
  );

  if($quizInfo['time_finished'] != 'DNF') {
    $timeFinished = (new DateTime($quizInfo['time_finished']))->format('d. M Y. H:i:s');
    $time = abs(strtotime($quizInfo['time_started']) - strtotime($quizInfo['time_finished']));
    $timePerQuestion = $time / 10;
  }

  if($timeFinished != 0) {
    // score check
    if($quizInfo['score'] > $quizAverageInfo['averageScore']) {
      $classes['score'] = 'result_larger';
    } else if ($quizInfo['score'] < $quizAverageInfo['averageScore']) {
      $classes['score'] = 'result_smaller';
    }

    // time per question check
    if($timePerQuestion < $quizAverageInfo['averageTimePerQuestion']) {
      $classes['timePerQuestion'] = 'result_larger';
    } else if ($timePerQuestion > $quizAverageInfo['averageTimePerQuestion']) {
      $classes['timePerQuestion'] = 'result_smaller';
    }

    // time check
    if($time < $quizAverageInfo['averageTimePlayed']) {
      $classes['timeDif'] = 'result_larger';
    } else if ($time > $quizAverageInfo['averageTimePlayed']) {
      $classes['timeDif'] = 'result_smaller';
    }
  }

  $result = array();

  foreach($classes as $key => $value) {
    if($classes[$key] == 'result_larger') {
      $result[$key] = '&#9650;';
    } else if ($classes[$key] == 'result_smaller') {
      $result[$key] = '&#9660;';
    } else {
      $result[$key] = '=';
    }
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= $PATH . '/images/favicon.png' ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?= $PATH . '/style/bootstrap.min.css' ?>">
  <link rel="stylesheet" href="<?= $PATH . '/style/style.css' ?>">
  <title>Kvizzi | Rezultat #<?= $_GET['id'] ?></title>
</head>
<body class="d-flex flex-column min-vh-100">
  <?php generateNavbar('kviz', $PATH) ?>
  
  <div class="container-fluid">
    <div class="row d-flex justify-content-center mt-lg-5 mt-sm-2 mt-xs-2">
      <h5 class="mb-3 text-center">Rezultat</h5>
      <div class="col-sm-12 col-md-8 col-lg-4 col-xl-3">
        <table class="table table-striped table-responsive table-bordered">
          <tbody>
            <tr>
              <th scope="row">#</th>
              <td> <?= $_GET['id'] ?> </td>
            </tr>
            <tr>
              <th scope="row">Početak igranja</th>
              <td> <?= (new DateTime($quizInfo['time_started']))->format('d. M Y. H:i:s') ?> </td>
            </tr>
            <tr>
              <th scope="row">Kraj igranja</th>
              <td> <?= $timeFinished ?> </td>
            </tr>
            <tr>
              <th scope="row">Trajanje</th>
              <td><span class="<?= $classes['timeDif'] ?>"><?= $result['timeDif'] . $time ?>s</span> <small class="text-muted">(<?= $quizAverageInfo['averageTimePlayed'] ?>)</small></td>
            </tr>
            <tr>
              <th scope="row">Rezultat</th>
              <td><span class="<?= $classes['score'] ?>"><?= $result['score'] . $quizInfo['score']?></span> <small class="text-muted">(<?= $quizAverageInfo['averageScore'] ?>)</small></td>
            </tr>
            <tr>
              <th scope="row">Vreme po odgovoru</th>
              <td><span class="<?= $classes['timePerQuestion'] ?>"><?= $result['timePerQuestion'] . $timePerQuestion ?>s</span> <small class="text-muted">(<?= $quizAverageInfo['averageTimePerQuestion'] ?>)</small></td>
            </tr>
            </tr>
          </tbody>
        </table>
        <small class="text-muted text-right">*Samo završeni pokušaji su uračunati</small>
      </div>
    </div>
    <?php if(isset($_GET['source'])): ?>
      <div class="row d-flex justify-content-center mt-5">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2 d-flex justify-content-center mb-5">
          <a class="btn mt-3 btn-block edit_profile_btn" href="./../quiz.php">Igraj ponovo?</a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2 d-flex justify-content-center mb-5">
          <a class="btn mt-3 btn-block edit_profile_btn" href="./../profile/my_profile.php">Idi na profil?</a>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <?php generateFooter($PATH) ?>
  <script>
    
  </script>
  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>
</html>