<?php
  session_start();
  require_once('./../components/navbar.php');
  require_once('./../components/footer.php');
  require_once('./../auth/settings.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?=$PATH.'/images/favicon.png'?>" type="image/x-icon">
  <link rel="stylesheet" href="<?=$PATH.'/style/bootstrap.min.css'?>">
  <link rel="stylesheet" href="<?=$PATH.'/style/style.css'?>">
  <title>Kvizzi | O nama</title>

</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <?php generateNavbar('o nama', $PATH) ?>

  <div class="container-fluid">
    <div class="row d-flex justify-content-center">
      <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
      </div>
    </div>
  </div>

  <div class="container-fluid my-4">
    <iframe class="i_frame_map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Lole%20Ribara%2029,%20Kosovska%20Mitrovica+(Kvizzi)&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
      <a href="https://www.maps.ie/distance-area-calculator.html">measure acres/hectares on map</a>
    </iframe>
  </div>

  <?php generateFooter($PATH) ?>
  <script src="<?=$PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
</body>

</html>