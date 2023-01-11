<?php
  session_start();
  require_once('./../../components/navbar.php');
  require_once('./../../auth/settings.php');
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
  <title>Kvizzi | Podešavanja profila</title>

</head>

<body>
  <!-- Navbar -->
  <?php
    generateNavbar('', $PATH);
    
  ?>

  <script src="<?php echo $PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
</body>

</html>