<?php
  function shortenString($str, $length = 24) {
    if(strlen($str) > $length) {
      return (substr($str, 0, $length) . '...');
    }
    return $str;
  }

  function getResults($query, $conn) {
    $resArray = array(
      'username' => array(),
      'first_name' => array(),
      'last_name' => array()
    );

    $stmt = $conn->prepare(
      "SELECT 
        users.username,
        users.first_name,
        users.last_name
      FROM users
      WHERE 
        users.username LIKE CONCAT('%',?,'%')
        OR users.first_name LIKE CONCAT(?,'%')
        OR users.last_name LIKE CONCAT(?,'%')
      LIMIT 10;"
    );

    $stmt->bind_param('sss', $query, $query, $query);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      foreach($resArray as $key => $value) {
        array_push($resArray[$key], shortenString($row[$key]));
      }
    }

    $stmt->free_result();
    $stmt->close();

    return $resArray;
  }
?>