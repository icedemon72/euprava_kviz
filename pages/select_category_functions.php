<?php
  function getCategories($conn) {
    $stmt = $conn->prepare(
      "SELECT quiz_type.id, quiz_type.name, 
        quiz_type.times_played, quiz_type.image, 
        quiz_type.score, quiz_type.active
      FROM quiz_type
      LEFT JOIN questions ON  quiz_type.id = questions.quiz_type_id
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
      array_push($resArray['times_played'], $row['times_played']);
      array_push($resArray['image'], $row['image']);
      array_push($resArray['score'], $row['score']);
    }

    $stmt->free_result();
    $stmt->close();

    return $resArray;
  }
?>