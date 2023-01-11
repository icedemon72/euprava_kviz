<?php 
  session_start();
  if (isset($_SESSION['username'])) {
    header('Location: ./index.php');
    exit();
  }

  require_once('./auth/connect_db.php');
  require_once('./components/navbar.php');
  require_once('./login_functions.php');
  require_once('./auth/settings.php');

  $inputvalues = array();
  $errors = array();
  $errorMessage = '';
  $success = false;

  if (isset($_POST['logBtn'])) {
    foreach($_POST as $key => $value) {
      $inputValues[$key] = trim(stripslashes($value));
    }
  
    $errors = checkIfValidInputLogin($inputValues, $conn);

    foreach($errors as $err) {
      $errorMessage .= '<li>' . $err . '</li>';
    }

    if(sizeof($errors) == 0) { // no user input errors
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
  <link rel="stylesheet" href="<?=$PATH.'/style/bootstrap.min.css'?>">
  <link rel="stylesheet" href="<?=$PATH.'/style/style.css'?>">
  <title>Kvizzi | Prijava</title>
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
                <div class="col-lg-6 col-md-8 col-sm-10 order-2 order-lg-1">
                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4 reg_text">Prijava</p>
                  <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post" class="mx-1 mx-md-4">
                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formUname" >Korisničko ime</label>
                        <input type="text" id="formUname" class="form-control" name="uname" value="<?=htmlspecialchars(@$inputValues['uname'])?> " oninvalid="setCustomValidity('Unesite korisničko ime.')" autofocus/>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="formPass" >Lozinka</label>
                        <input type="password" id="formPass" class="form-control" name="pass" value="<?=htmlspecialchars(@$inputValues['pass']) ?>" oninvalid="setCustomValidity('Unesite lozinku.')" />
                      </div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <small id="pwHelp" class="form-text text-muted">Nemaš nalog? <a class="reg_link" href="<?=$PATH.'/register.php'?>">Registruj se</a></small>
                    </div> 

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <input type="submit" class="btn btn-primary btn-lg reg_btn" value="Prijavi se!" name="logBtn"/>
                    </div> 
                    
                  <?php if ($errorMessage != ''): ?>
                    <div class="d-flex justify-content-center mx-4 mb-lg-4 alert alert-danger" role="alert">
                      <ul class="errors"><?=@$errorMessage; ?></ul>
                    </div>
                  <?php endif; if ($success): ?> 
                    <div class="d-flex justify-content-center mb-lg-4 alert alert-success" role="alert">
                      <p class="success"><?='Uspešna prijava, redirektujem na početnu...' ?></p>
                    </div>
                  <?php endif; ?>
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
        window.location = "<?=$PATH.'/index.php'?>";
      }, 1000);
      window.history.replaceState(null, null, window.location.href);
    </script>
  <?php endif; ?>

  <script src="<?=$PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
  <script src="<?=$PATH.'/scripts/script.js'?>"></script>
</body>

</html>