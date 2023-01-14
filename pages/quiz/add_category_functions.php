<?php
  function getIdByUser($user, $conn) {
    $stmt = $conn->prepare(
      "SELECT id
      FROM users
      WHERE users.username = ?;"
    );

    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();

    $id = '';

    while($row = $result->fetch_assoc()) {
      $id = $row['id'];
    }

    $stmt->free_result();
    $stmt->close();

    return $id;
  }

  function insertCategoryRequest($inputValues, $conn) {
    $id = getIdByUser($_SESSION['username'], $conn);
    $date = date_create();
    $time = date_format($date, 'Y-m-d H:i:s');

    $stmt = $conn->prepare(
      "INSERT INTO quiz_type_requests 
      (quiz_type_requests.name, 
      quiz_type_requests.description, 
      quiz_type_requests.users_id, 
      quiz_type_requests.date_created)
      VALUES(?, ?, ?, ?);"
    );

    $stmt->bind_param('ssis', $inputValues['category_name'], $inputValues['category_desc'], $id, $time);
    $stmt->execute();
    $stmt->free_result();
    $stmt->close();
  }

  function checkCategoryRequestExists($name, $conn) {
    $stmt = $conn->prepare(
      "SELECT UPPER(quiz_type_requests.name)
      FROM quiz_type_requests
      WHERE name = ? AND active = 1;"
    );

    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->store_result();
    
    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();

    return ($count > 0);
  }

  function checkCategoryExists($name, $conn) {
    $stmt = $conn->prepare(
      "SELECT UPPER(quiz_type.name)
      FROM quiz_type
      WHERE name = ? AND active = 1;"
    );

    $stmt->bind_param('s', $name);
    $stmt->execute();
    $res = $stmt->store_result();

    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();

    return ($count > 0);
  }
  
  function checkIfValidCategory($inputValues, $conn) {
    $errors = array();
    if(!strlen($inputValues['category_desc'])) {
      array_push($errors, 'Unesite opis kategorije!');
    }
    if(strlen($inputValues['category_desc']) > 255) {
      array_push($errors, 'Opis kategorije može sadržati maksimalno 255 karaktera!');
    }
    if(!strlen($inputValues['category_name'])) {
      array_push($errors, 'Unesite ime kategorije!');
    } 
    if(strlen($inputValues['category_name']) > 25) {
      array_push($errors, 'Ime kategorije može sadržati maksimalno 25 karaktera!');
    }
    if(preg_match('/[^a-z\-0-9 ]/i', $inputValues['category_name'])) {
      array_push($errors, 'Ime kategorije može sadržati samo karaktere i brojeve!');
    }
    if(checkCategoryRequestExists((strtoupper($inputValues['category_name'])), $conn)) {
      array_push($errors, 'Kategorija je već poslata na razmatranje!');
    } else if(checkCategoryExists(strtoupper($inputValues['category_name']), $conn)) {
      array_push($errors, 'Kategorija već postoji!');
    }    

    return $errors;
  }
?>