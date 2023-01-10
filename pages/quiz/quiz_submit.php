<?php
  session_start();
  include './quiz_submit_functions.php';
  $quizType = $_SESSION['quizType'];
  $quizSelectedIdArray = $_SESSION['quizSelectedIdArray'];
  $quizAnswersArray = $_SESSION['quizAnswerArray'];

  if (isset($_POST['btn'])) {
    $submittedAnswers = array();
    for ($i = 1; $i <= count($quizSelectedIdArray); $i++) {
      $question = 'question_' . $i;
      $val = array();
      if (array_key_exists($question, $_POST)) {
        array_push($val, $_POST[$question]);
      } else if (array_key_exists('ch_' . $question, $_POST)) {
        foreach ($_POST['ch_' . $question] as $selected) {
          array_push($val, $selected);
        }
      }
      array_push($submittedAnswers, $val);
    }

    $correctAnswers = 0;
    for ($i = 0; $i < count($submittedAnswers); $i++) {
      $question = $quizAnswersArray[$i];
      $correctAnswerBool = true;
      
      if (checkIfNotValid($submittedAnswers, $question, $i)) {
        continue;
      }

      if (count($question) == 1) { // text
        for ($j = 0; $j < count($submittedAnswers[$i]); $j++) {
          $answer = $submittedAnswers[$i][$j];
          $clearTextAnswer = trim(strtolower(preg_replace("/[^a-zA-Z0-9)(]+/", "", $answer)));
          $clearTextCorrectAnswer = trim(strtolower(preg_replace("/[^a-zA-Z0-9)(]+/", "", $question[0]['answerText'])));
          if ($clearTextAnswer == $clearTextCorrectAnswer) {
            $correctAnswers++;
          }
        }
      } else {
        for($j = 0; $j < count($question); $j++) {
          if (!in_array($question[$j]['answerIndex'], $submittedAnswers[$i]) && $question[$j]['answerCorrect'] == 1) {
            $correctAnswerBool = false;
            break;
          }
        }

        for ($j = 0; $j < count($submittedAnswers[$i]); $j++) {
          $index = $submittedAnswers[$i][$j];
          if ($question[$index]['answerCorrect'] != 1) {
            $correctAnswerBool = false;
            break;
          }
        }
        if($correctAnswerBool) {
          $correctAnswers++;
        }
      }
    }
    echo 'Tacni odgovori: ' . $correctAnswers;
  }
    //print('<pre>'.print_r($submittedAnswers, true).'</pre>');
    


?>