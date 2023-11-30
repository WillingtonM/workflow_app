<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
<div class="row">
    <div class="col-12 shadow p-3 mb-3 bg-white rounded">
        <sapn class="font-weight-bolder text-center text-secondary ps-3"><?= (isset($media_res) && !empty($media_res)) ? 'File | <small><i class="text-secondary">' . $media_res['media_title'] . '</i></small>' : 'Add File' ?> </sapn>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <form id="mediaForm" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">
            <div class="col-auto contact_radio mb-3"><br>
                <label for="file_type" class="text-secondary">File type</label> <br>
                <?php $count = 0 ?>
                <?php foreach ($file_types as $key => $file) : ?>
                    <?php $count++ ?>
                    <div class="form-check form-check-inline me-3">
                        <input class="form-check-input me-2" type="radio" name="file_type" id="reasonRadio<?= $count ?>" value="<?= $key ?>" <?= ((($key == 'registration' && !isset($req_res['file_type'])) || (isset($req_res['file_type']) && $req_res['file_type'] == $key)) ? 'checked' : '') ?>>
                        <label class="custom-control-label text-muted" for="reasonRadio<?= $count ?>"><?= $file ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div id="tittleDiv" class="input-group mb-2">
                <span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-file-contract"></i> </b> </span>
                <div class="form-floating form-floating-group flex-grow-1">
                    <input type="text" name="media_title" class="special_form form-control shadow-none" id="media_title" value="<?= ((isset($media_res) && !empty($media_res)) ? $media_res['media_title'] : '') ?>" placeholder="Document Title" style="border-radius: 0 12px 12px 0;">
                    <label for="media_title">Document title</label>
                </div>
                <section id="titleFeedback" class="valid-feedback">
                    Invalid Document title
                </section>
                <input type="hidden" class="invalid_text" value="Invalid Document title">
            </div>


            <div id="dateDiv" class="input-group mb-2">
                <span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-calendar-day"></i> </b> </span>
                <div class="form-floating form-floating-group flex-grow-1">
                    <input type="date" name="media_publish_date" class="special_form form-control shadow-none" id="media_publish_date" value="<?= ((isset($media_res['media_publish_date'])) ? date('Y-m-d', strtotime($media_res['media_publish_date'])) : '') ?>" placeholder="YYYY/mm/dd" style="border-radius: 0 12px 12px 0;">
                    <label for="media_publish_date">Document Published date</label>
                </div>
                <section id="dateFeedback" class="valid-feedback">
                    Invalid Published date
                </section>
                <input type="hidden" class="invalid_text" value="Invalid Published date">
            </div>

            <input id="link" type="hidden" name="media_url" value="<?= ((isset($media_res) && !empty($media_res)) ? $media_res['media_url'] : '') ?>" class="form-control" placeholder="File Link">

            <div id="contentDiv" class="mb-2 d-flex">
                <span class="input-group-text flex-shrink-1 border-end-0 border-radius-end-none" style="border-radius: 12px 0 0 12px"><b class="mt-3"> <i class="fa-solid fa-file-lines"></i> </b> </span>
                <div class="form-floating form-floating-group flex-grow-1/ w-100">
                    <textarea class="special_form form-control shadow-none" id="media_content" name="media_content" value="" rows="4" cols="80" placeholder="File Content" style="border-radius: 0 12px 12px 0;"><?= ((isset($media_res['media_content'])) ? $media_res['media_content'] : '') ?></textarea>
                    <label for="media_content">File Description</label>
                </div>
                <section id="dateFeedback" class="valid-feedback">
                    Invalid File Description
                </section>
                <input type="hidden" class="invalid_text" value="Invalid File Description">
            </div>

            <input type="hidden" name="media_type" value="file">
            <?php if (isset($_POST['media_id']) && $_POST['media_id'] != '') : ?>
                <input id="media_id" type="hidden" name="media_id" value="<?= $_POST['media_id'] ?>">
            <?php endif; ?>
        </form>
    </div>
    <div class="col-sm-6">
        <form id="product_form_img" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">
            <div class="row col-md-12" style="width: 100%;">
                <div class="col-md-12" align="center" id="product_preview">

                </div>
            </div>
            <div class="input-group">
                <div class="custom-file mb-3">
                    <label class="custom-file-label file_label_2" for="file_doc"><i class="fa fa-upload"></i> <span id="label_span_1">Upload Document</span></label>
                    <input type="file" class="form-control border w-100" name="file_doc" id="file_doc" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
                </div>
            </div>
        </form>

        <div class="col-12 p-3" style="border-top: 5px solid #aaa">
            <form id="mediaForm_" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">

                <?php
                if (isset($media_res) && !empty($media_res['media_image'])) :
                    $file_name  = $media_res['media_image'];
                    $file_parts = pathinfo($file_name);
                    $fl_ext     = 'fa-file';
                    $text_colr  = 'text-secondary';
                    if (array_key_exists('extension', $file_parts)) {
                        switch ($file_parts['extension']) {
                            case "pdf":
                                $fl_ext = 'fa-file-pdf';
                                $text_colr = 'text-danger';
                                break;
                            case "doc" || 'docx':
                                $fl_ext = 'fa-file-word';
                                $text_colr = 'text-primary';
                                break;
                            case "": // Handle file extension for files ending in '.'
                                $fl_ext = 'fa-file';
                            case NULL: // Handle no file extension
                                $fl_ext = 'fa-file';
                                break;
                        }
                    }

                    $doc_name = ABS_FILES . $file_name;
                endif;
                ?>

                <h5 class="col-12" id="file_upld_cntnr">
                    <a class="doc_anchor text-secondary me-2" href="<?= (isset($doc_name)) ? $doc_name : '' ?>">
                        <i class="me-2 <?= (isset($fl_ext)) ? 'fa  ' . $fl_ext . ' ' . $text_colr : '' ?> " aria-hidden="true"></i> <?= (isset($media_res['media_image'])) ? $media_res['media_image'] : '' ?>
                    </a>
                    <embed id="file_upload" type="application/pdf" class="image" src="<?= (isset($doc_name)) ? $doc_name . '#page=1&zoom=75' : '' ?>" <?php if (isset($media_res) && !empty($media_res['media_image'])) : ?> width="575" height="500" style="width: 100%; max-height: 300px; overflow-y: hidden !important; overflow: hidden;" <?php endif; ?>>
                </h5>
                <div id="product_preview"></div>
                <div id="modal_add_errors"></div>

            </form>
        </div>
    </div>
</div>

<div class="row">
    <div id="error_span" class="col-12"></div>
    <div id="error_pop" class="col-12"></div>

    <div class="col-12">
        <?php if (isset($media_res) && !empty($media_res)) : ?>
            <a type="button" class="btn btn-sm border-radius-lg text-danger float-end border border-3 border-danger" onclick="postCheck('error_pop', {'media_remove':true,'media_id':<?= $media_res['media_id'] ?>});" <?= ((!$is_admin) ? 'disabled' : '') ?>> <i class="fa fa-trash" aria-hidden="true"></i> &nbsp; Remove</a>
        <?php endif; ?>
        <button class="btn btn-warning btn-sm border-radius-lg" onclick="media_post()" <?= ((!$is_admin) ? 'disabled' : '') ?>><i class="fa fa-file-upload me-2"></i> <?= ((isset($_POST['media_id']) && $_POST['media_id'] != '') ? 'Edit' : 'Add') ?> Document</button>
    </div>
</div>

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

<?php echo ob_get_clean(); ?>