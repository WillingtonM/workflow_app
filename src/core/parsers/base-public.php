<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php require_once $header; ?>

<body id="body-div" class="g-sidenav-show body-<?= $page ?>">
  <input id="site_type" type="hidden" name="site_type" value="public">
  <input id="subscription_active" type="hidden" name="site_type" value="<?= (isset(PAGE_SETTINGS['subscription_popup'])) ? PAGE_SETTINGS['subscription_popup'] : '' ?>">
  <input id="token" type="hidden" name="token" value="<?= get_token(); ?>">

  <div class="loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
  </div>
  <?php if (PAGE_SETTINGS['subscription_active']) : ?>
    <div class="text-center booking-parent btn shadow-none" onclick="requestModal(post_modal[9], post_modal[9], {})">
      <center>
        <img src="<?= PROJECT_LOGO ?>" class="text-center" width="53" height="53" loading="lazy" alt="<?= PROJECT_TITLE ?>">
      </center>
      <div class="col w-100 side_btn_text border-radius-lg p-1">
        <a class="text-center booking-text cursor-pointer">
          <small class="font-weight-bolder">BOOKINGS</small>
        </a>
      </div>
    </div>
  <?php endif; ?>

  <?php if (!in_array($page, $page_excludes) || (isset($_SESSION['user_id']) && $_SESSION['user_status'] == TRUE && in_array($page, $page_excludes))) : ?>
    <?php require_once $navbar; ?>
    <?php require_once $side_content; ?>
  <?php elseif($page == 'login'): ?>
    <?php require_once $layout_path . 'login_nav.php'; ?>
  <?php endif; ?>

  <main class="main-content position-relative max-height-vh-100 h-100 p-0 m-0 border-radius-lg bg-<?= $page ?>">
    <div id="container-1" class="container-<?= $page ?> p-0">
      <?php if (!in_array($page, $page_excludes) || (isset($_SESSION['user_id']) && $_SESSION['user_status'] == TRUE && in_array($page, $page_excludes))) : ?>
        <div id="body" class="body_div-<?= $page ?> p-0 container-fluid <?= ((isset($_SESSION['window_resize']) && $_SESSION['window_resize'] == true) ? 'body_toggle' : '') ?>">
          <?php require_once $main_content; ?>
        </div>
      <?php elseif (isset($_SESSION['user_id']) || (in_array($page, $page_excludes))) : ?>
        <div id="body-<?= $page ?>" class="container bg-white/">
          <?php require_once $main_content; ?>
        </div>
      <?php endif; ?>

      <?php require_once $layout_path . 'modals.php'; ?>

      <div id="modalDiv" class="modalDiv" style="z-index: 99999;"></div>

      <footer class="footer/ fixed-bottom/ bg-white/ shadow pt-2" style="z-index: 1;">
        <div class="container">
          <?php if ( !in_array($page, $page_excludes)) : ?>
            <?php require_once $footer; ?>
          <?php endif; ?>
        </div>
      </footer>
    </div>

  </main>

  <!-- scripts -->
  <?php require_once $js_scripts ?>
</body>

</html>