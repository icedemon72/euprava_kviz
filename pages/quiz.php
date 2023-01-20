<?php
  session_start();
  require_once('./quiz_functions.php');
  require_once('./../auth/connect_db.php'); 
  require_once('./../components/navbar.php'); 
  require_once('./../components/footer.php'); 
  require_once('./../auth/settings.php'); 

  if(!isset($_SESSION['username'])) {
    header('Location: ./../login.php');
    die();
  }

  if(!isset($_GET['type']) || !checkType(@$_GET['type'], $conn)) {
    header('Location: ./select_category.php');
    die();
  }
  $quizType = $_GET['type'];
  $quizQuestionNumber = 10;
  $inputValues = array();
  $quizInfo = getQuizInfo($quizType, $quizQuestionNumber, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= $PATH . '/images/favicon.png' ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?= $PATH . '/style/bootstrap.min.css' ?>">
  <link rel="stylesheet" href="<?= $PATH . '/style/style.css' ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@700&display=swap" rel="stylesheet">
  <title>Kvizzi | <?=$quizType?></title>
</head>
<body>
  <?php generateNavbar('kviz', $PATH) ?>

  <div class="container-fluid mb-3">

    <div class="text-center mb-5">
        <h2 class="display-20 display-md-18 display-lg-16 mt-5">KVIZZI!</h2>
    </div>
    <div class="row d-flex justify-content-center quiz_row ">
      <div class="col-sm-11 col-md-9 col-lg-7 col-xl-6 quiz_container shadow rounded overflow-hidden">
        <div class="text-center">
            <h4 class="display-20 display-md-18 display-lg-16 mt-3">Pitanja</h4>
        </div>
        <hr />
        <form method='post' action='./quiz/quiz_submit.php' id="quizForm">
        <?php for($i = 0; $i < sizeof($quizInfo['id']); $i++) { ?>
          <div class="row mb-1 mt-3">
            <p class="question_text d-block">
              <?= $i + 1 . '. ' . $quizInfo['question'][$i] ?>
            </p>
            <div>
              <?php foreach($quizInfo['answers'][$i] as $answers): ?>
                <div>
                  <?php 
                    $w_100 = '';
                    if($quizInfo['type'][$i] == 'input') {
                      $w_100 = 'w-100 form-control';
                    }
                  ?>
                  <label class="answers_text d-inline">
                  <input class="<?= $w_100 ?>" type="<?= $quizInfo['type'][$i] ?>" name="question_<?=$i + 1?>[]"/>
                  
                  <?php if($quizInfo['type'][$i] != 'input'): ?>
                    <?= $answers ?>
                  <?php endif; ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <hr />
      
        <?php } ?>
        <input class="w-100 h-20 mb-3 btn btn-primary reg_btn" type='submit' name='btn' value="Završi kviz!" />
        </form>
      </div>
    </div>
  </div>

  <?php generateFooter($PATH) ?>

  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>
</html>