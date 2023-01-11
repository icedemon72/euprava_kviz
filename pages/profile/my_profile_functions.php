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
    return $id;
  }

  function getInfoFromUser($user, $conn) {
    $stmt = $conn->prepare(
      "SELECT *
      FROM users
      WHERE users.username = ?;"
    );
    
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultToReturn = array();
    $keysArray = array(
      'first_name', 'last_name', 'date_of_birth',
      'registration_date', 'last_log_in', 'description'
    );
    while($row = $result->fetch_assoc()) {
      foreach($keysArray as $key) {
        $resultToReturn[$key] = $row[$key];
      }
    }
    $resultToReturn['registration_date'] = (new DateTime($resultToReturn['registration_date']))->format('d. M Y.');
    $resultToReturn['last_log_in'] = (new DateTime($resultToReturn['last_log_in']))->format('d. M Y.');
    $resultToReturn['date_of_birth'] = (new DateTime($resultToReturn['date_of_birth']))->format('d. M Y.');

    if(!$resultToReturn['description']) {
      $resultToReturn['description'] = 'Nema opisa... :(';
    }

    return $resultToReturn;
  }
  
  function getQuizDetails($user, $conn) {
    $id = getIdByUser($user, $conn);
    $stmt = $conn->prepare(
      "SELECT *
      FROM quiz_playing
      WHERE users_id = ?;"
    );

    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->store_result();



    return($stmt->num_rows()); // DODATI ZA OSTALO...
  }

?>