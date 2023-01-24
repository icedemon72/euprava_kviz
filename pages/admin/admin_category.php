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


$countedCategories = countCategoryRequests($conn);

if (isset($_GET['pageNum']) && $_GET['pageNum'] != '') {
  $pageNum = $_GET['pageNum'];
} else {
  $pageNum = 1;
}

if ($pageNum < 1) {
  $pageNum = 1;
}

$totalNumberOfPages = ceil($countedCategories / 5);

$prevPage = $pageNum - 1;
if ($prevPage < 1) {
  $prevPage = $pageNum;
}

$nextPage = $pageNum + 1;
if ($nextPage > $totalNumberOfPages) {
  $nextPage = $totalNumberOfPages;
}

$categoryInfo = getCategoryRequests(5, ($pageNum - 1) * 5, $conn);

$requests = array();

foreach($_POST as $key => $value) {
  array_push($requests, $key);
}
if(sizeof($requests) > 0 ) {
  $index = explode('_', $requests[0])[1];
  $method = explode('_', $requests[0])[0];
  if($method == 'add') {
    addCategoryById($categoryInfo['id'][$index], $_SESSION['username'], $conn);
    header("Refresh:0"); 
  } else if ($method == 'delete') {
    setStatusToZeroById($id, $conn);
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
  <link rel="stylesheet" href="<?= $PATH . '/style/style_admin.css' ?>">
  <title>Kvizzi | Admin Panel - Kategorije</title>

</head>

<body>
  <!-- Navbar -->
  <?php generateNavbar('', $PATH); ?>

  <div class="container-fluid mt-5 mb-5">
    <h5 class="mb-5 text-center">Kategorije</h5>
    <?php for ($i = 0; $i < sizeof($categoryInfo['id']); $i++) : ?>
      <div class="container-fluid mb-3 mt-3">
        <div class="row d-flex justify-content-center">
          <div class="col-sm-10 col-md-6 col-lg-4 col-xl-3 shadow rounded admin_category_container">
            <div class="row mt-3 mx-4">
              <b class="text-center"><?= $categoryInfo['name'][$i] ?></b>
            </div>
            <div class="row mt-3 mx-4">
              <span class="text-center"><?= $categoryInfo['description'][$i] ?></span>
            </div>
            <div class="container-fluid d-flex justify-content-center">
              <form method="POST">
                <input class="btn my-2 btn-block change_profile_btn" type="submit" name="delete_<?= $i ?>" value="Obriši kategoriju">
                <input class="btn my-2 btn-block edit_profile_btn" type="submit" name="add_<?= $i ?>" value="Dodaj kategoriju">
              </form>
            </div>
          </div>
        </div>
      </div>

    <?php endfor; ?>
  </div>

  <div class="container">
    <div class="row d-flex justify-content-center">
      <p class="text-center">Pronadjeno <?= $countedCategories ?> kategorija</p>
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

  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>

</html>