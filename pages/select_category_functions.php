<?php
  function getCategories($conn) {
    $stmt = $conn->prepare(
      "SELECT quiz_type.id, quiz_type.name, 
        quiz_type.times_played, quiz_type.image, 
        quiz_type.score, quiz_type.active
      FROM quiz_type
      LEFT JOIN questions ON quiz_type.id = questions.quiz_type_id
      HAVING COUNT(questions.quiz_type_id) > 30 AND quiz_type.active = 1;"
    );

    $stmt->execute();
    $result = $stmt->get_result();
    $resArray = array(
      'id' => array(),
      'name' => array(),
      'times_played' => array(),
      'image' => array(),
      'score' => array()
    );

    while($row = $result->fetch_assoc()) {
      array_push($resArray['id'], $row['id']);
      array_push($resArray['name'], $row['name']);
      array_push($resArray['image'], $row['image']);
    }

    $stmt->free_result();
    $stmt->close();

    for($i = 0; $i < sizeof($resArray['id']); $i++) {
      $score = 0;
      $count = 0;

      $stmt = $conn->prepare(
        "SELECT quiz_playing.score
        FROM quiz_playing
        WHERE quiz_playing.quiz_type_id = ? 
        AND quiz_playing.score IS NOT NULL;"
      );

      $stmt->bind_param('i', $resArray['id'][$i]);
      $stmt->execute();
      $res = $stmt->get_result();

      while($row = $res->fetch_assoc()) {
        $score += $row['score'];
        $count++; 
      }

      $stmt->free_result();
      $stmt->close();

      ($count == 0) ? array_push($resArray['score'], 0) : array_push($resArray['score'], round($score / $count, 2));
      array_push($resArray['times_played'], $count);
      
    }
    
    return $resArray;
  }
?>