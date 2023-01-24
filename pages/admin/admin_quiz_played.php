<?php
session_start();
if (!$_SESSION['admin'] || !isset($_SESSION['username'])) {
  header('Location: ./../../index.php');
  exit();
}

require_once('./../../auth/connect_db.php');
require_once('./../../components/navbar.php');
require_once('./../../components/footer.php');
require_once('./../../auth/settings.php');
require_once('./admin_panel_functions.php');

if(isset($_GET['pageNum']) && $_GET['pageNum'] != '') {
  $pageNum = $_GET['pageNum'];
} else {
  $pageNum = 1;
}

if($pageNum < 1) {
  $pageNum = 1;
}


$countQuizPlaying = countQuizPlaying($conn);

$totalNumberOfPages = ceil($countQuizPlaying / 10);

$prevPage = $pageNum - 1;
if($prevPage < 1) {
  $prevPage = $pageNum;
}

$nextPage = $pageNum + 1;
if($nextPage > $totalNumberOfPages) {
  $nextPage = $totalNumberOfPages;
}

$quizInfo = getQuizPlayedDetails(10, ($pageNum - 1) * 10, $conn);

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
  <link rel="stylesheet" href="<?= $PATH . '/style/style_admin.css' ?>">
  <title>Kvizzi | Admin Panel - Odigrani kvizovi</title>

</head>

<body>
  <!-- Navbar -->
  <?php generateNavbar('', $PATH); ?>

  <div class="row d-flex justify-content-center mt-5">
    <h5 class="mb-3 text-center">Rezultati</h5>
      <div class="col-lg-8 col-md-10 col-sm-12">
        <table class="table table-striped table-responsive">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Kategorija</th>
              <th scope="col">Početak</th>
              <th scope="col">Kraj</th>
              <th scope="col">Korisnik</th>
              <th scope="col">Rezultat</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i = 0; $i < sizeof($quizInfo['id']); $i++): ?>
              <tr onclick="window.location.href='<?= $PATH.'/pages/quiz/result.php?id='.$quizInfo['id'][$i] ?>'">
                <th scope="row">#<?= $quizInfo['id'][$i] ?></th>
                <td scope="col"><?= $quizInfo['category_name'][$i] ?></td>
                <td scope="col"><?= $quizInfo['time_started'][$i] ?></td>
                <td scope="col"><?= $quizInfo['time_finished'][$i] ?></td>
                <td scope="col">
                  <a class="admin_link" href="<?= $PATH.'/pages/profile/profile.php?user='.$quizInfo['users_name'][$i] ?>">
                    <?= shortenString($quizInfo['users_name'][$i], 12) ?>
                  </a>
                </td>
                <td scope="col"><?= $quizInfo['score'][$i] ?></td>
              </tr>
            <?php endfor; ?>
          </tbody>
        </table>
        <div class="container">
          <div class="row d-flex justify-content-center">
            <p class="text-center">Pronadjeno <?= $countQuizPlaying ?> instanci</p>
            <div class="d-flex justify-content-center">
              <div class="container-fluid d-flex justify-content-center mt-5 mb-5">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="?pageNum=<?= $prevPage ?>">Nazad</a></li>
                  <?php if ($totalNumberOfPages < 10) { ?>
                    <?php for ($i = 1; $i <= $totalNumberOfPages; $i++) : ?>
                      <?php if ($i == $pageNum) { ?>
                        <li class="active page-item"><a class="page-link" href="#"><?= $i ?></a></li>
                        <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                        <?php } ?>
                      <?php endfor; ?>
                    <?php } else if ($totalNumberOfPages > 10) { ?>
                      <?php if ($pageNum <= 4) { ?>
                        <?php for ($i = 1; $i < 8; $i++) { ?>
                          <?php if ($i == $pageNum) { ?>
                        <li class="active page-item"><a class="page-link" href="#"><?= $i ?></a></li>
                      <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                      <?php } ?>
                      <?php } ?>
                      <li class="page-item"><a class="page-link">...</a></li>
                      <li class="page-item"><a class="page-link" href="?pageNum=<?= ($totalNumberOfPages - 1) ?>"><?= ($totalNumberOfPages - 1) ?></a></li>
                      <li class="page-item"><a class="page-link" href="?pageNum=<?= $totalNumberOfPages ?>"><?= $totalNumberOfPages ?></a></li>
                  <?php } else if ($pageNum > 4 && $pageNum < $totalNumberOfPages - 4) { ?>
                    <li class="page-item"><a class="page-link" href="?pageNum=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?pageNum=2">2</a></li>
                    <li class="page-item"><a class="page-link">...</a></li>

                    <?php for ($i = $pageNum - 2; $i <= $pageNum + 2; $i++) : ?>
                      <?php if ($i == $pageNum) { ?>
                        <li class="active page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                      <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                      <?php } ?>
                    <?php endfor; ?>

                    <li class="page-item"><a class="page-link">...</a></li>
                    <li class="page-item"><a class="page-link" href="?pageNum=<?= ($totalNumberOfPages - 1) ?>"><?= ($totalNumberOfPages - 1) ?></a></li>
                    <li class="page-item"><a class="page-link" href="?pageNum=<?= $totalNumberOfPages ?>"><?= $totalNumberOfPages ?></a></li>
                  <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="?pageNum=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?pageNum=2">2</a></li>
                    <li class="page-item"><a class="page-link">...</a></li>

                    <?php for ($i = $totalNumberOfPages - 6; $i <= $totalNumberOfPages; $i++) : ?>
                      <?php if ($i == $pageNum) { ?>
                        <li class="active page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                      <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                      <?php } ?>
                    <?php endfor; ?>

                  <?php } ?>
                <?php }  ?>

                <li class="page-item"><a class="page-link" href="?pageNum=<?= $nextPage ?>" class="page-link">Napred</a></li>
                <li class="page-item"><a class="page-link" href="?pageNum=<?= $totalNumberOfPages ?>" class="page-link">Kraj</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>
</html>
