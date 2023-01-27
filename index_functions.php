<?php
  function getAverageInfo($conn) {
    $resultArray = array(
      'questionsNumber' => 0,
      'usersNumber' => 0,
      'quizPlayed' => 0,
      'scoreAverage' => 0,
      'achievementsNumber' => 0,
      'averageAchievementCompletion' => 0
    );

    $stmt = $conn->prepare(
      "SELECT (
        SELECT COUNT(questions.id) 
        FROM questions
      ) AS questionsNumber,
      (
        SELECT COUNT(users.id)
        FROM users
       ) AS usersNumber,
       (
        SELECT COUNT(quiz_playing.id)
        FROM quiz_playing
       ) AS quizPlayed,
       (
        SELECT ROUND(AVG(quiz_playing.score), 2)
        FROM quiz_playing
       ) AS scoreAverage,
       (
        SELECT COUNT(achievements.id)
        FROM achievements
       ) AS achievementsNumber,
       (
        SELECT ROUND((COUNT(user_has_achievement.id) * 100) / (achievementsNumber * usersNumber), 2) 
        FROM user_has_achievement
       ) AS averageAchievementCompletion;"
    );

    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      foreach($resultArray as $key => $value) {
        $resultArray[$key] = $row[$key];
      }
    }

    $stmt->free_result();
    $stmt->close();

    return $resultArray;
  }

  function shortenString($str, $length = 20) {
    if(strlen($str) > $length) {
      return (substr($str, 0, $length) . '...');
    }
    return $str;
  }

  function getTopResults($conn) {
    $resultArray = array(
      'name' => array(),
      'username' => array(),
      'result' => array()
    );

    $stmt = $conn->prepare(
      "SELECT 
        quiz_playing.users_id,
        CONCAT(users.first_name,' ', users.last_name) AS name,
        ROUND(AVG(quiz_playing.score), 2) as result,
        users.username
      FROM quiz_playing
      INNER JOIN users 
        ON quiz_playing.users_id = users.id
      GROUP BY quiz_playing.users_id
      HAVING COUNT(quiz_playing.users_id) >= 5
      ORDER BY result DESC
      LIMIT 3;"
    );

    $stmt->execute();

    $res = $stmt->get_result();
    
    while($row = $res->fetch_assoc()) {
      foreach($resultArray as $key => $value) {
        array_push($resultArray[$key], $row[$key]);
      }
    }
    
    $stmt->free_result();
    $stmt->close();

    return $resultArray;
  }
?>