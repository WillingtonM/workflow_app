<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<?php require_once $config['PARSERS_PATH'] . 'careers' . DS . 'vacancy_view.php'; ?>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

<script class="script">
    $(document).ready(function() {
        $('#file_doc').change(function(e) {
            $('#product_form_img').submit();
            var files = $(this)[0].files;
            if (files.length != 0) {
                var fileName = e.target.value.split('\\').pop()
                $('#label_span_1').text(fileName);
            }
        });

        $('#product_form_img').on('submit', function(e) {
            e.preventDefault();
            var data = new FormData();
            data.append('url', post_urls[0]);
            data.append('token', token);
            data.append('get_type', post_type[0]);
            data.append('post_image', $("#product_form_img")[0]);

            postFile3('file_upload', 'product_form_img', url_val = 0, '.file_name');

            var file_src = $('#file_upload').prop('src');

        });
    });
</script>