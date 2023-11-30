<div class="row">
    <div class="col-12 shadow p-3 mb-3 bg-white rounded">
        <div class="flex-grow-1">
            <h5 class="text-center text-md-start ps-3"> <?= $career['career_name'] ?> </h5>

            <div class="list-group list-group-horizontal px-3">
                <a type="button" class="list-group-item list-group-item-action active/">
                    <i class="fa-solid fa-location-dot me-2"></i> <?= $career['career_location'] ?>
                </a>
                <a type="button" class="list-group-item list-group-item-action">
                    <span class="me-1">R</span> <?= $career['career_amount'] ?>
                </a>
                <a type="button" class="list-group-item list-group-item-action">
                    <i class="fa-regular fa-clock me-2"></i> <?= $career_types[$career['career_period_type']] ?>
                </a>
            </div>

            <div class="p-3">
                <div class="bg-light border-radius-lg p-3">
                    <span class="text-secondary font-weight-bolder"> <small class="text-secondary me-2"> Closing Date: </small> <?= date('Y-m-d', strtotime($career['career_closing_date'])) ?></span> <br>

                    <p class="text-dark">
                        <?= $career['career_description'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 p-3">
        <form id="mediaForm" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">

            <div class="form-floating mb-2 has-validation">
                <input type="text" name="career_name" value="<?= (isset($vacancy['application_name'])) ? $vacancy['application_name'] : '' ?>" class="form-control shadow-none" id="career_name" placeholder="Full name" required>
                <label for="career_name"> Full name </label>
                <div id="careerTitleFeedback" class="valid-feedback ps-3 mt-0">
                    <span>Invalid Full name</span>
                </div>
                <input type="hidden" class="invalid_text" value="Invalid Full name">
            </div>

            <div class="form-floating mb-2 has-validation">
                <input type="email" name="career_email" value="<?= (isset($vacancy['application_email'])) ? $vacancy['application_email'] : '' ?>" class="form-control shadow-none" id="career_email" placeholder="Email" required>
                <label for="career_email"> Email </label>
                <div id="careerTitleFeedback" class="valid-feedback ps-3 mt-0">
                    <span>Invalid Email</span>
                </div>
                <input type="hidden" class="invalid_text" value="Invalid Email">
            </div>

            <div class="form-floating mb-2 has-validation">
                <input type="tel" name="career_contact" value="<?= (isset($vacancy['application_contact'])) ? $vacancy['application_contact'] : '' ?>" class="form-control shadow-none" id="career_contact" placeholder="Contact Number" required>
                <label for="merchant_name"> Contact Number </label>
                <div id="careerTitleFeedback" class="valid-feedback ps-3 mt-0">
                    <span>Invalid Contact Number</span>
                </div>
                <input type="hidden" class="invalid_text" value="Invalid Contact Number">
            </div>

            <br>

            <hr class="horizontal dark mt-1 mb-0">

            <?php if (isset($_POST['career']) && $_POST['career'] != '') : ?>
                <input id="career" type="hidden" name="career" value="<?= $career_id ?>">
            <?php endif; ?>
            <input type="hidden" name="form_type" value="career_form">

        </form>

        <form id="product_form_img" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">
            <?php if (isset($_SESSION['user_id'])) : ?>

                <?php
                if (isset($vacancy) && !empty($vacancy['application_file'])) :
                    $file_name  = $vacancy['application_file'];
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

                    $doc_name = ABS_APPLICATION_DOCS . $file_name;
                endif;
                ?>
                <h5 class="col-12" id="file_upld_cntnr">
                    <a class="doc_anchor text-secondary me-2" href="<?= (isset($doc_name)) ? $doc_name : '' ?>" style="padding-bottom: 15px !important;" target="_blank">
                        <i class="me-2 <?= (isset($fl_ext)) ? 'fa  ' . $fl_ext . ' ' . $text_colr : '' ?> " aria-hidden="true"></i> <?= (isset($vacancy['application_file'])) ? $vacancy['application_file'] : 'File name' ?>
                    </a>
                    <embed id="file_upload" type="application/pdf" class="image" src="<?= (isset($doc_name)) ? $doc_name . '#page=1&zoom=75' : '' ?>" <?php if (isset($vacancy) && !empty($vacancy['application_file'])) : ?> width="575" height="500" style="width: 100%; max-height: 300px; overflow-y: hidden !important; overflow: hidden;" <?php endif; ?>>
                </h5>
                <div id="product_preview"></div>
                <div id="modal_add_errors"></div>
            <?php else : ?>
                <div class="row w-100">
                    <div class="col-md-12" align="center" id="product_preview"></div>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label ms-3">Upload your CV </label>
                    <input type="file" class="form-control border w-100" name="file_doc" id="file_doc" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/pdf">
                </div>
            <?php endif; ?>

        </form>

    </div>

</div>

<div class="row">
    <div id="error_pop" class="col-md-12"></div>

    <div class="col-12 mt-4">
        <?php if (isset($career) && !empty($career) && isset($_SESSION['user_id'])) : ?>
            <a type="button" class="btn btn-danger btn-sm shadow-none text-white float-end border-radius-lg" onclick="postCheck('error_pop', {'career_remove':true,'career':<?= $career['career_id'] ?>});" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Remove</a>
        <?php endif; ?>
        <button class="btn btn-secondary btn-sm border-radius-lg shadow-none" onclick="media_post()" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <?= ((isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') ? 'Edit' : 'Add') ?> Career </button>
    </div>
</div>