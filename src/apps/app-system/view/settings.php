<div class="container px-2">

    <nav aria-label="breadcrumb mb-0">
        <ol class="breadcrumb px-3 shadow-sm" style="border-radius: 15px">
            <li class=" breadcrumb-item font-weight-bolder"><a class="def_text" href="#">Settings</a></li>
            <li class="breadcrumb-item font-weight-bolder active" aria-current="page">Subscriptions</li>
        </ol>
    </nav>
    <div class="row shadow p-3 mb-5 bg-white border-radius-xl/" style="border-radius: 15px;">

        <h6> Subscriptions Popup </h6>
        <form class="col-12 mb-3 mb-3">
            <div class="form-check">
                <input id="subscription_popup" class="form-check-input" name="subscription_popup" value="true" type="checkbox" <?= (PAGE_SETTINGS['subscription_popup']) ? 'checked' : '' ?>>
                <label id="ubscription_popup_label" class="form-check-label" for="flexCheckDefault">
                    <?= (PAGE_SETTINGS['subscription_popup']) ? 'Enabled' : 'Disabled' ?>
                </label>
            </div>
        </form>

        <h6> Activate Email Subscriptions </h6>
        <form class="col-12 mb-3">
            <div class="form-check">
                <input id="subscription_active" class="form-check-input" name="subscription_active" value="true" type="checkbox" <?= (PAGE_SETTINGS['subscription_active']) ? 'checked' : '' ?>>
                <label id="subscription_active_label" class="form-check-label" for="flexCheckDefault">
                    <?= (PAGE_SETTINGS['subscription_active']) ? 'Enabled' : 'Disabled' ?>
                </label>
            </div>
        </form>
    </div>

    <nav aria-label="breadcrumb mb-0">
        <ol class="breadcrumb px-3 shadow-sm" style="border-radius: 15px">
            <li class=" breadcrumb-item font-weight-bolder"><a class="def_text" href="#">Settings</a></li>
            <li class="breadcrumb-item font-weight-bolder active" aria-current="page">Articles</li>
        </ol>
    </nav>
    <div class="row shadow p-3 mb-5 bg-white border-radius-xl/" style="border-radius: 15px;">
        <h6> Article email type </h6>
        <form class="col-12 mb-3">
            <div class="form-checkme-3">
                <input class="form-check-input me-2 article_email_type" type="radio" name="article_length" id="article_email_short" value="0" <?= ((!PAGE_SETTINGS['article_email_length']) ? 'checked' : '') ?>>
                <label id="label_0" class="custom-control-label text-muted" for="article_email_short"> Short article </label>
            </div>

            <div class="form-checkme-3">
                <input class="form-check-input me-2 article_email_type" type="radio" name="article_length" id="article_email_long" value="1" <?= ((PAGE_SETTINGS['article_email_length']) ? 'checked' : '') ?>>
                <label id="label_1" class="custom-control-label text-muted" for="article_email_long"> Long article </label>
            </div>
        </form>

        <h6> Article email header text </h6>
        <form id="header_form" class="col-12 mb-3" action="">
            <div class="col-auto">
                <div id="" class="">
                    <textarea id="textarea_header" class="form-control" name="" rows="8" cols="100" value="" placeholder="Email header text" style="border-radius: none !important; width:100% !important"><?= ((PAGE_SETTINGS['setting_email_header']) ? PAGE_SETTINGS['setting_email_header'] : '') ?></textarea>
                </div>
                <!-- <small class="text-muted col px-3">Email header text</small> -->
            </div>

            <input type="hidden" name="form_name" value="article_header">
            <div class="col-12 mb-3 px-3">
                <div id="error_pop" class="error_pop mb-3"></div>
                <button type="button" class="btn btn-sm btn-secondary px-3 shadow-none" style="border-radius: 11px;" onclick="function_tinytext_forms('header_form', 'textarea_header')" <?= ((!$is_admin) ? 'disabled' : '') ?>>Save Article email header text</button>
            </div>
        </form>

        <h6> Article email footer text </h6>

        <form id="footer_form" class="col-12 mb-3" action="">
            <div class="col-auto">
                <div id="" class="">
                    <textarea id="mytextarea" class="form-control" name="" rows="8" cols="100" value="" placeholder="Email footer text" style="border-radius: none !important; width:100% !important"><?= ((PAGE_SETTINGS['setting_email_footer']) ? PAGE_SETTINGS['setting_email_footer'] : '') ?></textarea>
                </div>
                <!-- <small class="text-muted col px-3">Email footer text</small> -->
            </div>

            <input type="hidden" name="form_name" value="article_footer">
            <div class="col-12 mb-3 px-3">
                <div id="error_pop" class="error_pop mb-3"></div>
                <button type="button" class="btn btn-sm btn-secondary px-3 shadow-none" style="border-radius: 11px;" onclick="function_tinytext_forms('footer_form', 'mytextarea')" <?= ((!$is_admin) ? 'disabled' : '') ?>>Save Article email footer tex</button>
            </div>
        </form>
    </div>


</div>

<script>
    // function function_tinytext_forms(form_id, input_id) {
    //     console.log(input_id);
    //     var html_id = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'null';
    //     var content = encodeURIComponent(tinyMCE.get('textarea_header').getContent());
    //     var data_1 = $('#' + form_id).serialize();
    //     data_1 = post_data_default + '&' + data_1;
    //     data_1 = data_1 + '&article_content=' + content;

    //     postCheck(html_id, data_1);
    // }
</script>