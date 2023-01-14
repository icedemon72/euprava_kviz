<?php
session_start();
require_once('./../../components/navbar.php');
require_once('./../../auth/settings.php');
require_once('./../../auth/connect_db.php');
require_once('./add_category_functions.php');

$success = false;
$errorMessage = '';
$inputValues = array();
if(isset($_POST['submitCategory'])) {
  if(!isset($_SESSION['username'])) {
    header('Location: ./../../login.php');
    exit();
  } 
  foreach($_POST as $key => $value) {
    $inputValues[$key] = trim(stripslashes($value));
  }

  $errors = checkIfValidCategory($inputValues, $conn);

  foreach($errors as $err) {
    $errorMessage .= '<li>' . $err . '</li>';
  }

  if(sizeof($errors) == 0) { // no user input errors
    insertCategoryRequest($inputValues, $conn);
    $success = true;
    $inputValues = array();
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
  <title>Kvizzi | Dodaj kategoriju</title>

</head>

<body>
  <!-- Navbar -->
  <?php
  generateNavbar('kviz', $PATH);
  ?>
  <div class="text-center mb-5">
    <h2 class="display-20 display-md-18 display-lg-16 mt-5">Dodaj kategoriju</h2>
  </div>

  <form method="post">
    <div class="container mt-5">
      <div class="row gutters profile_row shadow rounded overflow-hidden">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="row gutters d-flex justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-8 col-sm-12 ">
                  <h6 class="mb-3 text-center text-primary text-center">Naziv kategorije</h6>
                  <input type="text" name="category_name" class="form-control" />
                </div>
              </div>
              <div class="row gutters d-flex justify-content-center mt-4">
                <div class="col-xl-4 col-lg-5 col-md-8 col-sm-12 ">
                  <h6 class="mb-3 text-center text-primary text-center">Opis kategorije</h6>
                  <textarea class="form-control" name="category_desc" placeholder="Opišite kategoriju, navedite neki primer i sl."></textarea>
                </div>
              </div>

              <div class="d-flex justify-content-center mt-4">
                <input type="submit" class="btn btn-primary reg_btn" value="Pošalji kategoriju!" name="submitCategory" />
              </div>
              <?php if ($errorMessage != '') : ?>
                <div class="row d-flex justify-content-center my-3">
                  <div class="d-flex col-lg-4 justify-content-center mx-4 alert alert-danger" role="alert">
                    <ul class="errors"><?= @$errorMessage; ?></ul>
                  </div>
                </div>
              <?php endif;
              if ($success) : ?>
                <div class="row d-flex justify-content-center my-3">
                  <div class="d-flex col-lg-4 justify-content-center mx-4 alert alert-success" role="alert">
                    <p class="success"><?= 'Uspešno ažuriranje, redirektujem na profil...' ?></p>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <?php if ($success) : ?>
    <script>
      window.setTimeout(x => {
        window.location = "./add_question.php";
      }, 1000);
      window.history.replaceState(null, null, window.location.href);
    </script>
  <?php endif; ?>


  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>

</html>