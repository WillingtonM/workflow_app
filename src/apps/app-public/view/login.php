<div id="login" class="container pt-10 min-vh-100">
  <div class="row">
    <div class="col-12 col-xl-8 col-lg-6 d-none d-lg-block">
        <?php require_once $config['PARSERS_PATH'] . 'home_page.php' ?>
    </div>
    <div id="login_panel" class="col-12 col-xl-4 col-lg-6 px-3">
      <div class="card shadow-lg px-3" style="min-height: 67vh !important; border-radius: 30px">
        <?php require_once $config['PARSERS_PATH'] . 'login_psrs.php' ?>
      </div>
    </div>
    
  </div>
</div>
