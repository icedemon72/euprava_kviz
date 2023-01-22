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
  <title>Kvizzi | Statistika</title>

</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <?php generateNavbar('kviz', $PATH) ?>

  <div class="container-fluid mt-5">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-8 col-md-10 col-sm-12">
        <table class="table table-striped table-responsive">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Korisničko ime</th>
              <th scope="col">Ime i prezime</th>
              <th scope="col">Prosečan rezultat</th>
              <th scope="col">Profil</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Hello</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
    
  

  <?php generateFooter($PATH) ?>
  <script src="<?=$PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
</body>

</html>