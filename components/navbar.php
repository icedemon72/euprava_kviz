<?php
  header("HTTP/1.1 403 Forbidden");

  function generateNavbar($active) {
    $isActive = array('', '', '');
    if($active == 'pocetna') {
      $isActive[0] = 'active';
    } else if ($active == 'kviz') {
      $isActive[1] = 'active';
    } else if ($active == 'o nama') {
      $isActive[2] = 'active';
    }
?>

<nav class="navbar navbar-expand-lg navbar_main">
    <div class="container-fluid">
      <a class="navbar-brand " href="/kviz/">
        <img src="./images/favicon.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
        Kvizzi
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item" >
            <a class="nav-link <?php echo $isActive[0]; ?>" aria-current="page" href="/kviz/">Početna</a>
          </li>
          <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle <?php echo $isActive[1] ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              KVIZ
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="/kviz/pages/quiz.php">IGRAJ!</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item " href="/kviz/pages/stats.php">Statistika</a></li>
              <li><a class="dropdown-item" href="/kviz/pages/stats.php">Dodaj pitanje</a></li>
              <li><a class="dropdown-item" href="/kviz/pages/stats.php">Dodaj kategoriju</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $isActive[2]?>" href="">O nama</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" required oninvalid="this.setCustomValidity('Unesite nešto.')" />
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <div class="navbar-nav ps-3 dropdown dropstart d-md-flex align-items-center">          
            <?php if (isset($_SESSION['username'])) : ?>
              <a class="d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/kviz/images/account_image.png" height="40" width="40" alt="Nalog" loading="lazy" />
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuAvatar">
                <li>
                  <a class="dropdown-item" href="#">Moj profil</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Podešavanja</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Izloguj se</a>
                </li>
              </ul>
            <?php else : ?>
              <a class="nav-link" href="/kviz/login.php">Prijavi se</a>
              <a class="nav-link registration_button" href="/kviz/register.php">Registruj se</a>
            <?php endif; ?>
          
        </div>

      </div>
    </div>
  </nav>

<?php } ?>