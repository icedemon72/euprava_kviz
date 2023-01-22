<?php
  function checkType($type, $conn) {
    $stmt = $conn->prepare(
      "SELECT quiz_type.name, quiz_type.active
      FROM quiz_type
      LEFT JOIN questions ON quiz_type.id = questions.quiz_type_id
      WHERE quiz_type.name = ?
      HAVING COUNT(questions.quiz_type_id) > 30 AND quiz_type.active = 1;"
    );

    $stmt->bind_param('s', $type);
    $stmt->execute();
    $stmt->store_result();

    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();

    return ($count == 1);
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

  function getAnswersArrayByQuestionId($id, $conn) {
    $resArray = array();
    
    $stmt = $conn->prepare(
      "SELECT answers.text
      FROM answers
      WHERE questions_id = ?;"
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

  function getQuizInfo($category, $num, $conn) {
    $categoryId = getCategoryIdByName($category, $conn);
    $assocArray = array(
      'id' => array(),
      'type' => array(),
      'question' => array(),
      'answers' => array()
    );
    $stmt = $conn->prepare(
      "SELECT 
        questions.id,
        questions.text,
        questions.type
      FROM questions 
      WHERE questions.quiz_type_id = ?
      ORDER BY RAND()
      LIMIT ?;"
    );

    $stmt->bind_param('si', $categoryId, $num);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      array_push($assocArray['id'], $row['id']);
      array_push($assocArray['question'], $row['text']);

      if ($row['type'] == 'chbox') {
        $row['type'] = 'checkbox';
      }

      array_push($assocArray['type'], $row['type']);
      array_push($assocArray['answers'], getAnswersArrayByQuestionId($row['id'], $conn));
    }

    $stmt->free_result();
    $stmt->close();

    return $assocArray;
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

  function insertQuizStart($user, $category, $conn) {
    $stmt = $conn->prepare(
      "INSERT INTO quiz_playing (
        quiz_playing.users_id,
        quiz_playing.quiz_type_id,
        quiz_playing.time_started
      )
      VALUES (?, ?, ?);"
    );

    $date = date_format(date_create(), 'Y-m-d H:i:s');
    $userId = getIdByUser($user, $conn);
    $quizId = getCategoryIdByName($category, $conn);

    $stmt->bind_param('iis', $userId, $quizId, $date);
    $stmt->execute();
    $stmt->free_result();
    $stmt->close();
  }