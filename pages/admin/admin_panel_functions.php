<?php
  // admin_panel.php
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

  // admin_quiz_played.php
  function countQuizPlaying($conn) {
    $stmt = $conn->prepare(
      "SELECT quiz_playing.id
      FROM quiz_playing;"
    );

    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows();
    $stmt->free_result();
    $stmt->close();

    return $count;
  }

  function getQuizPlayedDetails($limit, $offset, $conn) {
    $resultArray = array(
      'id' => array(),
      'time_started' => array(),
      'time_finished' => array(),
      'score' => array(),
      'category_name' => array(),
      'users_name' => array()
    );
    
    $stmt = $conn->prepare(
      "SELECT 
        quiz_playing.id,
        quiz_playing.time_started,
        quiz_playing.time_finished,
        quiz_playing.score,
        quiz_type.name AS category_name,
        users.username AS 'users_name'
      FROM quiz_playing
      INNER JOIN quiz_type
        ON quiz_playing.quiz_type_id = quiz_type.id
      INNER JOIN users
        ON quiz_playing.users_id = users.id
      ORDER BY quiz_playing.id ASC
      LIMIT ?, ?;"
    );
    $stmt->bind_param('ii', $offset, $limit);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      foreach($resultArray as $key => $value) {
        array_push($resultArray[$key], $row[$key]);
      }
    }

    $stmt->free_result();
    $stmt->close();

    return $resultArray;
  
  }

  // admin_category.php
  function countCategoryRequests($conn) {
    $stmt = $conn->prepare(
      "SELECT quiz_type_requests.id
      FROM quiz_type_requests
      WHERE quiz_type_requests.active = 1;"
    );

    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows();
    $stmt->free_result();
    $stmt->close();

    return $count;
  }

  function getCategoryRequests($limit, $offset, $conn) {
    $resultArray = array(
      'id' => array(),
      'name' => array(),
      'description' => array(),
      'users_id' => array(),
      'date_created' => array(),
      'date_accessed' => array(),
      'is_admin_id' => array()
    );

    $stmt = $conn->prepare(
      "SELECT * 
      FROM quiz_type_requests
      WHERE quiz_type_requests.active = 1
      ORDER BY quiz_type_requests.date_created ASC
      LIMIT ?, ?;"
    );

    $stmt->bind_param('ii', $offset, $limit);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      foreach($resultArray as $key => $value) {
        array_push($resultArray[$key], $row[$key]);
      }
    }

    $stmt->free_result();
    $stmt->close();

    return $resultArray;
  }

  function setStatusToZeroById($id, $conn) {

  }

  function addCategoryById($id, $username, $conn) {
    $date = date_format(date_create(), 'Y-m-d H:i:s');

    
    $stmt = $conn->prepare(
      "UPDATE quiz_type_requests
      SET 
        quiz_type_requests.date_accessed = ?,
        quiz_type_requests.active = 0,
        quiz_type_requests.is_admin_id = (
          SELECT DISTINCT is_admin.id
          FROM is_admin
          INNER JOIN users
          ON is_admin.users_id = (
            SELECT DISTINCT users.id
            FROM users
            WHERE users.username = ?
          )
        )
      WHERE quiz_type_requests.id = ?;"
    );

    $stmt->bind_param('ssi', $date, $username, $id);
    $stmt->execute();

    $stmt = $conn->prepare(
      "INSERT INTO
      questions_not_existing_requests"
    );

    $stmt->free_result();
    $stmt->close();
  }


  

?>