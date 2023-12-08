<div id="headnav" class="topnavbar fixed-top">
  

  <div class="container position-sticky z-index-sticky top-0 p-0 m-0/">
    <div class="row">
      <div class="col-12 p-0 m-0">
        <!-- Navbar -->
        <nav id="navbar" class="navbar navbar-expand-lg top-0 z-index-3 shadow my-3 py-2 start-0 end-0 mx-4 position-absolute/ position-relative" style="border-radius: 18px; height: 60px;">
          <div class="container-fluid position-relative/">

            <a class="navbar-brand log-card d-none d-sm-block" href="home">
              <img id="navbar-brand-img" class="brand_light" src="<?= PROJECT_LOGO_WHITE ?>" height="30" width="" loading="lazy" alt="<?= PROJECT_TITLE ?>">
              <img id="navbar-brand-img_" class="brand_dark" src="<?= PROJECT_LOGO_WHITE_SMALL ?>" height="30" width="" loading="lazy" alt="<?= PROJECT_TITLE ?>">
            </a>

            <a class="navbar-brand log-card d-block d-sm-none" href="home">
              <img id="navbar-brand-img_x" src="<?= PROJECT_LOGO_WHITE ?>" height="30" width="" loading="lazy" alt="<?= PROJECT_TITLE ?>">
            </a>

            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
              <ul class="navbar-nav mx-auto/ justify-content-end">
                <li class="nav-item">
                  <a class="nav-link nav_text def_text"> &nbsp; </a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link nav_text def_text <?= ((isset($page) && $page == "home") ? 'active nav_text_left' : '') ?>" href="home"><i class="fa-solid fa-home me-1"></i> Home </a>
                </li> -->
                <li class="nav-item">
                  <a class="nav-link nav_text def_text <?= ((isset($page) && $page == "features") ? 'active nav_text_left' : '') ?>" href="features"><i class="fa-solid fa-layer-group me-1"></i> Features </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav_text def_text <?= ((isset($page) && $page == "about") ? 'active nav_text_left' : '') ?>" href="about"><i class="fa-solid fa-circle-info me-1"></i> About</a>
                </li>
                <li class="nav-item me-3">
                  <a class="nav-link nav_text def_text <?= ((isset($page) && $page == "contact") ? 'active nav_text_left' : '') ?>" href="contact"> <i class="fa-solid fa-address-book me-1"></i> Contact </a>
                </li>
              </ul>
              <ul class="navbar-nav">
                <li class="nav-item d-lg-none d-block">
                  <a class="p-1"> </a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-sm mb-0 border-radius-lg bg-gradient-dark/ btn-dark" href="./login"> Login / Sign up</a>
                </li>
                <li class="nav-item d-lg-none d-block">
                  <a class="p-1"> </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>

</div>
<div id="navbarholder" class=""></div>