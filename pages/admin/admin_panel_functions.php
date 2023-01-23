<?php
  function shortenString($str, $length = 20) {
    if(strlen($str) > $length) {
      return (substr($str, 0, $length) . '...');
    }
    return $str;
  }

  function checkIfAdmin($username, $conn) {
    $stmt = $conn->prepare(
      "SELECT is_admin.id
      FROM users
      INNER JOIN is_admin 
        ON is_admin.users_id = users.id
      WHERE users.username = ?
      AND is_admin.date_resigned IS NULL;"
    );

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();

    return ($count == 1);
  }

  function giveAdmin($username, $conn) {
    $date = date_format(date_create(), 'Y-m-d H:i:s');
    
    $stmt = $conn->prepare(
      "INSERT INTO is_admin (is_admin.users_id, is_admin.date_assigned)
      VALUES (
        (SELECT 
          DISTINCT (users.id) 
        FROM users
        WHERE users.username = ?), 
        ?
      );"
    );

    $stmt->bind_param('ss', $username, $date);
    $stmt->execute();
    $stmt->free_result();
    $stmt->close();
  }

  function removeAdmin($username, $conn) {
    $date = date_format(date_create(), 'Y-m-d H:i:s');

    $stmt = $conn->prepare(
      "UPDATE is_admin
      SET 
        is_admin.date_resigned = ?,
        is_admin.status = 0
      WHERE is_admin.users_id =
        (SELECT 
          DISTINCT (users.id) 
        FROM users 
        WHERE users.username = ?);"
    );

    $stmt->bind_param('ss', $date, $username);
    $stmt->execute();
    $stmt->free_result();
    $stmt->close();
  }

  function getSortedArrayBy($sortBy, $lowerLimit, $upperLimit, $conn) {
    if($sortBy == 'date') {
      $stmt = $conn->prepare(
        "SELECT *
        FROM users
        ORDER BY users.registration_date ASC
        LIMIT ?, ?;"
      );
    } else if($sortBy == 'email') {
      $stmt = $conn->prepare(
        "SELECT *
        FROM users
        ORDER BY users.email ASC
        LIMIT ?, ?;"
      );
    } else {
      $stmt = $conn->prepare(
        "SELECT *
        FROM users
        ORDER BY users.username ASC
        LIMIT ?, ?;"
      );
    } 
    
    $stmt->bind_param('ii', $lowerLimit, $upperLimit);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultArray = array(
      'username' => array(),
      'name' => array(),
      'last_name' => array(), 
      'email' => array(),
      'registration_date' => array(),
      'is_admin' => array()
    );

    while($row = $result->fetch_assoc()) {
      array_push($resultArray['username'], $row['username']);
      array_push($resultArray['name'], $row['first_name'] . ' ' . $row['last_name']);
      array_push($resultArray['email'], $row['email']);
      array_push($resultArray['registration_date'], (new DateTime($row['registration_date']))->format('d. M Y.'));
      if (!checkIfAdmin($row['username'], $conn)) {
       array_push($resultArray['is_admin'], array('Korisnik', 'Admin'));
      } else {
        array_push($resultArray['is_admin'], array('Admin', 'Korisnik'));
      }
        
    }

    $stmt->free_result();
    $stmt->close();

    return $resultArray;
  }

  function countUsers($conn) {
    $stmt = $conn->prepare(
      "SELECT id
      FROM users;"
    );

    $stmt->execute();
    $stmt->store_result();

    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();

    return $count;
  }
?>