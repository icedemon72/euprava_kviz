<?php
  session_start();
  require_once('./settings.php');
  if($_SESSION['username']) {
    unset($_SESSION["username"]);
  }
  header('Location: ./../index.php');
?>