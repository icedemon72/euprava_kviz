<?php
  session_start();
  if(!$_SESSION['admin'] || !isset($_SESSION['username'])) {
    header('Location: ./../../index.php');
    exit();
  }
  require_once('./../../auth/connect_db.php');
  require_once('./../../components/navbar.php');
  require_once('./../../components/footer.php');
  require_once('./../../auth/settings.php');
  require_once('./admin_panel_functions.php');

  $userInfo = getSortedArrayBy('username', 0, 9, $conn);
  $selectedArray = array('selected', '', '');
  $countedUsers = countUsers($conn) + 502;
  $page = 0;

  if(isset($_POST['counterplus'])) {
    echo $page;
    if($page != ceil($countedUsers / 10)) {
      $page++;
    } 
  }

  if(isset($_POST['counterminus'])) {
    if($page != 0) {
      $page--;
    } 
    
  }

  if(isset($_GET['sortsubmit'])) {
    $userInfo = getSortedArrayBy($_GET['sortby'], 0, 9, $conn);

    $selectedArray = ($_GET['sortby'] == 'email') ? array('', '', 'selected') : 
      (
        ($_GET['sortby'] == 'date') ? array('', 'selected', '') : array('selected', '', '')
      ); 
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
  <link rel="stylesheet" href="<?=$PATH.'/style/style_admin.css'?>">
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
            <option value="username" <?=$selectedArray[0]?> >Korisničkom imenu</option>
            <option value="date" <?=$selectedArray[1]?>>Datumu pridruživanja</option>
            <option value="email" <?=$selectedArray[2]?>>E-mail adresi</option>
          </select>
          <input class="btn btn-block change_profile_btn align-middle" type="submit" value="Primeni" name="sortsubmit"/>
          
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
              <th scope="col">Profil</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i = 0; $i < sizeof($userInfo) ; $i++) { ?>
              <tr>
                <th scope="row"><?=$i + 1?></th>
                <td title=<?= $userInfo['username'][$i] ?> ><?= shortenString($userInfo['username'][$i]) ?></td>
                <td class="d-none d-md-table-cell" title=<?= $userInfo['name'][$i] ?>> <?= shortenString(($userInfo['name'][$i])) ?></td>
                <td title=<?= $userInfo['email'][$i] ?>><?= shortenString($userInfo['email'][$i], 24) ?></td>
                <td class="d-none d-md-table-cell"><?= $userInfo['registration_date'][$i] ?></td>
                <td><a class="admin_link" href="<?=$PATH.'/pages/profile/profile.php?user='.$userInfo['username'][$i] ?>">[&#8594;]</a></td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <div class="container">
          <div class="row d-flex justify-content-center">
            <p class="text-center">Pronadjeno <?=$countedUsers?> korisnika</p>
            <div class="d-flex justify-content-center">
              <form method="post">
                <input type="submit" name="counterminus" value="&#9664;" />
                <?php for($i = $page * 10 + 1; $i <= ($page * 10) + 10; $i++) { 
                  if(ceil($countedUsers / 10) < $page) {
                    break;
                  } else {
                    $output = $i;
                  }
                ?>
                  <input type="submit" name="show" value="<?=$output?>">
                  <?php } ?>
                  <input type="submit" name="counterplus" value="&#9654;" />

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid footer_container">

  </div>
  
  <script src="<?=$PATH.'/scripts/bootstrap.bundle.min.js'?>"></script>
</body>

</html>