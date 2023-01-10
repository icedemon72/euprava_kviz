<?php
  header("HTTP/1.1 403 Forbidden");
  
  function checkIfUsernameExists($username, $conn) {
    $stmt = $conn->prepare(
      "SELECT *
      FROM users
      WHERE users.username = ?; 
      "
    );
    
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    return($stmt->num_rows == 1);
  }

  function checkIfPasswordIsCorrect($username, $password, $conn) {
    $stmt = $conn->prepare(
      "SELECT *
      FROM users
      WHERE users.username = ?
      AND users.password = md5(?);"
    );

    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->store_result();

    return($stmt->num_rows == 1);
  }

  function checkIfValidInputLogin($input, $conn) {
    $errors = array();
  
    // username check
    if(!strlen($input['uname'])) {
      array_push($errors, 'Pogrešan unos u polje "Korisničko ime"!');
    } else if (!checkIfUsernameExists($input['uname'], $conn)) {
      array_push($errors, 'Korisničko ime "' . $input['uname'] . '" ne postoji!');
    }
    
    // password check
    if(!strlen($input['pass'])) {
      array_push($errors, 'Pogrešan unos u polje "Lozinka"!');
    } else if(!checkIfPasswordIsCorrect($input['uname'], $input['pass'], $conn)) {
      array_push($errors, 'Pogrešna lozinka!');
    }

    return $errors;
  }

  function userLogin($input, $conn) {
    //
  }
?>