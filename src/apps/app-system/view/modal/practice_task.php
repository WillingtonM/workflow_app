    <!-- Modal -->
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
    <div class="row">
        <h5 class="col-12 p-3 px-4 shadow mb-3"> <?= ($practice) ? 'Edit': 'Add' ?> Practice task </h5>

        <div class="col-12" id="form_member">

            <form id="practiceAreaForm" class="form-horizontal">
                <div class="col-auto contact_radio mb-3 px-3"><br>
                    <label for="practice_area" class="text-secondary">Choose Practice Area</label> <br>
                    <?php $count = 0 ?>
                    <?php foreach ($practices as $key => $pract) : ?>
                        <?php $count++ ?>
                        <div class="form-check form-check-inline me-3">
                            <input class="form-check-input me-2" type="radio" name="practice_area" id="reasonRadio<?= $count ?>" value="<?= $pract['practice_area_id'] ?>" <?= (((isset($practice) && !empty($practice) && $practice['practice_area_id'] == $pract['practice_area_id']) || count($practices) < 2) ? 'checked' : '') ?>>
                            <label class="custom-control-label text-muted" for="reasonRadio<?= $count ?>"><?= $pract['practice_area'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="task_name" type="text" name="task_name" value="<?= (($practice != null) ? $practice['practice_task_name'] : '') ?>" class="form-control shadow-none" placeholder="Task name">
                    <label for="task_name"> Task name</label>
                    <div class="valid-feedback ps-3 mt-0">
                        <span>Invalid Task name</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Task name">
                </div>

                <div class="form-floating mb-2 has-validation">
                    <textarea id="task_text" class="form-control shadow-none" name="task_text" placeholder="Task Description" rows="4" style="width: 100%;" required><?= (($practice != null) ? $practice['practice_task_text'] : '') ?></textarea>
                    <label for="task_text"> Task Description </label>
                    <div class="valid-feedback ps-3 mt-0">
                        <span>Invalid Task Description</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid User Description">
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="task_position" type="number" name="task_position" value="<?= (($practice != null) ? $practice['practice_task_position'] : ($tasks_count + 1) ) ?>" class="form-control shadow-none" placeholder="Task Position">
                    <label for="task_position"> Task Position</label>
                    <div class="valid-feedback ps-3 mt-0">
                        <span>Invalid Task Position</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Task Position">
                </div>

                <div class="mb-2">
                    <h6 class="ms-3 mb-2">
                        <span class="text-secondary"> Send SMS? </span>
                    </h6>
                    <div class="ms-3 col">
                        <div class="form-check form-switch me-3">
                            <input type="checkbox" name="send_sms" class="form-check-input" value="true" id="send_sms" <?= ((isset($practice['practice_task_sms']) && $practice['practice_task_sms'] == 1) ? 'checked' : '') ?>>
                            <label class="form-check-label font-weight-bolder text-secondary ms-1" for="send_sms"> Send SMS </label>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3 has-validation">
                    <input id="sms_text" type="text" name="sms_text" value="<?= (($practice != null) ? $practice['practice_task_sms_text'] : '') ?>" class="form-control shadow-none" placeholder="Task SMS Text">
                    <label for="sms_text">Task SMS Text</label>
                    <div class="valid-feedback ps-3 mt-0">
                        <span>Invalid Task SMS Text</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Task SMS Text">
                </div>

                <div class="mb-2">
                    <h6 class="ms-3 mb-2">
                        <span class="text-secondary"> Send Eamil? </span>
                    </h6>
                    <div class="ms-3 col">
                        <div class="form-check form-switch me-3">
                            <input type="checkbox" name="send_email" class="form-check-input" value="true" id="send_email" <?= ((isset($practice['practice_task_email']) && $practice['practice_task_email'] == 1) ? 'checked' : '') ?>>
                            <label class="form-check-label font-weight-bolder text-secondary ms-1" for="send_email"> Send Email </label>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <div id="" class="">
                        <textarea id="textarea_header" class="form-control border-radius-lg shadow-none" name="" rows="8" cols="100" value="" placeholder="Email text" style="border-radius: none !important; width:100% !important"><?= (($practice != null) ? $practice['practice_task_email_text'] : '') ?></textarea>
                    </div>
                </div>

                <?php if ($practice != null) : ?>
                    <input type="hidden" name="practice_id" value="<?= $practice_id ?>">
                <?php endif; ?>
                <input type="hidden" name="form_type" value="practice_area">

                <div id="member_err" class="col-12" style="padding: 9px 0px;"></div>

                <div class="col-12">
                    <?php if (isset($practice_id) && !empty($practice_id)) : ?>
                    <button type="button" class="btn shadow-none text-danger float-end border-radiusl-lg" onclick="postCheck('member_err', {'form_type':'practice_task_remove', 'practice_id':<?= $practice['practice_task_id'] ?>}, 0); return;" <?= ((!$is_admin) ? 'disabled' : '') ?>> <i class="fa fa-trash me-2" aria-hidden="true"></i> Remove</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-sm btn-secondary px-3 shadow-none <?= (isset($practice_id) && !empty($practice_id)) ? '' : 'col-12' ?>" style="border-radius: 11px;" onclick="function_tinytext_forms_modal('practiceAreaForm', 'textarea_header', 'member_err')" <?= ((!$is_admin) ? 'disabled' : '') ?>> <?= (($practice != null) ? 'Edit' : 'Add') ?> Task </button>
                </div>

            </form>
        </div>

    </div>
    <div class="col-12" id="error_pop"></div>
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

    <script>
        function function_tinytext_forms_modal(form_id, input_id) {
            console.log(input_id);
            var html_id = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'null';
            var content = encodeURIComponent(tinyMCE.get(input_id).getContent());
            var data_1 = $('#' + form_id).serialize();
            data_1 = post_data_default + '&' + data_1;
            data_1 = data_1 + '&article_content=' + content;
            postCheck(html_id, data_1, 0, true);
        }

        tinymce.init({
            selector: '#mytextarea, #textarea_header,#textarea_header',
            plugins: 'lists media table code image advlist autolink link image charmap preview anchor pagebreak',
            toolbar: 'undo redo addcomment styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | showcomments casechange checklist code formatpainter pageembed permanentpen table image imagetools',
            toolbar_drawer: 'floating',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Tralon Digital Agency',
            images_upload_url: action_path,
            images_upload_handler: function images_upload_handler(blobInfo, _success, failure) {
                var form_data = new FormData();
                form_data.append('file', blobInfo.blob(), blobInfo.filename());
                form_data.append('article_file', true);
                form_data.append('url', post_urls[0]);
                form_data.append('token', token);
                form_data.append('get_type', post_type[0]); // form_data.append('post_image', $("#"+img_id)[0].files[0]);

                $.ajax({
                url: path_action,
                method: "POST",
                data: form_data,
                processData: false,
                contentType: false,
                success: function success(data) {
                    if (is_json_string(data)) {
                    var data = JSON.parse(data);

                    if (data.success) {
                        _success(data.image);
                    }
                    }
                },
                error: function error(XMLHttpRequest, textStatus, errorThrown) {
                    alert('There was an error on your request ! : ' + XMLHttpRequest.statusText);
                }
                });
            }
        });
    </script>