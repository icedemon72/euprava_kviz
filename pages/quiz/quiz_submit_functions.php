<?php
  function getCorrectAnswersByQuestionId($id, $conn) {
    $resArray = array();
    
    $stmt = $conn->prepare(
      "SELECT answers.text
      FROM answers
      WHERE correct = 1 AND questions_id = ?;"
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      array_push($resArray, $row['text']);
    }

    $stmt->free_result();
    $stmt->close();

    return $resArray;
  }

  function checkIfCorrectInput($answer, $correct) {
    $answer = trim(strtolower(preg_replace("/[^a-zA-Z0-9()]+/", "", $answer)));
    $correct[0] = trim(strtolower(preg_replace("/[^a-zA-Z0-9()]+/", "", $correct[0])));
    return $answer == $correct[0];
  }

  function checkIfCorrectRadio($answer, $correct) {
    return $answer == $correct[0];
  }

  function checkIfCorrectCheckbox($answerArray, $correctArray) {
    if(sizeof($answerArray) != 0) {
      return sizeof(array_diff($answerArray, $correctArray)) == 0;
    }
    return false;
  }

  function byInput($userInfo, $index, $ans) {
    if($userInfo['type'][$index] == 'radio') { 
      if(gettype($ans[0]) == 'string') {
        return $userInfo['answers'][$index][$ans[0] - 1];
      }
      return '';
    } else if ($userInfo['type'][$index] == 'checkbox') {
      $returnArray = array();
      foreach($ans as $selected) {
        foreach($selected as $result) {
          if($result != 0) {
            array_push($returnArray, $userInfo['answers'][$index][$result - 1]);
          }
        }
      }
      return $returnArray;
    } else if ($userInfo['type'][$index] == 'input') {
      if(gettype($ans[0]) == 'string') {
        return $ans[0];
      }
    }
  }
  
  function getScore($inputValues, $userInfo, $keys, $conn) {
    $userAnswers = array();
    $correctAnswers = array();
    $score = 0;
    for($i = 0; $i < sizeof($keys); $i++) {
      $answer = $inputValues[$keys[$i]];
      array_push($userAnswers, byInput($userInfo, $i, $answer));
      array_push($correctAnswers, getCorrectAnswersByQuestionId($userInfo['id'][$i], $conn));     
    }  

    // print("<pre>".print_r($userAnswers,true)."</pre>");
    // print("<pre>".print_r($userInfo['question'],true)."</pre>");
    for($i = 0; $i < sizeof($userAnswers); $i++) {
      if($userInfo['type'][$i] == 'input' ) {
        if(checkIfCorrectInput($userAnswers[$i], $correctAnswers[$i])) {
          $score++;
        }
      } else if ($userInfo['type'][$i] == 'radio') {
        if(checkIfCorrectRadio($userAnswers[$i], $correctAnswers[$i])) {
          $score++;
        }
      }
      else if ($userInfo['type'][$i] == 'checkbox') {
        if(checkIfCorrectCheckbox($userAnswers[$i], $correctAnswers[$i])) {
          $score++;
        }
      }
    }
    return $score;
  }

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

  function getCategoryIdByName($name, $conn) {
    $id = 0;
    $stmt = $conn->prepare(
      "SELECT id
      FROM quiz_type
      WHERE quiz_type.name = ?;"
    );

    $stmt->bind_param('s', $name);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      $id = $row['id'];
    }

    $stmt->free_result();
    $stmt->close();

    return $id;
  }

  function updateQuizInfo($user, $type, $score, $conn) {
    
    $id = 0;
    $started = '';
    $stmt = $conn->prepare(
      "SELECT quiz_playing.id, quiz_playing.time_started
      FROM quiz_playing
      WHERE users_id = ?
      AND quiz_type_id = ?
      ORDER BY id DESC 
      LIMIT 1;"
    );
    
    $userId = getIdByUser($user, $conn);
    $quizId = getCategoryIdByName($type, $conn);

    $stmt->bind_param('ii', $userId, $quizId);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      $id = $row['id'];
      $started = $row['time_started'];
    }
    
    $stmt->free_result();
    $stmt->close();
    
    $stmt = $conn->prepare(
      "UPDATE quiz_playing
      SET 
        quiz_playing.time_finished = ?,
        quiz_playing.score = ?
      WHERE quiz_playing.id = ?;"
    );

    $date = date_format(date_create(), 'Y-m-d H:i:s');

    $stmt->bind_param('sdi', $date, $score, $id);
    $stmt->execute();
    $stmt->free_result();
    $stmt->close();

    // Achievements
    if($score == 0) {
      awardAchievement("I meni je mene žao, zaplak'o sam zamalo", $conn, $userId);
    }
    if($score >= 8) {
      awardAchievement('Trofej Bradete Jarice I', $conn, $userId);
    } 
    
    if ($score >= 9) {
      awardAchievement('Trofej Bradete Jarice II', $conn, $userId);
    }
    
    if ($score == 10) {
      awardAchievement('Trofej Bradete Jarice III', $conn, $userId);
    }

    awardAchievement("It's OK let him play", $conn, $userId);

    if(abs(strtotime($started) - strtotime($date) < 60) && $score >= 7) {
      awardAchievement('Nemoj ga rush-ati, samo mu ga daj malo po gasu', $conn, $userId);
    }

    $stmt = $conn->prepare(
      "SELECT quiz_playing.id
      FROM quiz_playing
      WHERE quiz_playing.users_id = ?
      AND quiz_playing.score >= 5;"
    );

    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows();

    if($count == 5) {
      awardAchievement('Zvezde Grandice I', $conn, $userId);
    } else if($count == 10) {
      awardAchievement('Zvezde Grandice II', $conn, $userId);
    } else if($count == 15) {
      awardAchievement('Zvezde Grandice III', $conn, $userId);
    }

    $stmt->free_result();
    $stmt->close();

  

    return $id;
  }
?>