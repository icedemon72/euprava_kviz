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

  function checkIdOfResult($id, $user, $conn) {
    $userId = getIdByUser($user, $conn);
    
    $stmt = $conn->prepare(
      "SELECT quiz_playing.id
      FROM quiz_playing
      WHERE quiz_playing.users_id = ?
      AND quiz_playing.id = ?;"
    );

    $stmt->bind_param('ii', $userId, $id);
    $stmt->execute();
    $stmt->store_result();
    
    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();

    return $count == 1;
  }

  function getQuizIdData($quizId, $conn) {
    $resultArray = array(
      'time_started' => '',
      'time_finished' => '',
      'score' => 0
    );

    $stmt = $conn->prepare(
      "SELECT *
      FROM quiz_playing
      WHERE quiz_playing.id = ?;"
    );

    $stmt->bind_param('i', $quizId);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      foreach($resultArray as $key => $value) {
        if($row['score'] == NULL) {
          $resultArray['time_started'] = $row['time_started'];
          $resultArray['time_finished'] = 'DNF';
        } else {
          $resultArray[$key] = $row[$key];
        }
      }
    }
    
    $stmt->free_result();
    $stmt->close();

    return $resultArray;
  }

  function getUserIdByQuizId($quizId, $conn) {
    $id = 0;

    $stmt = $conn->prepare(
      "SELECT quiz_playing.users_id
      FROM quiz_playing
      WHERE quiz_playing.id = ?;"
    );

    $stmt->bind_param('i', $quizId);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      $id = $row['users_id'];
    }

    $stmt->free_result();
    $stmt->close();

    return $id;
  }

  function getGlobalQuizIdData($userId, $conn) {
    $questionCount = 10;
    $resultArray = array(
      'averageScore' => 0.00,
      'averageTimePlayed' => 0.00,
      'averageTimePerQuestion' => 0.00
    );

    $i = 0;

    $stmt = $conn->prepare(
      "SELECT *
      FROM quiz_playing
      WHERE quiz_playing.users_id = ?;"
    );

    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      if($row['score'] != NULL) {
        $resultArray['averageScore'] += $row['score'];
        $timeDiff = abs(strtotime($row['time_started']) - strtotime($row['time_finished']));
        $resultArray['averageTimePlayed'] += $timeDiff;
        $i++;
      }
    }

    if($i != 0) {
      $resultArray['averageScore'] = round($resultArray['averageScore'] / $i, 2);
      $resultArray['averageTimePlayed'] = round($resultArray['averageTimePlayed'] / $i, 2);
      $resultArray['averageTimePerQuestion'] = round($resultArray['averageTimePlayed'] / $questionCount, 2);
    }

    $stmt->free_result();
    $stmt->close();

    return $resultArray;
  }

?>