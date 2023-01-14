<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ./../../login.php');
  exit();
}

require_once('./../../components/navbar.php');
require_once('./../../auth/settings.php');
require_once('./../../auth/connect_db.php');
require_once('./my_profile_functions.php');
require_once('./settings_functions.php');

$userInfo = getInfoFromUser($_SESSION['username'], $conn);
$errorMessage = '';
$success = false;
$inputValues = array();
if (isset($_POST['update'])) {
  
  foreach ($_POST as $key => $value) {
    $inputValues[$key] = trim(stripslashes($value));
  }
  
    $errors = checkInput($inputValues, $userInfo, $conn);

    foreach ($errors as $err) {
      $errorMessage .= '<li>' . $err . '</li>';
    }

    if (sizeof($errors) == 0) { // no user input errors
      $check1 = false;
      $check2 = false;
      if(anyChanges($inputValues, $userInfo)) {
        updateUser($inputValues, $conn);
        $check1 = true;
      } 
      if(anyChangesPassword($inputValues['password'], $inputValues['new_password'])) {
        updateUserPassword($inputValues['new_password'], $conn); 
        $check2 = true;
      }
      $success = $check1 || $check2;
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
  <title>Kvizzi | Podešavanja profila</title>

</head>

<body>
  <!-- Navbar -->
  <?php
  generateNavbar('', $PATH);
  ?>
  <form method="post">
    <div class="container mt-5">
      <div class="row gutters profile_row shadow rounded overflow-hidden">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="account-settings">
                <div class="user-profile">
                  <div class="user-avatar">
                    <img src="<?= $PATH . '/images/account_image.png' ?>" alt="Profilna slika">
                  </div>
                  <h5 class="user-name"><?= $userInfo['first_name'] . ' ' . $userInfo['last_name'] ?></h5>
                  <h6 class="user-email"><?= $userInfo['email'] ?></h6>
                </div>
                <div class="about">
                  <h6 class="mb-2 text-primary">O meni</h6>
                  <textarea id="description" name="description"><?= $userInfo['description'] ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <h6 class="mb-3 text-primary">Lični detalji</h6>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="first">Ime</label>
                    <input type="text" class="form-control" id="firstname" value="<?= $userInfo['first_name'] ?>" name="first_name" />
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="lastname">Prezime</label>
                    <input type="text" class="form-control" id="lastname" value="<?= $userInfo['last_name'] ?>" name="last_name" />
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" value="<?= $userInfo['email'] ?>" name="email" />
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="date_of_birth">Datum rodjenja</label>
                    <input type="date" class="form-control" id="date_of_birth" value="<?= (new DateTime($userInfo['date_of_birth']))->format('Y-m-d') ?>" name="date_of_birth" />
                  </div>
                </div>
              </div>
              <div class="row gutters mt-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <h6 class="text-primary">Promena lozinke</h6>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="oldpassword">Stara lozinka</label>
                    <input type="password" class="form-control" id="oldpassword" name="password" />
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="new_password">Nova lozinka</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" />
                    <small class="form-text text-muted">Lozinka mora sadržati bar 6 karaktera.</small>
                  </div>
                </div>
              </div>
              <div class="row mb-4 gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="text-right">
                    <a href="<?= $PATH . '/pages/profile/my_profile.php' ?>" class="btn mt-2 btn-block edit_profile_btn">Nazad</a>
                    <input type="submit" id="submit" name="update" class="change_profile_btn mt-2 btn btn-block" value="Ažuriraj" />
                  </div>
                </div>
              </div>
              <?php if ($errorMessage != '') : ?>
                <div class="d-flex justify-content-center mx-4 alert alert-danger" role="alert">
                  <ul class="errors"><?= @$errorMessage; ?></ul>
                </div>
              <?php endif; if ($success) : ?>
                <div class="d-flex justify-content-center mt-4 alert alert-success" role="alert">
                  <p class="success"><?= 'Uspešno ažuriranje, redirektujem na profil...' ?></p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <?php if($success): ?>
    <script>
      window.setTimeout(x => { 
        window.location = "./my_profile.php";
      }, 1000);
      window.history.replaceState(null, null, window.location.href);
    </script>
  <?php endif; ?>
  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>

</html>