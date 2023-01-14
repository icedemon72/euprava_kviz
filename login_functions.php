<?php  
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

    $count = $stmt->num_rows();
    
    $stmt->free_result();
    $stmt->close();

    return($count == 1);
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
    else if(!strlen($input['pass'])) {
      array_push($errors, 'Pogrešan unos u polje "Lozinka"!');
    } else if(!checkIfPasswordIsCorrect($input['uname'], $input['pass'], $conn)) {
      array_push($errors, 'Pogrešna lozinka!');
    } else {      
      // Last log in update
      $date = date_format(date_create(), 'Y-m-d');
      $stmt = $conn->prepare(
        "UPDATE users
        SET last_log_in = ?
        WHERE users.username = ?;"
      );

      $stmt->bind_param('ss', $date, $input['uname']);
      $stmt->execute();

      // Checking if admin:
      $user_id = 0;
      $stmt = $conn->prepare(
        "SELECT id
        FROM users
        WHERE users.username = ?;"
      );

      $stmt->bind_param('s', $input['uname']);
      $stmt->execute();
      $res = $stmt->get_result();
      
      while($row = $res->fetch_assoc()) {
        $user_id = $row['id'];
      }

      $stmt = $conn->prepare(
        "SELECT *
        FROM is_admin
        WHERE is_admin.id = (SELECT MAX(is_admin.id) FROM is_admin) 
        AND is_admin.users_id = ? AND is_admin.status = 1;"
      );
      
      $stmt->bind_param('i', $user_id);
      $stmt->execute();
      $stmt->store_result();
      $_SESSION['admin'] = ($stmt->num_rows() > 0);
      $_SESSION['username'] = $input['uname'];

    }

    return $errors;
  }


?>