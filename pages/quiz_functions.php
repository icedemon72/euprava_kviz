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