<?php
  function getUserIdByUsername($user, $conn) {
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

  function countAchievements($conn) {
    $stmt = $conn->prepare(
      "SELECT id
      FROM achievements"
    );

    $stmt->execute();
    $stmt->store_result();

    $count = $stmt->num_rows();

    $stmt->free_result();
    $stmt->close();
    return $count;
  }

  function getAchievementId($title, $conn) {
    $achievementId = 0;
    $stmt = $conn->prepare(
      "SELECT id
      FROM achievements
      WHERE achievements.title = ?;"
    );

    $stmt->bind_param('s', $title);
    $stmt->execute();
    $res = $stmt->get_result();

    while($row = $res->fetch_assoc()) {
      $achievementId = $row['id'];
    }

    $stmt->free_result();
    $stmt->close();

    return $achievementId;

  }

  function checkIfUserHasAchievement($userId, $achievementId, $conn) {
    $stmt = $conn->prepare(
      "SELECT users_id, achievements_id
      FROM user_has_achievement
      WHERE status = 1 
      AND user_has_achievement.users_id = ? 
      AND user_has_achievement.achievements_id = ?;"
    );

    $stmt->bind_param('ii', $userId, $achievementId);
    $stmt->execute();
    $stmt->store_result();
    
    $count = $stmt->num_rows();
    
    $stmt->free_result();
    $stmt->close();

    return($count > 0);
  }

  function checkIfUserHasAllAchievements($userId, $conn) {
    $stmt = $conn->prepare(
      "SELECT id
      FROM user_has_achievement
      WHERE user_has_achievement.users_id = ? 
      AND user_has_achievement.status = 1;"
    );

    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $stmt->store_result();
    
    $count = $stmt->num_rows();
    
    $stmt->free_result();
    $stmt->close();

    return(countAchievements($conn) - 1 == $count);
  } 

  function awardAchievement($achievementTitle, $conn, $userId = 0) {
    if($userId == 0) {
      $userId = getUserIdByUsername($_SESSION['username'], $conn);
    }

    $achievementId = getAchievementId($achievementTitle, $conn);
    $date = date_format(date_create(), 'Y-m-d H:i:s');
    $status = 1;

    if(!checkIfUserHasAchievement($userId, $achievementId, $conn)) {
      $stmt = $conn->prepare(
        "INSERT INTO user_has_achievement (users_id, achievements_id, date_unlocked, status)
        VALUES(?, ?, ?, ?);"
      );
      $stmt->bind_param('iisi', $userId, $achievementId, $date, $status);
      $stmt->execute();
      $stmt->free_result();
      $stmt->close();
    }

    if(checkIfUserHasAllAchievements($userId, $conn)) {
      awardAchievement('Vukov "Riječnik" I izdanje', $conn, $userId);
    }
  }
?>