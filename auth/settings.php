<?php
  $FOLDER_PATH = '';
  $SERVER_LINK = 'http://localhost';

  $replaced = str_replace(realpath($_SERVER["DOCUMENT_ROOT"]), '', __FILE__);
  $exploded = explode('\\', $replaced);

  for($i = 0; $exploded[$i] != 'auth'; $i++) {
    if($exploded[$i] != '\\') {
      $FOLDER_PATH .= $exploded[$i] . '/';
    }
  }

  $FOLDER_PATH = substr($FOLDER_PATH, 0, strlen($FOLDER_PATH) - 1);
  $PATH = $SERVER_LINK . $FOLDER_PATH;
?>