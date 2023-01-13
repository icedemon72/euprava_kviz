<?php
  function shortenString($str, $length = 20) {
    if(strlen($str) > $length) {
      return (substr($str, 0, $length) . '...');
    }
    return $str;
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
      'registration_date' => array()
    );

    while($row = $result->fetch_assoc()) {
      array_push($resultArray['username'], $row['username']);
      array_push($resultArray['name'], $row['first_name'] . ' ' . $row['last_name']);
      array_push($resultArray['email'], $row['email']);
      array_push($resultArray['registration_date'], (new DateTime($row['registration_date']))->format('d. M Y.'));
    }

    return $resultArray;
  }

  function countUsers($conn) {
    $stmt = $conn->prepare(
      "SELECT COUNT(id) AS count
      FROM users;"
    );
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      return $row['count'];
    }
  }
?>