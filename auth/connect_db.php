<?php
  $server = 'localhost';
  $user = 'root';
  $pw = '';
  $db = 'kviz';
  $conn = new mysqli($server, $user, $pw, $db);

  if($conn->connect_error) {
    echo $conn->connect_error;
    die();
  }
?>