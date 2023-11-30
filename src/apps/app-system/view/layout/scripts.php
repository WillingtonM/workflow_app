<!--   Core JS Files   -->

<script src="./js/plugins/jquery-3.4.1.min.js"></script>
<script defer src="./js/plugins/jquery-ui.js"></script>
<script defer src="./js/plugins/jquery.cookie.min.js"></script>
<script src="./js/core/popper.min.js"></script>
<script src="./js/core/bootstrap.min.js"></script>
<!-- <script src="./js/plugins/perfect-scrollbar.min.js"></script> -->
<script src="./js/plugins/smooth-scrollbar.min.js"></script>
<script src="./js/plugins/chartjs.min.js"></script>
<!-- <script src="./js/plugins/all.js"></script> -->

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/pyxhldi7tlm3orj3sorroa9hzpcqrn24fc3frplxuk7sonz0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<!-- <script src="./js/dashboard.js?v=1.0.3"></script> -->
<script src="./js/dashboard.min.js?v=1.0.3"></script>
<!-- <script src="./js/dashboard.js.map"></script> -->

<!-- custom js files -->
<script defer src="./js/function.min.js"></script>
<script defer src="./js/master.min.js"></script>
<script defer src="./js/helpers.min.js"></script>

<!-- custom css -->
<?php $js_page_file = DIST_JS_CUSTOM . $page . '.min.js' ?>
<?php if (file_exists($js_page_file)) : ?>
    <script defer src="./<?= $js_page_file ?>"></script>
<?php endif; ?>