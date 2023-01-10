<?php 
header("HTTP/1.1 403 Forbidden");
function checkIfNotValid($userInput, $dbArray, $i) {
  if((count(array_unique($userInput[$i])) != count($userInput[$i]))) {
    return true;
  }
  if(count($userInput[$i]) > 1) {
    foreach($userInput[$i] as $field) {
      if(is_numeric($field)) {
        if($field < 0 || $field + 1 >= count($dbArray[$i])) {
          return true;
        }
      }
    }
  }
}

?>