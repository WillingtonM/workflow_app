<style>
.log-ease {
  height: 4.0rem;
  position: absolute;
  top: -10px !important;

  -webkit-transition: max-height 0.22s;
  -moz-transition: max-height 0.22s;
  transition: max-height 0.22s;
}
</style>
<div id="headnav" class="topnavbar fixed-top">
  <div class="container position-sticky z-index-sticky top-0 p-0 m-0/">
    <div class="row">
      <div class="col-12 p-0 m-0">
        <!-- Navbar -->
        <nav id="navbar" class="login navbar navbar-expand-lg top-0 z-index-3 shadow my-3 py-2 start-0 end-0 mx-4 position-relative" style="border-radius: 18px; height: 60px;">
          <div class="container-fluid position-relative/">

            <a class="navbar-brand log-card d-block d-lg-none" href="./">
              <img id="navbar-brand-img" src="<?= PROJECT_LOGO_SMALL ?>" height="30" loading="lazy" alt="<?= PROJECT_TITLE ?>">
              <span class="name_ref name_card_alt font-weight-bolder text-uppercase/ text-white"> <?= PROJECT_TITLE ?> </span>
            </a>

            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
              <ul class="navbar-nav justify-content-end">
                <li class="nav-item">
                  <a class="nav-link nav_text def_text"> &nbsp; </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav_text text-dark" style="color: #29374B !important" href="home"><i class="fa-solid fa-home me-1"></i> Home </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav_text text-dark" style="color: #29374B !important" href="features"><i class="fa-solid fa-layer-group me-1"></i> Features </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav_text text-dark" style="color: #29374B !important" href="about"><i class="fa-solid fa-circle-info me-1"></i> About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav_text text-dark" style="color: #29374B !important" href="contact"> <i class="fa-solid fa-address-book me-1"></i> Contact </a>
                </li>
              </ul>
              <ul class="navbar-nav d-lg-block d-none">
                <li class="nav-item">
                  <!-- <a class="btn btn-sm mb-0 border-radius-lg bg-gradient-dark/ btn-dark" href="./login"> Login </a> -->
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