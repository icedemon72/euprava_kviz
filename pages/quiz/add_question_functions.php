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

?>