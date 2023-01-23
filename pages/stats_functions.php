<?php 
  function shortenString($str, $length = 20) {
    if(strlen($str) > $length) {
      return (substr($str, 0, $length) . '...');
    }
    return $str;
  }

  function getTotalNumberOfPages($limit, $conn) {
    $stmt = $conn->prepare(
      "SELECT COUNT(quiz_playing.id)
      FROM quiz_playing
      GROUP BY quiz_playing.users_id;"
    );

    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows();
    $stmt->free_result();
    $stmt->close();

    return ceil($count / $limit);
  }

  function getSortedResult($limit, $conn) {
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
      LIMIT ?, 10;"
    );
    
    $stmt->bind_param('i', $limit);      
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
