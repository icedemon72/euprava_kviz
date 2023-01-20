<?php
  function generateCategory($conn, $type = 'request') {
    if($type == 'request') {
      $stmt = $conn->prepare(
        "SELECT quiz_type_requests.name
        FROM quiz_type_requests
        WHERE quiz_type_requests.active = 1
        ORDER BY quiz_type_requests.name ASC;"
      );
    } else {
      $stmt = $conn->prepare(
        "SELECT quiz_type.name
        FROM quiz_type
        WHERE quiz_type.active = 1
        ORDER BY quiz_type.name ASC;"
      );
    }

    $stmt->execute();
    $res = $stmt->get_result();

    $resultArray = array();

    while($row = $res->fetch_assoc()) {
      array_push($resultArray, $row['name']);
    }

    $stmt->free_result();
    $stmt->close();

    return $resultArray;
  }

  function checkInputFields($arrayOfCategories, $inputValues) {
    $errors = array();

    if(!in_array($inputValues['category_name'], $arrayOfCategories)) {
      array_push($errors, 'Izaberite validnu kategoriju!');
    }

    if(!strlen($inputValues['question'])) {
      array_push($errors, 'Unesite pitanje!');
    }

    if(!($inputValues['category_type'] == 'radio' || $inputValues['category_type'] == 'chbox' || $inputValues['category_type'] == 'input')) {
      array_push($errors, 'Unesite tip pitanja!');
    }

    return $errors;
  }

  function checkQuestionFields($categoryName, $correct, $wrong) {
    $returnAssocArray = 
      array(
        'errors' => array(),
        'correctAnswers' => array(),
        'wrongAnswers' => array()
      );
    
    if($categoryName == 'radio' || $categoryName == 'chbox') {
      foreach($correct as $corr) {
        if(strlen(trim(stripslashes($corr))) != 0) {
          array_push($returnAssocArray['correctAnswers'], $corr);
        }
      }
      foreach($wrong as $wr) {
        if(strlen(trim(stripslashes($wr))) != 0) {
          array_push($returnAssocArray['wrongAnswers'], $wr);
        }
      }
    } else if($categoryName == 'input' && strlen(trim(stripslashes($correct[0]))) != 0) {
      array_push($returnAssocArray['correctAnswers'], trim(stripslashes($correct[0])));
    } else {
      array_push($returnAssocArray['errors'], 'Greška pri unosu tipa pitanja!');
    }

    if(sizeof($returnAssocArray['correctAnswers']) < 1) {
      array_push($returnAssocArray['errors'], 'Greška pri unosu pitanja - mora postojati bar jedan tačan odgovor!');
    }

    if(sizeof($returnAssocArray['wrongAnswers']) != 0 && $categoryName == 'input') {
      array_push($returnAssocArray['errors'], 'Greška pri unosu pitanja - input mora biti tačan odgovor!');
    }

    if(sizeof($returnAssocArray['correctAnswers']) + sizeof($returnAssocArray['wrongAnswers']) > 4) {
      array_push($returnAssocArray['errors'], "Greška pri unosu pitanja - može postojati maksimalno 4 odgovora!");
    } 

    if(sizeof($returnAssocArray['correctAnswers']) == 0 && sizeof($returnAssocArray['wrongAnswers']) == 0) {
      array_push($returnAssocArray['errors'], "Greška pri unosu pitanja - moraju postojati odgovori!");
    }

    if(sizeof($returnAssocArray['wrongAnswers']) < 1 && $categoryName == 'radio') {
      array_push($returnAssocArray['errors'], "Greška pri unosu pitanja - mora postojati barem jedan pogrešan odgovor!");
    }

    if(sizeof($returnAssocArray['correctAnswers']) + sizeof($returnAssocArray['wrongAnswers']) != 4 && $categoryName == 'chbox') {
      array_push($returnAssocArray['errors'], "Greška pri unosu pitanja - checkbox mora imati 4 odgovora!");
    }

    return $returnAssocArray;
  }

  function getId($databaseName, $tableName, $conn) {
    $insertId = 1;

    $stmt = $conn->prepare(
      "SELECT `AUTO_INCREMENT`
      FROM  INFORMATION_SCHEMA.TABLES
      WHERE TABLE_SCHEMA = '$databaseName'
      AND   TABLE_NAME   = '$tableName';"
    );

    $stmt->execute();
    $res = $stmt->get_result();
    
    while($row = $res->fetch_assoc()) {
      $insertId = $row['AUTO_INCREMENT'];
    }

    $stmt->free_result();
    $stmt->close();
    return $insertId;
  }

  function getTypeIdByName($type, $name, $conn) {
    
      $id = 1;

      if($type == 'request') {
        $stmt = $conn->prepare(
          "SELECT id
          FROM quiz_type_requests
          WHERE quiz_type_requests.name = ?;"
        );
      } else if ($type == 'existing') {
        $stmt = $conn->prepare(
          "SELECT id
          FROM quiz_type
          WHERE quiz_type.name = ?;"
        );
      }

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

  function insertQuestion($typeInsert, $type, $category, $question, $correct, $wrong, $conn, $databaseName) {
    if($typeInsert == 'request') {
      $questionId = getId($databaseName, 'questions_not_existing_requests', $conn);
      $question = ucfirst($question);
      $quizTypeId = getTypeIdByName($typeInsert, $category, $conn);
      $userId = getIdByUser($_SESSION['username'], $conn);
      $correctBit = 1;
      $notCorrectBit = 0;
      $stmt = $conn->prepare(
        "INSERT INTO questions_not_existing_requests (
          text, type, quiz_type_requests_id, 
          date_added, users_id
        )
        VALUES (?, ?, ?, ?, ?);"
      );

      $date = date_format(date_create(), 'Y-m-d');
  
      $stmt->bind_param('ssisi', 
        $question, $type, $quizTypeId,
        $date, $userId
      );

      $stmt->execute();
      $stmt->free_result();
      $stmt->close();
      foreach($correct as $corr) {
        $stmt = $conn->prepare(
          "INSERT INTO answers_not_existing_requests (text, correct, questions_not_existing_requests_id)
          VALUES(?, ?, ?);"
        );
        $stmt->bind_param('sis', $corr, $correctBit, $questionId);
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
      }

      foreach($wrong as $wr) {
        $stmt = $conn->prepare(
          "INSERT INTO answers_not_existing_requests (text, correct, questions_not_existing_requests_id)
          VALUES(?, ?, ?);"
        );
        $stmt->bind_param('sis', $wr, $notCorrectBit, $questionId);
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
      }
    } else if ($typeInsert == 'existing') {
      $questionId = getId($databaseName, 'questions_existing_requests', $conn);
      $question = ucfirst($question);
      $quizTypeId = getTypeIdByName($typeInsert, $category, $conn);
      $userId = getIdByUser($_SESSION['username'], $conn);
      $correctBit = 1;
      $notCorrectBit = 0;
      $stmt = $conn->prepare(
        "INSERT INTO questions_existing_requests (
          text, type, quiz_type_id, 
          date_added, users_id
        )
        VALUES (?, ?, ?, ?, ?);"
      );

      $date = date_format(date_create(), 'Y-m-d');
  
      $stmt->bind_param('ssisi', 
        $question, $type, $quizTypeId,
        $date, $userId
      );

      $stmt->execute();
      $stmt->free_result();
      $stmt->close();

      foreach($correct as $corr) {
        $stmt = $conn->prepare(
          "INSERT INTO answers_existing_requests (text, correct, questions_existing_requests_id)
          VALUES(?, ?, ?);"
        );
        $stmt->bind_param('sis', $corr, $correctBit, $questionId);
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
      }

      foreach($wrong as $wr) {
        $stmt = $conn->prepare(
          "INSERT INTO answers_existing_requests (text, correct, questions_existing_requests_id)
          VALUES(?, ?, ?);"
        );
        $stmt->bind_param('sis', $wr, $notCorrectBit, $questionId);
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
      }
    }

    require_once('./../profile/achievements.php');    
    awardAchievement("Kap koja je prelila čašu", $conn, $userId);
  }

  
?>