<?php
  session_start();
  require_once('./settings.php');
  if($_SESSION['username']) {
    unset($_SESSION["username"]);
  }
  if($_SESSION['admin']) {
    unset($_SESSION["admin"]);
  }
  header('Location: ./../index.php');
?>