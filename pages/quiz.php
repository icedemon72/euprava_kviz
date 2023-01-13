<?php
  session_start();
  require_once('./quiz_functions.php');
  require_once('./../auth/connect_db.php'); 
  require_once('./../auth/settings.php'); 

  $quizType = "informatika";
  $quizQuestionNumber = 5;
  $quizQuestions = array();
  $quizIdArray = array();
  $quizAnswersArray = array();
  $count = getCount('answers', 'questions_id', $conn);  
  $quizSelectedIdArray = getQuizIdArray($quizQuestionNumber, $count, $conn);

  for($i = 0; $i < count($quizSelectedIdArray); $i++) {
    $answers_query = getAnswersByQuestionId($quizSelectedIdArray[$i], $conn);
    array_push($quizAnswersArray, (getAnswersArrayByQuery($answers_query)));
    $question_query = getQuestionById($quizSelectedIdArray[$i], $conn);
    echo "<form method='post' action='./quiz/quiz_submit.php'>";
    while($row = $question_query->fetch_assoc()) {
      echo "<p><b>".($i + 1).'. '.$row['text'].'</b></p>';
      for($j = 0; $j < count($quizAnswersArray[$i]); $j++) {
        if($row['type'] == 'radio') {
          echo "<input type='radio' name='question_".($i + 1).
          "' value='".$j."' /><label>"
          .$quizAnswersArray[$i][$j]['answerText'].'</label><br />';
        } else if ($row['type'] == 'chbox') {
          echo "<input type='checkbox' name='ch_question_".($i + 1)."[]' value='".$j."' /><label>".$quizAnswersArray[$i][$j]['answerText'].'</label><br />';
        } else {
          echo "<input type='text' name='question_".($i + 1)."' required />";
        }
      }
    }
    echo "<br /><br />";
  }

  echo "<input type='submit' name='btn' /></form>";

  $_SESSION['quizType'] = $quizType;
  $_SESSION['quizSelectedIdArray'] = $quizSelectedIdArray;
  $_SESSION['quizAnswerArray'] = $quizAnswersArray;
?>
