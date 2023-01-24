<?php
session_start();
if (!$_SESSION['admin'] || !isset($_SESSION['username'])) {
  header('Location: ./../../index.php');
  exit();
}

require_once('./../../auth/connect_db.php');
require_once('./../../components/navbar.php');
require_once('./../../components/footer.php');
require_once('./../../auth/settings.php');
require_once('./admin_panel_functions.php');

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
  <link rel="stylesheet" href="<?= $PATH . '/style/style_admin.css' ?>">
  <title>Kvizzi | Admin Panel - Pitanja</title>

</head>

<body>
  <!-- Navbar -->
  <?php generateNavbar('', $PATH); ?>
  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>
</html>
