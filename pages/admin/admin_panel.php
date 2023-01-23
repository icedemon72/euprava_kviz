<?php
session_start();
if (!$_SESSION['admin'] || !isset($_SESSION['username'])) {
  header('Location: ./../../index.php');
  exit();
}

$superAdmin = false;

$hideClass = ' ';

if($_SESSION['username'] == 'ice') {
  $superAdmin = true;
  $hideClass = 'd-none d-md-table-cell';
}

require_once('./../../auth/connect_db.php');
require_once('./../../components/navbar.php');
require_once('./../../components/footer.php');
require_once('./../../auth/settings.php');
require_once('./admin_panel_functions.php');

$selectedArray = array('selected', '', '');
$countedUsers = countUsers($conn);

if(isset($_GET['pageNum']) && $_GET['pageNum'] != '') {
  $pageNum = $_GET['pageNum'];
} else {
  $pageNum = 1;
}

if($pageNum < 1) {
  $pageNum = 1;
}

$totalNumberOfPages = ceil($countedUsers / 10);
$prevPage = $pageNum - 1;
if($prevPage < 1) {
  $prevPage = $pageNum;
}

$nextPage = $pageNum + 1;
if($nextPage > $totalNumberOfPages) {
  $nextPage = $totalNumberOfPages;
}

$userInfo = getSortedArrayBy('username', $pageNum - 1, 9, $conn);

if (isset($_GET['sortsubmit'])) {
  $userInfo = getSortedArrayBy($_GET['sortby'], 0, 9, $conn);

  $selectedArray = ($_GET['sortby'] == 'email') ? array('', '', 'selected') : (
      ($_GET['sortby'] == 'date') ? array('', 'selected', '') : array('selected', '', '')
    );
}

if(isset($_POST['permission']) && $superAdmin) {
  $userIndex = (int) explode("_", $_POST['permission'])[0];
  $userPermission = (string) explode("_", $_POST['permission'])[1];
  $usernameToChange = $userInfo['username'][$userIndex];
  if($userInfo['username'][$userIndex] != 'ice') {
    if($userInfo['is_admin'][$userIndex][0] == 'Korisnik' && $userPermission == 'Admin') {
      giveAdmin($userInfo['username'][$userIndex], $conn);
      header("Refresh:0"); 
    } else if ($userInfo['is_admin'][$userIndex][0] == 'Admin' && $userPermission == 'Korisnik') {
      removeAdmin($userInfo['username'][$userIndex], $conn);
      header("Refresh:0"); 
    }
  }
}

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
  <link rel="stylesheet" href="<?= $PATH . '/style/style_admin.css' ?>">
  <title>Kvizzi | Admin panel</title>

</head>

<body>
  <!-- Navbar -->
  <?php
  generateNavbar('', $PATH);
  ?>
  <div class="container-fluid mt-5">
    <div class="row d-flex justify-items-start">
      <div class="col-lg-3 col-md-6 offset-md-5 offset-lg-7 ">
        <label for="sortby">Sortiraj po:</label>
        <form class="d-flex" method="get">
          <select class="form-select d-inline mx-1" aria-label="Default select example" name="sortby">
            <option value="username" <?= $selectedArray[0] ?>>Korisničkom imenu</option>
            <option value="date" <?= $selectedArray[1] ?>>Datumu pridruživanja</option>
            <option value="email" <?= $selectedArray[2] ?>>E-mail adresi</option>
          </select>
          <input class="btn btn-block change_profile_btn align-middle" type="submit" value="Primeni" name="sortsubmit" />

        </form>

      </div>
    </div>

    <div class="row d-flex justify-content-center">
      <div class="col-lg-8 col-md-10 col-sm-12">
        <table class="table table-striped table-responsive">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Korisničko ime</th>
              <th class="d-none d-md-table-cell" scope="col">Ime i prezime</th>
              <th scope="col">E-mail</th>
              <th class="d-none d-md-table-cell" scope="col">Registrovan</th>
              <th class="<?= $hideClass ?>" scope="col">Profil</th>
              <?php if($superAdmin): ?>
                <th scope="col">Status</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 0; $i < sizeof($userInfo['username']); $i++) { ?>
              <tr class="<?= $userInfo['is_admin'][$i][0] ?>">
                <th scope="row"><?= $i + 1 ?></th>
                <td title=<?= $userInfo['username'][$i] ?>><?= shortenString($userInfo['username'][$i]) ?></td>
                <td class="d-none d-md-table-cell" title=<?= $userInfo['name'][$i] ?>> <?= shortenString($userInfo['name'][$i], 16) ?></td>
                <td title=<?= $userInfo['email'][$i] ?>><?= shortenString($userInfo['email'][$i], 24) ?></td>
                <td class="d-none d-md-table-cell"><?= $userInfo['registration_date'][$i] ?></td>
                <td class="<?= $hideClass ?>"><a class="admin_link" href="<?= $PATH . '/pages/profile/profile.php?user=' . $userInfo['username'][$i] ?>">[&#8594;]</a></td>
                <?php if($superAdmin): ?>
                  <td class="<?php $superAdmin ? 'd-none d-md-table-cell' : '' ?>">
                    <form method="post">
                      <select onchange="this.form.submit()" name="permission">
                        <option value="<?= $i. '_' . $userInfo['is_admin'][$i][0] ?>" selected><?=$userInfo['is_admin'][$i][0]?></option>
                        <option value="<?= $i. '_' . $userInfo['is_admin'][$i][1] ?>"><?=$userInfo['is_admin'][$i][1]?></option>
                      </select>
                    </form>
                  </td>
              <?php endif; ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="container">
          <div class="row d-flex justify-content-center">
            <p class="text-center">Pronadjeno <?= $countedUsers ?> korisnika</p>
            <div class="d-flex justify-content-center">
              <div class="container-fluid d-flex justify-content-center mt-5 mb-5">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="?pageNum=<?= $prevPage ?>">Nazad</a></li>
                  <?php if ($totalNumberOfPages < 10) { ?>
                    <?php for ($i = 1; $i <= $totalNumberOfPages; $i++) : ?>
                      <?php if ($i == $pageNum) { ?>
                        <li class="active page-item"><a class="page-link" href="#"><?= $i ?></a></li>
                        <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                        <?php } ?>
                      <?php endfor; ?>
                    <?php } else if ($totalNumberOfPages > 10) { ?>
                      <?php if ($pageNum <= 4) { ?>
                        <?php for ($i = 1; $i < 8; $i++) { ?>
                          <?php if ($i == $pageNum) { ?>
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

                    <?php for ($i = $pageNum - 2; $i <= $pageNum + 2; $i++) : ?>
                      <?php if ($i == $pageNum) { ?>
                        <li class="active page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                      <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="?pageNum=<?= $i ?>"><?= $i ?></a></li>
                      <?php } ?>
                    <?php endfor; ?>

                    <li class="page-item"><a class="page-link">...</a></li>
                    <li class="page-item"><a class="page-link" href="?pageNum=<?= ($totalNumberOfPages - 1) ?>"><?= ($totalNumberOfPages - 1) ?></a></li>
                    <li class="page-item"><a class="page-link" href="?pageNum=<?= $totalNumberOfPages ?>"><?= $totalNumberOfPages ?></a></li>
                  <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="?pageNum=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?pageNum=2">2</a></li>
                    <li class="page-item"><a class="page-link">...</a></li>

                    <?php for ($i = $totalNumberOfPages - 6; $i <= $totalNumberOfPages; $i++) : ?>
                      <?php if ($i == $pageNum) { ?>
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
      </div>
    </div>
  </div>

  <div class="container-fluid footer_container">

  </div>

  <script src="<?= $PATH . '/scripts/bootstrap.bundle.min.js' ?>"></script>
</body>

</html>