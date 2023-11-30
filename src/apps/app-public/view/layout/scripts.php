<!--   Core JS Files   -->

<script src="./js/plugins/jquery-3.4.1.min.js"></script>
<script defer src="./js/plugins/jquery-ui.js"></script>
<script defer src="./js/plugins/jquery.cookie.min.js"></script>

<script src="./js/core/bootstrap.min.js"></script>
<!-- <script src="./js/plugins/perfect-scrollbar.min.js"></script> -->
<script src="./js/plugins/smooth-scrollbar.min.js"></script>
<script src="./js/plugins/chartjs.min.js"></script>
<!-- <script src="./js/plugins/all.js"></script> -->

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="./js/core/popper.min.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<!-- <script src="./js/dashboard.js?v=1.0.3"></script> -->
<script src="./js/dashboard.min.js?v=1.0.3"></script>
<!-- <script src="./js/dashboard.js.map"></script> -->

<?php if ($_ENV['PROJECT_STATE'] == 'development') : ?>
    <script defer src="./js/function.js"></script>
    <script defer src="./js/master.js"></script>
    <script defer src="./js/helpers.js"></script>
    <script defer src="./js/custom/settings.js"></script>
    <script defer src="./js/custom/search.js"></script>
    <?php if ($page != 'login'): ?>
    <script defer src="./js/custom/login.js"></script>
    <?php endif; ?>

    <!-- custom css -->
    <?php $js_page_file = DIST_JS_CUSTOM . $page . '.js' ?>
    <?php if (file_exists($js_page_file)) : ?>
        <script defer src="./<?= $js_page_file ?><?= $script_vsn ?>"></script>
    <?php endif; ?>
<?php else : ?>
    <!-- custom js files -->
    <script defer src="./js/function.min.js<?= $script_vsn ?>"></script>
    <script defer src="./js/master.min.js<?= $script_vsn ?>"></script>
    <script defer src="./js/helpers.min.js<?= $script_vsn ?>"></script>
    <script defer src="./js/custom/settings.min.js<?= $script_vsn ?>"></script>
    <script defer src="./js/custom/search.min.js<?= $script_vsn ?>"></script>
    <?php if ($page != 'login'): ?>
    <script defer src="./js/custom/login.min.js<?= $script_vsn ?>"></script>
    <?php endif; ?>

    <!-- custom css -->
    <?php $js_page_file = DIST_JS_CUSTOM . $page . '.min.js' ?>
    <?php if (file_exists($js_page_file)) : ?>
        <script defer src="./<?= $js_page_file ?><?= $script_vsn ?>"></script>
    <?php endif; ?>
<?php endif; ?>