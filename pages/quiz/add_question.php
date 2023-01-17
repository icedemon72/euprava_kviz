<?php
  session_start();
  require_once('./../../components/navbar.php');
  require_once('./../../auth/settings.php');
  require_once('./../../auth/connect_db.php');
  require_once('./add_question_functions.php');

  $errorMessageEx = '';
  $errorMessageReq = '';
  $successEx = false;
  $successReq = false;
  $requestCategoriesArray = generateCategory($conn);
  $existingCategoriesArray = generateCategory($conn, 'existing');

  $correctAnswersArray = array();
  $wrongAnswersArray = array();

  if(isset($_POST['submitQuestionExisting']) && !isset($_POST['submitQuestionRequest'])) {
    if(!isset($_SESSION['username'])) {
      header('Location: ./../../login.php');
      exit();
    }

    foreach($_POST as $key => $value) {
      if(gettype($value) != 'array') {
        $inputValues[$key] = trim(stripslashes($value));
      }
    }

    $errorsInputs = checkInputFields($existingCategoriesArray, $inputValues);

    foreach($errorsInputs as $err) {
      $errorMessageEx .= '<li>' . $err . '</li>';
    }

    if(sizeof($errorsInputs) == 0) {
      $errorsQuestions = checkQuestionFields($_POST['category_type'], $_POST['correct_answer'], @$_POST['wrong_answer'])['errors'];
      
      if(sizeof($errorsQuestions) == 0) {
        insertQuestion('existing', $inputValues['category_type'], $inputValues['category_name'], $inputValues['question'], $data['correctAnswers'], $data['wrongAnswers'], $conn, $db);
        $successEx = true;
      }

      foreach($errorsQuestions as $err) {
        $errorMessageEx .= '<li>' . $err . '</li>';
      }
    } 

    $inputValues = array();
  } 

  if(isset($_POST['submitQuestionRequest']) && !isset($_POST['submitQuestionExisting'])) {
    if(!isset($_SESSION['username'])) {
      header('Location: ./../../login.php');
      exit();
    }

    foreach($_POST as $key => $value) {
      if(gettype($value) != 'array') {
        $inputValues[$key] = trim(stripslashes($value));
      }
    }

    $errorsInputs = checkInputFields($requestCategoriesArray, $inputValues);

    foreach($errorsInputs as $err) {
      $errorMessageReq .= '<li>' . $err . '</li>';
    }
    
    if(sizeof($errorsInputs) == 0) {
      $data = checkQuestionFields($_POST['category_type'], $_POST['correct_answer'], @$_POST['wrong_answer']);
      $errorsQuestions = $data['errors'];
      
      if(sizeof($errorsQuestions) == 0) {
        insertQuestion('request', $inputValues['category_type'], $inputValues['category_name'], $inputValues['question'], $data['correctAnswers'], $data['wrongAnswers'], $conn, $db);
        $successReq = true;
      }

      foreach($errorsQuestions as $err) {
        $errorMessageReq .= '<li>' . $err . '</li>';
      }
    } 

    $inputValues = array();
  }


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?=$PATH.'/images/favicon.png'?>" type="image/x-icon">
  <link rel="stylesheet" href="<?=$PATH.'/style/bootstrap.min.css'?>">
  <link rel="stylesheet" href="<?=$PATH.'/style/style.css'?>">
  <title>Kvizzi | Dodaj pitanje</title>

</head>

<body>
  <!-- Navbar -->
  <?php
    generateNavbar('kviz', $PATH);
  ?>

  <form method="post">
    <div class="container mt-5">
      <div class="row gutters profile_row shadow rounded overflow-hidden">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="text-center mb-5">
                <h2 class="display-20 display-md-18 display-lg-16 mt-5">Dodaj pitanje u postojeću kategoriju</h2>
              </div>
              <div class="row gutters d-flex justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-8 col-sm-12 ">
                  <h6 class="mb-3 text-center">Naziv kategorije</h6>
                  <select type="text" name="category_name" class="form-select">
                    <option value="defualt">Izaberi kategoriju</option>
                    <?php for($i = 0; $i < sizeof($existingCategoriesArray); $i++){ ?>
                      <option value="<?=$existingCategoriesArray[$i]?>"><?=$existingCategoriesArray[$i]?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row gutters d-flex justify-content-center mt-4">
                <div class="col-xl-4 col-lg-5 col-md-8 col-sm-12 ">
                  <h6 class="mb-3 text-center">Pitanje:</h6>
                  <textarea class="form-control" name="question" placeholder="Unesite pitanje..."></textarea>
                </div>
              </div>
              <div class="row gutters d-flex justify-content-center mt-4">
                <div class="col-xl-4 col-lg-5 col-md-8 col-sm-12 ">
                  <h6 class="mb-3 text-center">Tip pitanja</h6>
                  <select type="text" name="category_type" class="form-select" onchange="generateInputFields(this, 'answersExId')">
                    <option value="0">Izaberi tip</option>
                    <option value="radio">Radio (Jedan odgovor je tačan)</option>
                    <option value="chbox">Checkbox (Mogu više njih biti tačno)</option>
                    <option value="input">Input (Odgovor se unosi sa tastature)</option>
                  </select>
                </div>
              </div>

              <div class="row gutters d-flex justify-content-center mt-4">
                <div id="answersExId" class="col-xl-4 col-lg-5 col-md-8 col-sm-12 "></div>
              </div>

              <div class="d-flex justify-content-center mt-4">
                <input type="submit" class="btn btn-primary reg_btn" value="Pošalji pitanje!" name="submitQuestionExisting" />
              </div>
              <?php if ($errorMessageEx != '') : ?>
                <div class="row d-flex justify-content-center my-3">
                  <div class="d-flex col-lg-4 justify-content-center mx-4 alert alert-danger" role="alert">
                    <ul class="errors"><?= @$errorMessageEx ?></ul>
                  </div>
                </div>
              <?php endif;
              if ($successEx) : ?>
                <div class="row d-flex justify-content-center my-3">
                  <div class="d-flex col-lg-4 justify-content-center mx-4 alert alert-success" role="alert">
                    <p class="success"><?= 'Uspešno dodavanje, redirektujem na početnu...' ?></p>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post">
    <div class="container mt-5 mb-5">
      <div class="row gutters profile_row shadow rounded overflow-hidden">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card h-100">
            <div class="card-body">
              <div class="text-center mb-5">
                <h2 class="display-20 display-md-18 display-lg-16 mt-5">Dodaj pitanje u kategoriju u razmatranju</h2>
              </div>
              <div class="row gutters d-flex justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-8 col-sm-12 ">
                  <h6 class="mb-3 text-center text-primary text-center">Naziv kategorije</h6>
                  <select type="text" name="category_name" class="form-select ">
                    <option name="defualt">Izaberi kategoriju</option>
                    <?php for($i = 0; $i < sizeof($requestCategoriesArray); $i++){ ?>
                      <option name="<?=$i?>"><?=$requestCategoriesArray[$i]?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="row gutters d-flex justify-content-center mt-4">
                <div class="col-xl-4 col-lg-5 col-md-8 col-sm-12 ">
                  <h6 class="mb-3 text-center">Pitanje:</h6>
                  <textarea class="form-control" name="question" placeholder="Unesite pitanje..."></textarea>
                </div>
              </div>

              <div class="row gutters d-flex justify-content-center mt-4">
                <div class="col-xl-4 col-lg-5 col-md-8 col-sm-12 ">
                  <h6 class="mb-3 text-center">Tip pitanja</h6>
                  <select type="text" name="category_type" class="form-select" onchange="generateInputFields(this, 'answersReqId')">
                    <option value="0">Izaberi tip</option>
                    <option value="radio">Radio (Jedan odgovor je tačan)</option>
                    <option value="chbox">Checkbox (Mogu više njih biti tačno)</option>
                    <option value="input">Input (Odgovor se unosi sa tastature)</option>
                  </select>
                </div>
              </div>

              <div class="row gutters d-flex justify-content-center mt-4">
                <div id="answersReqId" class="col-xl-4 col-lg-5 col-md-8 col-sm-12 "></div>
              </div>

              <div class="d-flex justify-content-center mt-4">
                <input type="submit" class="btn btn-primary reg_btn" value="Pošalji kategoriju!" name="submitQuestionRequest" />
              </div>
              <?php if ($errorMessageReq != '') : ?>
                <div class="row d-flex justify-content-center my-3">
                  <div class="d-flex col-lg-4 justify-content-center mx-4 alert alert-danger" role="alert">
                    <ul class="errors"><?= @$errorMessageReq; ?></ul>
                  </div>
                </div>
              <?php endif;
              if ($successReq) : ?>
                <div class="row d-flex justify-content-center my-3">
                  <div class="d-flex col-lg-4 justify-content-center mx-4 alert alert-success" role="alert">
                    <p class="success"><?= 'Uspešno dodavanje, redirektujem na početnu...' ?></p>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?php if ($successEx || $successReq) : ?>
    <script>
      window.setTimeout(x => {
        window.location = "./../../index.php";
      }, 1000);
      window.history.replaceState(null, null, window.location.href);
    </script>
  <?php endif; ?> 

  <script src="<?=$PATH.'/scripts/script.js'?>"></script>
  <script src="<?=$PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
</body>

</html>