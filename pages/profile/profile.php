<?php
  session_start();
  require_once('./../../components/navbar.php');
  require_once('./../../auth/settings.php');
  require_once('./../../auth/connect_db.php');
  require_once('./my_profile_functions.php');

  if($_GET['user'] == $_SESSION['username']) {
    header('Location: ./my_profile.php');
  }

  $userId = getIdByUser($_GET['user'], $conn);

  if(!$userId || !isset($_GET['user'])) {
    header("HTTP/1.0 404 Not Found");
    die();
  }

  $userInfo = getInfoFromUser($_GET['user'], $conn);
  $quiz = getQuizDetails($_GET['user'], $conn);
  $achievements = getAchievements($_GET['user'], $conn);
  $questionCount = getAddedQuestions($_GET['user'], $conn);

  

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $PATH . '/style/bootstrap.min.css' ?>">
  <link rel="stylesheet" href="<?= $PATH . '/style/style.css' ?>">
  <title>Kvizzi | <?=$_GET['user']?></title>
</head>
<body>
  <?php
    generateNavbar('', $PATH);
  ?>
  <div class="row profile_row py-5 px-4">
    <div class="col-md-10 col-lg-8 col-xl-6 mx-auto"> <!-- Profile widget -->
      <div class="bg-white shadow rounded overflow-hidden">
        <div class="px-4 pt-0 pb-4 cover" style="background-image: url(<?= $PATH . '/images/reg_quiz.jpg' ?>)">
          <div class="media align-items-end profile-head">
            <div class="profile mr-3">
              <img src="<?= $PATH . '/images/account_image.png' ?>" alt="Profilna slikac" width="130" class="rounded mb-2 img-thumbnail">
            </div>
            <div class="media-body mb-5">
              <h4 class="mt-0 mb-0 pb-3 profile_name"><?= $userInfo['first_name'] ?> <?= $userInfo['last_name'] ?></h4>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <div class="p-4 d-flex justify-content-start text-center">
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                <h5 class="font-weight-bold mb-0 d-block"><?= $userInfo['registration_date'] ?></h5><small class="text-muted">Nalog kreiran</small>
              </li>
              <li class="list-inline-item">
                <h5 class="font-weight-bold mb-0 d-block"><?= $userInfo['last_log_in'] ?></h5><small class="text-muted">Poslednji put aktivan</small>
              </li>
              <li class="list-inline-item">
                <h5 class="font-weight-bold mb-0 d-block"><?= $userInfo['date_of_birth'] ?></h5><small class="text-muted">Datum rodjenja</small>
              </li>
            </ul>
          </div>
          <div class="p-4 d-flex justify-content-end text-center">
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                <h5 class="font-weight-bold mb-0 d-block"><?= $quiz ?></h5><small class="text-muted">Kvizova odigrano</small>
              </li>
              <li class="list-inline-item">
                <h5 class="font-weight-bold mb-0 d-block"><?=$questionCount?></h5><small class="text-muted">Pitanja dodato</small>
              </li>
              <li class="list-inline-item">
                <h5 class="font-weight-bold mb-0 d-block">0</h5><small class="text-muted">Prosečna ocena</small>
              </li>
            </ul>
          </div>
        </div>
        <div class="px-4 py-3">
          <h5 class="mb-0">O meni</h5>
          <div class="p-4 rounded shadow-sm bg-light">
            <p class="font-italic mb-0"><?= $userInfo['description'] ?></p>
          </div>
        </div>
        <div class="px-4 py-3">
        <h5 class="mb-0">Dostignuća</h5>
        </div>
        <?php for ($i = 0; $i < sizeof($achievements['title']); $i++) : ?>
          <?php
            $class = 'achievement_locked';
            if($achievements['hasAchievement'][$i]){
              $class = 'achievement_unlocked';
            }  
          ?>
          <section>
            <div class="container">
              <div class="card">
                <div class="row <?=$class?>">
                  <div class="col-md-1 col-sm-3 col-xs-3">
                    <img src="<?=$PATH.'/images/achievements/'.$achievements['image'][$i]?>" class="w-100 w-xs-50">
                  </div>
                  <div class="col-md-11 col-sm-9 col-xs-6">
                    <div class="card-block">
                      <h6 class="achievement_title card-title"><?= ($achievements['title'][$i]) ?></h6>
                      <div class="d-lg-flex justify-content-between inline">
                        <p><?= ($achievements['description'][$i]) ?></p>
                        <?php if($class='achievement_unlocked'): ?>
                          <small class="text-muted"><?= $achievements['dateUnlocked'][$i]?></small>
                        <?php endif; ?>
                      </div>
                      
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </section>
        <?php endfor; ?>

        <div class="py-4 px-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Pokušaji kvizzivanja</h5><a href="#" class="btn btn-link text-muted">Prikaži sve</a>
          </div>
          <div class="row">
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
  

</body>
</html>