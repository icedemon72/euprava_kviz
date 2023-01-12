<?php
  function checkIfEmailExists($email, $conn) {
    $stmt = $conn->prepare(
      "SELECT * 
      FROM users 
      WHERE users.email = ?;"
    );
  
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    return ($stmt->num_rows() > 0);
  }

  function checkPassword($username, $password, $conn) {
    $stmt = $conn->prepare(
      "SELECT password
      FROM users
      WHERE users.username = ?
      AND users.password = md5(?);"
    );

    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->store_result();

    return($stmt->num_rows == 1);

  }
  
  function anyChanges($inputValues, $userInfo) {
    return !($inputValues['description'] == $userInfo['description'] && $inputValues['email'] == $userInfo['email'] 
    && $inputValues['first_name'] == $userInfo['first_name'] && $inputValues['last_name'] == $userInfo['last_name']
    && (new DateTime($userInfo['date_of_birth']))->format('Y-m-d') == $inputValues['date_of_birth'] && $inputValues['password']);
  }

  function anyChangesPassword($password, $new_password) {
    return strlen($password) && strlen($new_password);
  }

  function checkInput($inputValues, $userInfo, $conn) {
    $errors = array();

    // email check
    if($userInfo['email'] != $inputValues['email']) {
      if(!strlen($inputValues['email'])) {
        array_push($errors, 'Pogrešan unos u "e-mail" polje!');
      }
      else if (checkIfEmailExists($inputValues['email'], $conn)) {
        array_push($errors, 'E-mail već postoji!'); 
      } 
      else if (!preg_match('/([\w\-]+\@[\w\-]+\.[\w\-]+)/', $inputValues['email'])) {
        array_push($errors, 'Nevažeći e-mail!');
      }
    }

    // password check
    if(anyChangesPassword($inputValues['password'], $inputValues['new_password'])) {
      if(!checkPassword($_SESSION['username'], $inputValues['password'], $conn)) {
        array_push($errors, 'Stara lozinka nije tačna!'); 
      } else {
        if(strlen($inputValues['new_password']) < 6) {
          array_push($errors, 'Nova lozinka je prekratka!'); 
        } else {
        
          if($inputValues['password'] == @$inputValues['new_password']) {
            array_push($errors, 'Lozinke se poklapaju!'); 
          }
        }
      }

    }
    
    // first name check
    if(!strlen($inputValues['first_name'])) {
      array_push($errors, 'Pogrešan unos u "ime" polje!');
    } else if (!preg_match('/[a-zA-Z \-]/', $inputValues['first_name'])) {
      array_push($errors, 'Ime može sadržati samo slova!');
    }

    // last name check
    if(!strlen($inputValues['last_name'])) {
      array_push($errors, 'Pogrešan unos u "prezime" polje!');
    } else if (!preg_match('/[a-zA-Z \-]/', $inputValues['last_name'])) {
      array_push($errors, 'Prezime može sadržati samo slova!');
    }

    // date check
    if(!strtotime($inputValues['date_of_birth'])) {
      array_push($errors, 'Datum je nevažeći!');
    } 
    else {
      if(new DateTime($inputValues['date_of_birth']) > new DateTime()) {
        array_push($errors, 'Datum je u budućnosti!');
      } else if((new DateTime())->diff(new DateTime($inputValues['date_of_birth']))->y > 150) {
        array_push($errors, 'Pogrešan unos datuma (Preko 150 godina)!');
      }
    }

    return $errors;
  }

  function updateUser($inputValues, $conn) {
    $stmt = $conn->prepare(
      "UPDATE users
      SET users.first_name = ?, users.last_name = ?, users.email = ?, 
          users.date_of_birth = ?, users.description = ?
      WHERE users.username = ?;"
    );
    $stmt->bind_param('ssssss', $inputValues['first_name'], $inputValues['last_name'], $inputValues['email'],
    $inputValues['date_of_birth'], $inputValues['description'], $_SESSION['username']);
    $stmt->execute();
  }

  function updateUserPassword($new_password, $conn) {
    $stmt = $conn->prepare(
      "UPDATE users
      SET users.password = md5(?)
      WHERE users.username = ?;"
    );
    $stmt->bind_param('ss', $new_password, $_SESSION['username']);
    $stmt->execute();
  }

?>