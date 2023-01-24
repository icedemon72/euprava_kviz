<?php
session_start();
require_once('./../../components/navbar.php');
require_once('./../../components/footer.php');
require_once('./../../auth/settings.php');
require_once('./../../auth/connect_db.php');
require_once('./search_functions.php');

if (!isset($_GET['search'])) {
  header('Location: ./../../index.php');
  die();
}

$searchInfo = getResults($_GET['search'], $conn);

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
  <title>Kvizzi | Pretraga "<?= $_GET['search'] ?>"</title>
</head>

<body class="d-flex flex-column min-vh-100">
  <?php generateNavbar('', $PATH); ?>

  <div class="container-fluid mt-5 mb-5">
    <h5 class="mb-5 text-center">Rezultati pretrage:</h5>
    <?php if (sizeof($searchInfo['username']) == 0) : ?>
      <h6 class="mb-5 text-center">Nema pronadjenih rezultata :(</h6>
    <?php endif; ?>
    <div class="row d-flex justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="row d-flex justify-content-center">
          <?php for ($i = 0; $i < sizeof($searchInfo['username']); $i++) { ?>
            <div class="col-xs-12 col-sm-6 col-md-6 mb-3">
              <section>
                <div class="container search_profile" onclick="window.location.href='<?=$PATH.'/pages/profile/profile.php?user='.$searchInfo['username'][$i]?>'">
                  <div class="card shadow">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <img src="<?= $PATH . '/images/account_image.png' ?>" class="w-100 w-xs-50">
                      </div>
                      <div class="col-md-6 col-sm-9 col-xs-6 m-auto">
                        <div class="card-block">
                          <h6 class="card-title text-center"><?= $searchInfo['username'][$i] ?></h6>
                          <p class="text-center"><?= $searchInfo['first_name'][$i] . ' ' . $searchInfo['last_name'][$i] ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <?php generateFooter($PATH); ?>
  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>

</html>