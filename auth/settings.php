<?php
  header("HTTP/1.1 403 Forbidden");
  $SERVER_LINK = 'http://localhost/';
  $FOLDER_PATH = '';
  $LINK = $_SERVER['PHP_SELF'];
  $exploded = explode('/', $LINK);
  for($i = 1; $i < sizeof($exploded) - 1; $i++) {
    $FOLDER_PATH .= $exploded[$i];
    if($i + 2 != sizeof($exploded)) {
      $FOLDER_PATH .= '/';
    }
  }
  $PATH = $SERVER_LINK . $FOLDER_PATH;
?>