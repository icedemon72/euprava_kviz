<?php
session_start();
require_once('./components/navbar.php');
require_once('./components/footer.php');
require_once('./auth/settings.php');
require_once('./auth/connect_db.php');
require_once('./index_functions.php');

$welcomeMessage = '';

if (isset($_SESSION['username'])) {
  $welcomeMessage = ', ' . $_SESSION['username'] . ',';
}

$infoArray = getAverageInfo($conn);
$statsInfo = getTopResults($conn);

$averageAchievementImageSrc = $PATH.'/images/achievements/trophy_bronze.png';

if($infoArray['averageAchievementCompletion'] >= 70) {
  $averageAchievementImageSrc = $PATH.'/images/achievements/trophy_gold.png';
} else if ($infoArray['averageAchievementCompletion'] >= 30) {
$averageAchievementImageSrc = $PATH.'/images/achievements/trophy_silver.png';
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
  <title>Kvizzi | Početna</title>

</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <?php generateNavbar('pocetna', $PATH) ?>

  <div class="container-fluid mt-5">
    <div class="row">
      <h5 class="mb-3">Dobrodošli<?= $welcomeMessage ?> na KVIZZI!</h5>
    </div>
  </div>
  <hr>
  <div class="container-fluid mt-5">
    <div class="row d-flex justify-content-center">
      <div class="col-xs-12 col-sm-11 col-md-6 col-lg-4 col-xl-4 d-flex justify-content-center mb-3">
        <div class="card shadow home_card" style="width: 20rem;">
          <img src="<?= $PATH.'/images/questions.png' ?>" class="card-img-top mt-3" alt="Pitanja slika">
          <div class="card-body">
            <h5 class="card-title">Pitanja</h5>
            <p class="card-text">Naši kvizovi trenutno imaju <b><?= $infoArray['questionsNumber'] ?></b> validnih pitanja!</p>
            <a href="<?= $PATH.'/pages/select_category.php' ?>" class="btn mt-2 btn-block edit_profile_btn">Igraj kviz!</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-11 col-md-6 col-lg-4 col-xl-4 d-flex justify-content-center mb-3">
        <div class="card shadow home_card" style="width: 20rem;">
          <img src="<?= $PATH.'/images/users.png' ?>" class="card-img-top mt-3" alt="Korisnici slika">
          <div class="card-body shadow">
            <h5 class="card-title">Korisnici</h5>
            <p class="card-text">Naš sajt trenutno ima <b><?= $infoArray['usersNumber'] ?></b> registrovanih korisnika!</p>
            <?php if(!isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/register.php' ?>" class="btn mt-2 btn-block edit_profile_btn">Postani član!</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/pages/about_us.php' ?>" class="btn mt-2 btn-block edit_profile_btn">Kontaktirajte nas!</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-11 col-md-6 col-lg-4 col-xl-4 d-flex justify-content-center mb-3">
        <div class="card shadow home_card" style="width: 20rem;">
          <img src="<?= $PATH.'/images/times_played.png' ?>" class="card-img-top mt-3" alt="Broj igranja slika">
          <div class="card-body">
            <h5 class="card-title">Broj igranja</h5>
            <p class="card-text">Naši kvizovi su trenutno odigrani <b><?= $infoArray['quizPlayed'] ?></b> puta!</p>
            <?php if(!isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/register.php' ?>" class="btn mt-2 btn-block edit_profile_btn">Postani član i odigraj!</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/pages/profile/my_profile.php#averageResult:~:text=Kvizova%20odigrano' ?>" class="btn mt-2 btn-block edit_profile_btn">Vidi tvoj broj igranja!</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-11 col-md-6 col-lg-4 col-xl-4 d-flex justify-content-center mb-3">
        <div class="card shadow home_card" style="width: 20rem;">
          <img src="<?= $PATH.'/images/average_score.png' ?>" class="card-img-top mt-3" alt="Prosečan rezultat slika">
          <div class="card-body">
            <h5 class="card-title">Prosek</h5>
            <p class="card-text">Prosečan rezultat svih odigranih kvizova je: <b><?= $infoArray['scoreAverage'] ?></b>!</p>
            <?php if(!isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/register.php' ?>" class="btn mt-2 btn-block edit_profile_btn">Postani član i odigraj!</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/pages/profile/my_profile.php#averageResult:~:text=Prose%C4%8Dna%20ocena' ?>" class="btn mt-2 btn-block edit_profile_btn">Vidi svoj rezultat!</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-11 col-md-6 col-lg-4 col-xl-4 d-flex justify-content-center mb-3">
        <div class="card shadow home_card" style="width: 20rem;">
          <img src="<?= $PATH.'/images/achievements/star_gold.png' ?>" class="card-img-top mt-3" alt="Broj dostignuća slika">
          <div class="card-body">
            <h5 class="card-title">Dostignuća</h5>
            <p class="card-text">Naš kviz trenutno ima <b><?= $infoArray['achievementsNumber'] ?></b> dostignuća! Osvoji ih sve!</p>
            <?php if(!isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/register.php' ?>" class="btn mt-2 btn-block edit_profile_btn">Postani član i osvoji ih!</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/pages/profile/my_profile.php#achievementsSection' ?>" class="btn mt-2 btn-block edit_profile_btn">Vidi svoja dostignuća!</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-11 col-md-6 col-lg-4 col-xl-4 d-flex justify-content-center mb-3">
        <div class="card shadow home_card" style="width: 20rem;">
          <img src="<?= $averageAchievementImageSrc ?>" class="card-img-top mt-3" alt="Prosecan rezultat slika">
          <div class="card-body">
            <h5 class="card-title">Procenat osvojenih dostignuća</h5>
            <p class="card-text">Svaki korisnik je u proseku otključao <b><?= $infoArray['averageAchievementCompletion'] ?>%</b> dostignuća!</p>
            <?php if(!isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/register.php' ?>" class="btn mt-2 btn-block edit_profile_btn">Postani član i osvoji ih!</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['username'])):?>
              <a href="<?= $PATH.'/pages/profile/my_profile.php#achievementsSection' ?>" class="btn mt-2 btn-block edit_profile_btn">Vidi svoja dostignuća!</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid mt-5 mb-5">
    <div class="row d-flex justify-content-center">
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 col-xl-5">
        <h5 class="text-center">Top 3 rezultata</h5>
        <table class="table table-striped table-responsive">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Korisničko ime</th>
              <th scope="col">Ime i prezime</th>
              <th scope="col">Prosečan rezultat</th>
              <th scope="col">Profil</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i = 0; $i < sizeof($statsInfo['username']); $i++) {?>
              <tr>
                <th ><?= ($i + 1) ?></th>
                <td title="<?= $statsInfo['username'][$i] ?>"><?= shortenString($statsInfo['username'][$i]) ?></td>
                <td><?= shortenString($statsInfo['name'][$i], 30) ?></td>
                <td scope="row"><?= $statsInfo['result'][$i] ?></td>
                <td><a class="stats_link" href="<?=$PATH.'/pages/profile/profile.php?user='.$statsInfo['username'][$i] ?>">[&#8594;]</a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <h6 class="h6_link text-muted" onclick="window.location.href='<?= $PATH.'/pages/stats.php' ?>'">Vidi ostale?</h6>
      </div>
    </div>
  </div>

  <?php generateFooter($PATH) ?>


  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>

</html>