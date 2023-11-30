<div class="row">
    <div class="col-12 shadow p-3 mb-3 bg-white rounded">
        <sapn class="font-weight-bolder text-center text-secondary ps-3"><?= (isset($career) && !empty($career)) ? 'Edit' : 'Add' ?> Career </sapn>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <form id="careerForm" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">

            <div class="form-row mb-3 px-2">
                <div class="col-12" id="gender">
                    <label for="gender" class="text-secondary">Career type</label> <br>
                    <?php foreach ($career_types as $key => $type) : ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="career_type" id="<?= $key ?>" value="<?= $key ?>" <?= ((!empty($career) && $career['career_period_type'] == $key) ? 'checked' : '') ?>>
                            <label class="form-check-label" for="<?= $key ?>"><?= $type ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-floating mb-2 has-validation">
                <input type="text" name="career_name" value="<?= ((isset($career['career_name'])) ? $career['career_name'] : '') ?>" class="form-control shadow-none" id="career_name" placeholder="Career name" required>
                <label for="career_name"> Career name </label>
                <div id="careerTitleFeedback" class="valid-feedback ps-3 mt-0">
                    <span>Invalid Career name</span>
                </div>
                <input type="hidden" class="invalid_text" value="Invalid Career name">
            </div>

            <div class="form-floating mb-2 has-validation">
                <input type="text" name="career_location" value="<?= ((isset($career['career_location'])) ? $career['career_location'] : '') ?>" class="form-control shadow-none" id="career_location" placeholder="Career location" required>
                <label for="career_location"> Career location </label>
                <div id="careerTitleFeedback" class="valid-feedback ps-3 mt-0">
                    <span>Invalid Career location</span>
                </div>
                <input type="hidden" class="invalid_text" value="Invalid Career location">
            </div>

            <div class="form-floating mb-2 has-validation">
                <input type="text" name="career_amount" value="<?= ((isset($career['career_amount'])) ? $career['career_amount'] : '') ?>" class="form-control shadow-none" id="career_amount" placeholder="Career salary" required>
                <label for="merchant_name"> Career salary </label>
                <div id="careerTitleFeedback" class="valid-feedback ps-3 mt-0">
                    <span>Invalid Career salary</span>
                </div>
                <input type="hidden" class="invalid_text" value="Invalid Career salary">
            </div>

            <div class="form-floating mb-2 has-validation">
                <textarea id="mytextarea/" class="form-control shadow-none border-radius-none" name="career_description" rows="4" cols="100" value="" placeholder="Career Description" style=""><?= ((isset($career['career_description'])) ? htmlspecialchars($career['career_description']) : '') ?></textarea>
                <label for="career_description"> Career Description </label>
                <div id="careerTitleFeedback" class="valid-feedback ps-3 mt-0">
                    <span>Invalid Career Description</span>
                </div>
                <input type="hidden" class="invalid_text" value="Invalid Career Description">
            </div>

            <div class="col-auto mb-3">
                <label for="" class="px-2 text-secondary">Closing date</label>
                <div class="row g-3 mb-0">
                    <div class="col-4 col-md-2/">
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fas fa-calendar-day"></i> </span>
                            <?php $date_days = range(1, 31, 1) ?>
                            <select class="form-control shadow-none" name="closing_day">
                                <?php foreach ($date_days as $value) : ?>
                                    <option value="<?= $value ?>" <?= ((isset($career['career_closing_date']) && (int) date('d', strtotime($career['career_closing_date'])) == $value) ? 'selected' : ((!isset($career['career_closing_date']) && empty($career['career_closing_date']) && $value == (int)date('d')) ? 'selected' : '')) ?>> <?= $value ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-4 col-md-2/">
                        <select class="form-control shadow-none" name="closing_month">
                            <?php foreach ($date_months as $val => $month) : ?>
                                <option value="<?= $val ?>" <?= ((isset($career['career_closing_date']) && (int) date('m', strtotime($career['career_closing_date'])) == $val) ? 'selected' : ((!isset($career['career_closing_date']) && empty($career['career_closing_date']) && $val == (int)date("m")) ? 'selected' : '')) ?>> <?= $month ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-4 col-md-2/">
                        <?php $date_days = range(date("Y"), 2090, -1) ?>
                        <select class="form-control shadow-none" name="closing_year">
                            <?php foreach ($date_days as $value) : ?>
                                <option value="<?= $value ?>" <?= ((isset($career['career_closing_date']) && (int) date('Y', strtotime($career['career_closing_date'])) == $value) ? 'selected' : ((!isset($career['career_closing_date']) && empty($career['career_closing_date']) && $value == date("Y")) ? 'selected' : '')) ?>> <?= $value ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
            </div>

            <?php if (isset($_POST['career']) && $_POST['career'] != '') : ?>
                <input id="career" type="hidden" name="career" value="<?= $_POST['career'] ?>">
            <?php endif; ?>
            <input type="hidden" name="form_type" value="career_form">
        </form>
    </div>

</div>

<div class="row">
    <div id="error_pop" class="col-md-12"></div>

    <div class="col-12 mt-4">
        <?php if (isset($career) && !empty($career)) : ?>
            <a type="button" class="btn btn-danger btn-sm shadow-none text-white float-end border-radius-lg" onclick="postCheck('error_pop', {'career_remove':true,'career':<?= $career['career_id'] ?>});" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Remove</a>
        <?php endif; ?>
        <button class="btn btn-secondary btn-sm border-radius-lg shadow-none" onclick="postCheck('error_pop', $('#careerForm').serialize(), 0, true)" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <?= ((isset($_POST['career']) && $_POST['career'] != '') ? 'Edit' : 'Add') ?> Career </button>
    </div>
</div>