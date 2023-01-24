<?php
  session_start();
  require_once('./../../components/navbar.php');
  require_once('./../../auth/settings.php');
  require_once('./../../auth/connect_db.php');
  require_once('./quiz_submit_functions.php');
  require_once('./../profile/achievements.php');

  if(!isset($_SESSION['username'])) {
    header('Location: ./../../login.php');
    die();
  }

  if(!isset($_SESSION['quizInfo'])) {
    header('Location: ./../select_category.php');
    die();
  }

  $quizInfo = $_SESSION['quizInfo'];
  $success = false;
  $score = 0;

  if(isset($_POST['btn'])) {
    $keys = array();
    $inputValues = array();
    
    for($i = 1; $i <= sizeof($quizInfo['id']); $i++) {
      array_push($keys, 'question_'.$i);
      $inputValues['question_'.$i] = array();
      if(!isset($_POST['question_'.$i])) {
        array_push($inputValues['question_'.$i], array());
      } else {
        array_push($inputValues['question_'.$i], $_POST['question_'.$i]);
      }
    }

    $score = getScore($inputValues, $quizInfo, $keys, $conn);

    $resultId = updateQuizInfo($_SESSION['username'], $_SESSION['quizType'], $score, $conn);

    unset($_SESSION['quizInfo']);
    unset($_SESSION['quizType']);
    $success = true;
    $inputValues = array();
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
  <title>Kvizzi | Rezultat </title>
</head>
<body class="d-flex flex-column min-vh-100">
  
  <?php if($success): ?>
    <script>
      window.setTimeout(x => { 
        window.location = "<?=$PATH.'/pages/quiz/result.php?source=quiz&id='.$resultId?>";
      }, 0);
      window.history.replaceState(null, null, window.location.href);
    </script>
  <?php endif; ?>
  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>
</html>