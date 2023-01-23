<?php
  session_start();
  require_once('./components/navbar.php');
  require_once('./components/footer.php');
  require_once('./auth/settings.php');

  $welcomeMessage = '';

  if(isset($_SESSION['username'])) {
    $welcomeMessage = ', ' . $_SESSION['username'] . ',';
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
  <title>Kvizzi | Početna</title>

</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <?php generateNavbar('pocetna', $PATH) ?>

  <div class="container-fluid mt-5">
    <div class="row">
      <h5 class="mb-3">Dobrodošli<?= $welcomeMessage ?> na plod naše ljubavi - KVIZZI!</h5>
    </div>
  </div>
  
  <?php generateFooter($PATH) ?>


  <script src="<?=$PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
</body>

</html>