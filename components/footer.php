<?php function generateFooter($PATH) { ?>
<div class="footer_container mt-auto">
  <footer class="text-center text-lg-start">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
      <!-- Left -->
      <div class="me-5 d-none d-lg-block">
        <span>Hvala Vam što ste posetili naš sajt! :)</span>
      </div>
      <!-- Left -->

      <!-- Right -->
      <div>
        <a href="" class="me-4 link-secondary">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="me-4 link-secondary">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="me-4 link-secondary">
          <i class="fab fa-google"></i>
        </a>
        <a href="" class="me-4 link-secondary">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="" class="me-4 link-secondary">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="" class="me-4 link-secondary">
          <i class="fab fa-github"></i>
        </a>
      </div>
      <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold mb-4">KVIZZI!</h6>
            <p>Kvizzi ne bi bio ono što jeste bez korisnika koji nesebično dele svoje ideje sa nama, veliko hvala!</p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Korisni sajtovi
            </h6>
            <p>
              <a href="https://www.trivianerd.com/" class="text-reset">TriviaNerd</a>
            </p>
            <p>
              <a href="https://www.randomtriviagenerator.com/" class="text-reset">Random Trivia Generator</a>
            </p>
            <p>
              <a href="https://trivia.fyi/" class="text-reset">Trivia.fyi</a>
            </p>
            <p>
              <a href="https://kvizovi.rs/" class="text-reset">Kvizovi</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Korisne stranice
            </h6>
            <p>
              <a href="<?=$PATH.'/pages/quiz/add_category.php'?>" class="text-reset">Dodavanje kategorije</a>
            </p>
            <p>
              <a href="<?=$PATH.'/pages/select_category.php'?>" class="text-reset">Igraj kviz!</a>
            </p>
            <p>
              <a href="<?=$PATH.'/pages/stats.php'?>" class="text-reset">Tabela</a>
            </p>
            <p>
              <a href="<?=$PATH.'/pages/about_us.php'?>" class="text-reset">O nama</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">Kontakt</h6>
            <p>Prirodno-matematički fakultet</p>
            <p>Kosovska Mitrovica</p>
            <p>jsailovic72@gmail.com</p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
      © 2022 Copyright: <span class="text-reset fw-bold">Jovan Isailovic</span>
    </div>
    <!-- Copyright -->
  </footer>
</div>
<!-- Footer -->

<?php } ?>
