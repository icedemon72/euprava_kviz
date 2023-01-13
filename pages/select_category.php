<?php
session_start();
require_once('./../components/navbar.php');
require_once('./../auth/settings.php');
require_once('./../auth/connect_db.php');
require_once('./select_category_functions.php');
$categories = getCategories($conn);
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
  <title>Kvizzi | Odabir kategorije</title>
</head>

<body>
  <?php
  generateNavbar('kviz', $PATH);
  ?>

  <section>
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="display-20 display-md-18 display-lg-16 mt-5">Kategorije</h2>
      </div>

      <div class="row">
        <?php for($i = 0; $i < sizeof($categories['id']); $i++) { ?>
          <div class="col-sm-12 col-md-6 col-lg-4 mb-1-9 mb-lg-0 card_category">
            <div class="team-style1 hoverstyle1">
              <div class="team-img">
                <img class="w-100" src="<?= $PATH.'/images'.'/'.$categories['image'][$i] ?>" alt="Slika kategorije">
              </div>
              <div class="team-info">
                <h6 class="h5"><?= $categories['name'][$i] ?></h6>
                <small>Puta igrano: <?= $categories['times_played'][$i] ?></small>
                <small>Prosečna ocena: <?= $categories['score'][$i] ?></small>
              </div>
            </div>
          </div>
        <?php } ?>
        <div class="col-sm-12 col-md-6 col-lg-4 mb-sm-3 mb-lg-0 card_category" onclick="window.location.href='<?=$PATH.'/pages/quiz/add_category.php'?>'" >
            <div class="team-style1 hoverstyle1">
              <div class="team-img">
                <img class="w-100" src="<?= $PATH.'/images/categories/add.jpg' ?>" alt="Dodaj sliku">
              </div>
              <div class="team-info">
                <h6>Dodaj kategoriju</h6>
                <small>Imaš ideju?</small>
                <small>Pošalji je!</small>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>

  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>

</html>