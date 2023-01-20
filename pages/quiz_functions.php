<?php
  function randomizeArray($array, $sliceTo) {
    shuffle($array);
    return array_slice($array, 0, $sliceTo);
  }

  function checkWhiteList($table, $column) {
    $whitelistTables = array('answers');
    $whitelistColumns = array('questions_id');

    return in_array($table, $whitelistTables) && in_array($column, $whitelistColumns);
  }

  // FUNCTIONS WITH SQL

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

  function getCount($table, $column, $conn) {
    if(checkWhiteList($table, $column)) {
      $stmt = $conn->prepare(
      "SELECT COUNT(DISTINCT `$table`.`$column`) 
      AS 'count' 
      FROM `$table`;"
      );

      $stmt->execute();
      $countQueryResult = $stmt->get_result();

      while($row = $countQueryResult->fetch_assoc()) {
        $count = $row['count'];
      }
    }
    return $count;
  }

  function getQuizIdArray($questionsNeeded, $count = -1, $conn) {
    if($count == -1) {
      $count = getCount('answers', 'questions_id', $conn);
    }
    if($questionsNeeded > $count) {
      $questionsNeeded = $count;
    }
    
    $stmt = $conn->prepare(
      "SELECT id
      FROM questions;"
    );

    $stmt->execute();
    $arrayQueryResult = $stmt->get_result();

    $arrayToReturn = array();

    while($row = $arrayQueryResult->fetch_assoc()) {
      $arrayToReturn[] = $row['id'];    
    } 

    $stmt->free_result();
    $stmt->close();

    return randomizeArray($arrayToReturn, $questionsNeeded);
  }

  function getQuestionById($id, $conn) {
    $stmt = $conn->prepare(
      "SELECT * 
      FROM questions
      WHERE questions.id = ?"
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $questionResultQuery = $stmt->get_result();
    return $questionResultQuery;
  }

  function getAnswersByQuestionId($id, $conn) {
    $stmt = $conn->prepare(
      "SELECT *
      FROM answers
      WHERE answers.questions_id = ?
      ORDER BY RAND();"
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $answersResultQuery = $stmt->get_result();
    $stmt->free_result();
    $stmt->close();
    return $answersResultQuery;
  }

  function getAnswersArrayByQuery($query) {
    $resultArray = array();
    $index = 0;
    while($row = $query->fetch_assoc()) {
      array_push($resultArray, array(
        'answerIndex' => $index,
        'answerId' => $row['id'],
        'answerText' => $row['text'],
        'answerCorrect' => $row['correct'],
        'questionId' => $row['questions_id']
      ));
      $index++;
    }

    return $resultArray;
  }

?>