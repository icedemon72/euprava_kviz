<?php
  session_start();
  require_once('./../components/navbar.php');
  require_once('./../components/footer.php');
  require_once('./../auth/settings.php');
  require_once('./../auth/connect_db.php');
  require_once('./stats_functions.php');

  if(isset($_GET['pageNum']) && $_GET['pageNum'] != '' && gettype($_GET['pageNum']) == 'int') {
    $pageNum = $_GET['pageNum'];
  } else {
    $pageNum = 1;
  }

  if($pageNum < 1) {
    $pageNum = 1;
  }

  $statsInfo = getSortedResult(($pageNum - 1) * 10, $conn);
  $totalNumberOfPages = getTotalNumberOfPages(10, $conn);



  $prevPage = $pageNum - 1;
  if($prevPage < 1) {
    $prevPage = $pageNum;
  }

  $nextPage = $pageNum + 1;
  if($nextPage > $totalNumberOfPages) {
    $nextPage = $totalNumberOfPages;
  }

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
      <h5 class="mb-5 text-center">Tabela rezultata</h5>
      <div class="col-lg-8 col-md-10 col-sm-12 mb-5">
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
            <?php for($i = 0; $i < sizeof($statsInfo['username']); $i++) {?>
              <tr>
                <th ><?= ($i + 1) * ($pageNum) ?></th>
                <td title="<?= $statsInfo['username'][$i] ?>"><?= shortenString($statsInfo['username'][$i]) ?></td>
                <td><?= shortenString($statsInfo['name'][$i], 30) ?></td>
                <td scope="row"><?= $statsInfo['result'][$i] ?></td>
                <td><a class="stats_link" href="<?=$PATH.'/pages/profile/profile.php?user='.$statsInfo['username'][$i] ?>">[&#8594;]</a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <small class="text-muted text-right">*Samo korisnici sa bar 5 odigranih kvizzova su prikazani</small>
        <div class="container-fluid d-flex justify-content-center mt-5 mb-5">
          <ul class="pagination">
            <li class="page-item"><a class="page-link" href="?pageNum=<?=$prevPage ?>">Nazad</a></li>
            <?php if($totalNumberOfPages < 10) { ?>
              <?php for($i = 1; $i <= $totalNumberOfPages; $i++): ?>
                <?php if($i == $pageNum) { ?>
                  <li class="active page-item"><a class="page-link" href="#"><?= $i ?></a></li>
                <?php } else { ?>
                  <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                <?php } ?>
              <?php endfor; ?>
            <?php } else if($totalNumberOfPages > 10) { ?>
              <?php if($pageNum <= 4) { ?>
                <?php for($i = 1; $i < 8; $i++) { ?>
                  <?php if($i == $pageNum) { ?>
                    <li class="active page-item"><a class="page-link" href="#"><?= $i ?></a></li>
                  <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                  <?php } ?>
                <?php } ?>
                <li class="page-item"><a class="page-link">...</a></li>
                <li class="page-item"><a class="page-link" href="?pageNum=<?= ($totalNumberOfPages - 1) ?>"><?= ($totalNumberOfPages - 1) ?></a></li>
                <li class="page-item"><a class="page-link" href="?pageNum=<?= $totalNumberOfPages ?>"><?= $totalNumberOfPages ?></a></li>
              <?php } else if ($pageNum > 4 && $pageNum < $totalNumberOfPages - 4) { ?>
                <li class="page-item"><a class="page-link" href="?pageNum=1">1</a></li>
                <li class="page-item"><a class="page-link" href="?pageNum=2">2</a></li>
                <li class="page-item"><a class="page-link">...</a></li>
                
                <?php for($i = $pageNum - 2; $i <= $pageNum + 2; $i++):?>
                  <?php if($i == $pageNum){ ?>
                    <li class="active page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                  <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                  <?php }?>
                <?php endfor; ?>

                <li class="page-item"><a class="page-link">...</a></li>
                <li class="page-item"><a class="page-link" href="?pageNum=<?= ($totalNumberOfPages - 1) ?>"><?= ($totalNumberOfPages - 1) ?></a></li>
                <li class="page-item"><a class="page-link" href="?pageNum=<?= $totalNumberOfPages ?>"><?= $totalNumberOfPages ?></a></li>
              <?php } else { ?>
                <li class="page-item"><a class="page-link" href="?pageNum=1">1</a></li>
                <li class="page-item"><a class="page-link" href="?pageNum=2">2</a></li>
                <li class="page-item"><a class="page-link">...</a></li>
                <?php for($i = $totalNumberOfPages - 6; $i <= $totalNumberOfPages; $i++): ?>
                  <?php if($i == $pageNum) { ?>
                    <li class="active page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                  <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                  <?php } ?>
                <?php endfor; ?>

              <?php } ?>
            <?php }  ?>
            
            <li class="page-item"><a class="page-link" href="?pageNum=<?= $nextPage ?>" class="page-link">Napred</a></li>
            <li class="page-item"><a class="page-link" href="?pageNum=<?= $totalNumberOfPages ?>" class="page-link">Kraj</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  

  <?php generateFooter($PATH) ?>
  <script src="<?=$PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
</body>

</html>