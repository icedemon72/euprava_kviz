<?php
  function generateCategory($conn, $type = 'request') {
    if($type == 'request') {
      $stmt = $conn->prepare(
        "SELECT quiz_type_requests.name
        FROM quiz_type_requests
        WHERE quiz_type_requests.active = 1;"
      );
    } else {
      $stmt = $conn->prepare(
        "SELECT quiz_type.name
        FROM quiz_type
        WHERE quiz_type.active = 1;"
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
    
    print_r($correct);

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
      array_push($returnAssocArray['correctAnswers'], trim(stripslashes($correct)));
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

    if(sizeof($returnAssocArray['wrongAnswers']) < 1 && ($categoryName == 'radio')) {
      array_push($returnAssocArray['errors'], "Greška pri unosu pitnaja - Mora postojati barem jedan pogrešan odgovor!");
    }

    return $returnAssocArray;
  }
?>