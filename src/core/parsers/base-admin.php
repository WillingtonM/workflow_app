<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php require_once $header; ?>

<body id="body-div" class="g-sidenav-show bg-gray-100 admin_body">
  <input id="token" type="hidden" name="token" value="<?= get_token(); ?>">

  <?php if (!in_array($page, $page_excludes)) : ?>
    <?php require_once $side_content; ?>
  <?php endif; ?>

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <?php if (!in_array($page, $page_excludes)) : ?>
      <?php require_once $navbar; ?>
    <?php endif; ?>

    <div class="container-fluid py-4" style="min-height: 100vh; border: 2px red">
      <?php require_once $main_content; ?>
    </div>
    <div class="container-fluid py-4/">
      <div id="modalDiv" class="modalDiv" style="z-index: 99999;"></div>
      <footer class="footer pt-3">
        <div class="container-fluid">
          <?php require_once $footer; ?>
        </div>
      </footer>
    </div>

  </main>

  <?php if (isset($_SESSION['user_id'])) :  ?>
    <?php require_once $layout_path . 'messaging_sidebar.php' ?>
  <?php endif; ?>
  <!-- scripts -->
  <?php require_once $js_scripts ?>

</body>

</html>