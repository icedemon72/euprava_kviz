<?php
  session_start();
  if (isset($_SESSION['username'])) {
    header('Location: ./index.php');
    exit();
  }

  require_once('./auth/connect_db.php');
  require_once('./components/navbar.php');
  require_once('./register_functions.php');
  require_once('./auth/settings.php');

  $errors = array();
  $errorMessage = '';
  $inputValues = array();
  $success = false;

  if (isset($_POST['regBtn'])) {
    foreach($_POST as $key => $value) {
      $inputValues[$key] = trim(stripslashes($value));
    }
  
    $errors = checkIfValidInput($inputValues, $conn);

    foreach($errors as $err) {
      $errorMessage .= '<li>' . $err . '</li>';
    }

    if(sizeof($errors) == 0) { // no user input errors
      registerUser($inputValues, $conn);
      $inputValues = array();
      $success = true;
    }
        
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?php echo $PATH.'/images/favicon.png'?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo $PATH.'/style/bootstrap.min.css'?>">
  <link rel="stylesheet" href="<?php echo $PATH.'/style/style.css'?>">
  <title>Kvizzi | Registracija</title>
</head>
<body class="reg_body"> 
  <?php generateNavbar('', $PATH) ?>
  <section>
    <div class="container">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card registration_container">
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 reg_text">Registracija</p>
                  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="mx-1 mx-md-4">
                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formUsername" >Korisničko ime</label>
                        <input type="text" id="formUsername" class="form-control" name="username" value="<?php echo htmlspecialchars(@$inputValues['username']) ?>" oninvalid="setCustomValidity('Unesite korisničko ime.')" />
                        <small id="unHelp" class="form-text text-muted">Korisničko ime mora sadržati bar 3 karaktera i ne sme sadržati razmake, niti specijalne karaktere (osim tačke, donje crte i minusa)...</small>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formEmail" >Vaša E-mail adresa</label>
                        <input type="email" id="formEmail" class="form-control" name="email" value="<?php echo htmlspecialchars(@$inputValues['email']) ?>"  oninvalid="setCustomValidity('Unesite e-mail.')" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formPassword" >Lozinka</label>
                        <input type="password" id="formPassword" class="form-control" name="password" value="<?php echo htmlspecialchars(@$inputValues['password']) ?>" required oninvalid="setCustomValidity('Unesite lozinku.')" />
                        <small id="pwHelp" class="form-text text-muted">Lozinka mora sadržati bar 6 karaktera.</small>
                      </div>
                    </div>
                    
                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formRepeatPaswword">Ponovite lozinku</label>
                        <input type="password" id="formRepeatPassword" class="form-control" name="repeat_password"  required oninvalid="setCustomValidity('Unesite lozinku.')" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formName">Ime</label>
                        <input type="text" id="formName" class="form-control" name="firstname" value="<?php echo htmlspecialchars(@$inputValues['firstname']) ?>" required oninvalid="setCustomValidity('Unesite ime.')" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formLastName">Prezime</label>
                        <input type="text" id="formLastName" name="lastname" class="form-control" value="<?php echo htmlspecialchars(@$inputValues['lastname']) ?>"  required oninvalid="setCustomValidity('Unesite prezime.')" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formDate">Datum rodjenja</label>
                        <input type="date" id="formDate" class="form-control" name="dob" value="<?php echo htmlspecialchars(@$inputValues['dob']) ?>" required oninvalid="setCustomValidity('Unesite datum.')" />
                      </div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <small id="pwHelp" class="form-text text-muted">Imaš nalog? <a class="reg_link" href="<?php echo $PATH.'/login.php'?>">Prijavi se</a></small>
                    </div> 

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <input type="submit" class="btn btn-primary btn-lg reg_btn" value="Registruj se!" name="regBtn"/>
                    </div> 
                  </form>
                  <?php if ($errorMessage != ''): ?>
                    <div class="d-flex justify-content-center mx-4 mb-lg-4 alert alert-danger" role="alert">
                      <ul class="errors"><?php echo @$errorMessage; ?></ul>
                    </div>
                  <?php endif; if ($success): ?> 
                    <div class="d-flex justify-content-center mb-lg-4 alert alert-success" role="alert">
                      <p class="success"><?php echo 'Uspešna registracija, redirektujem na login...' ?></p>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                  <img src="./images/reg_quiz.jpg" class="img-fluid reg_image" alt="Slika registracije">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php if($success): ?>
    <script>
      window.setTimeout(x => { 
        window.location = "./login.php";
      }, 1000);
      window.history.replaceState(null, null, window.location.href);
    </script>
  <?php endif; ?>
  <script src="<?php echo $PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
  <script src="<?php echo $PATH.'/scripts/script.js'?>"></script>
</body>

</html>

