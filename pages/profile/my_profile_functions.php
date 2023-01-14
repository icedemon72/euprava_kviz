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
      'first_name', 'last_name', 'date_of_birth', 'email',
      'registration_date', 'last_log_in', 'description'
    );

    while($row = $result->fetch_assoc()) {
      foreach($keysArray as $key) {
        $resultToReturn[$key] = $row[$key];
      }
    }

    $stmt->free_result();
    $stmt->close();

    $resultToReturn['registration_date'] = (new DateTime($resultToReturn['registration_date']))->format('d. M Y.');
    $resultToReturn['last_log_in'] = (new DateTime($resultToReturn['last_log_in']))->format('d. M Y.');
    $resultToReturn['date_of_birth'] = (new DateTime($resultToReturn['date_of_birth']))->format('d. M Y.');

    if(!$resultToReturn['description']) {
      $resultToReturn['description'] = 'Nema opisa... :(';
    }

    return $resultToReturn;
  }
  
  /*CHANGES NEEDED*/function getQuizDetails($user, $conn) {
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
  
  function getAchievements($user, $conn) {    
    $stmt = $conn->prepare(
      "SELECT *
      FROM achievements"
    );

    $stmt->execute();
    $result = $stmt->get_result();
    $resArray = array(
      'id' => array(),
      'title' => array(),
      'description' => array(),
      'image' => array(),
      'hasAchievement' => array(),
      'dateUnlocked' => array()
    );
    
    while($row = $result->fetch_assoc()) {
      array_push($resArray['id'], $row['id']);
      array_push($resArray['title'], $row['title']);
      array_push($resArray['description'], $row['description']);
      array_push($resArray['image'], $row['image']);
    }

    $stmt->free_result();
    $stmt->close();

    $resArray['hasAchievement'] = array_fill(0, sizeof($resArray['title']), 0);
    $resArray['dateUnlocked'] = array_fill(0, sizeof($resArray['title']), NULL);

    $id = getIdByUser($user, $conn);

    $stmt = $conn->prepare(
      "SELECT * 
      FROM user_has_achievement
      WHERE users_id = ?;"
    );

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
      $ach = array_search($row['achievements_id'], $resArray['id']);
      $resArray['hasAchievement'][$ach] = $row['status'];
      $resArray['dateUnlocked'][$ach] =  (new DateTime($row['date_unlocked']))->format('d. M Y. H:i');
    }

    $stmt->free_result();
    $stmt->close();

    return $resArray;
  }

?>