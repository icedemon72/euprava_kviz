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

    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();
    return ($count > 0);
  }

  function checkIfUsernameExists($username, $conn) {
    $stmt = $conn->prepare(
      "SELECT * 
      FROM users 
      WHERE users.username = ?;"
    );

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();

    return($count > 0);
  }

  function checkIfValidInput($inputValues, $conn) {
    $errors = array();
    
    // username check
    if(checkIfUsernameExists($inputValues['username'], $conn)) {
      array_push($errors, 'Korisničko ime već postoji!');
    } else {
      if(strlen($inputValues['username'] < 3)) {
        array_push($errors, 'Korisničko ime mora imati barem 3 karaktera!');
      } else if (strlen($inputValues['username']) > 255) {
        array_push($errors, 'Korisničko ime može sadržati maksimalno 255 karaktera!');
      }
      
      if(preg_match('/[^a-z\-0-9_\.]/i', $inputValues['username'])) {
        array_push($errors, 'Korisničko ime sadrži specijalni karakter!');
      } else if (str_starts_with($inputValues['username'], '.')) {
        array_push($errors, 'Korisničko ime ne sme početi tačkom!');
      } else if (str_starts_with($inputValues['username'], '-')) {
        array_push($errors, 'Korisničko ime ne sme početi minusom!');
      }
    }

    // email check
    if(!strlen($inputValues['email'])) {
      array_push($errors, 'Pogrešan unos u "e-mail" polje!');
    }
    else if (checkIfEmailExists($inputValues['email'], $conn)) {
      array_push($errors, 'E-mail već postoji!'); 
    } 
    else if (!preg_match('/([\w\-]+\@[\w\-]+\.[\w\-]+)/', $inputValues['email'])) {
      array_push($errors, 'Nevažeći e-mail!');
    } 
    else if(strlen($inputValues['email']) > 255) {
      array_push($errors, 'Email adresa može sadržati maksimalno 255 karaktera!');
    }

    // password check
    if(strlen($inputValues['password']) < 6) {
      array_push($errors, 'Lozinka je prekratka!'); 
    } else {
      if(strlen($inputValues['password']) > 255) {
        array_push($errors, 'Lozinka može sadržati maksimalno 255 karaktera!'); 
      }
      if($inputValues['password'] != @$inputValues['repeat_password']) {
        array_push($errors, 'Lozinke se ne poklapaju!'); 
      }
    }
    
    // first name check
    if(!strlen($inputValues['firstname'])) {
      array_push($errors, 'Pogrešan unos u "ime" polje!');
    } else if (!preg_match('/[a-zA-Z \-]/', $inputValues['firstname'])) {
      array_push($errors, 'Ime može sadržati samo slova!');
    } else if (strlen($inputValues['firstname']) > 255) {
      array_push($errors, 'Ime može sadržati maksimalno 255 karaktera!');
    }

    // last name check
    if(!strlen($inputValues['lastname'])) {
      array_push($errors, 'Pogrešan unos u "prezime" polje!');
    } else if (!preg_match('/[a-zA-Z \-]/', $inputValues['lastname'])) {
      array_push($errors, 'Prezime može sadržati samo slova!');
    } else if (strlen($inputValues['lastname']) > 255) {
      array_push($errors, 'Prezime može sadržati maksimalno 255 karaktera!');
    }

    // date check
    if(!strtotime($inputValues['dob'])) {
      array_push($errors, 'Datum je nevažeći!');
    } 
    else {
      if(new DateTime($inputValues['dob']) > new DateTime()) {
        array_push($errors, 'Datum je u budućnosti!');
      } else if((new DateTime())->diff(new DateTime($inputValues['dob']))->y > 150) {
        array_push($errors, 'Pogrešan unos datuma (Preko 150 godina)!');
      }
    }

    return $errors;
  }

  function registerUser($input, $conn){
    $register_date = date_create();
    $register_time = date_format($register_date, 'Y-m-d');
    $stmt = $conn->prepare(
      "INSERT INTO users(
        email, username, password, first_name, 
        last_name, date_of_birth, registration_date, last_log_in
        )
      VALUES(?, ?, md5(?), ?, ?, ?, ?, ?);"
    );
    $stmt->bind_param('ssssssss', 
      $input['email'], $input['username'], $input['password'], $input['firstname'],
      $input['lastname'], $input['dob'], $register_time, $register_time
    );
    $stmt->execute();
    $stmt->free_result();
    $stmt->close();
  }
?>