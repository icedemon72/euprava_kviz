<?php
  session_start();
  require_once('./components/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/kviz/images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="/kviz/style/bootstrap.min.css">
  <link rel="stylesheet" href="/kviz/style/style.css">
  <title>Kvizzi | Početna</title>

</head>

<body>
  <!-- Navbar -->
  <?php
    generateNavbar('pocetna');
  ?>

  <script src="/kviz/scripts/bootstrap.bundle.min.js"></script>
</body>

</html>