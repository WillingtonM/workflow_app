    <!-- Modal -->
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
    <div class="row">
        <h5 class="col-12 p-3 shadow mb-3"> <?= ($practice) ? 'Edit': 'Add' ?> Practice Area </h5>

        <div class="col-12" id="form_member">

            <form id="practiceForm" class="form-horizontal" action="" method="POST">
                <div class="form-floating mb-2 has-validation">
                    <input id="practice" type="text" name="practice" value="<?= (($practice != null) ? $practice['practice_area'] : '') ?>" class="form-control shadow-none" placeholder="Practice Area">
                    <label for="event_title"> Practice Area </label>
                    <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                        <span>Invalid Practice Area</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Practice Area">
                </div>
                <?php if ($practice != null) : ?>
                    <input type="hidden" name="practice_id" value="<?= $practice_id ?>">
                <?php endif; ?>
                <input type="hidden" name="form_type" value="practice_add">

                <div id="member_err" class="col-12" style="padding: 9px 0px;"></div>

                <div class="col-12">
                    <?php if (isset($practice_id) && !empty($practice_id)) : ?>
                    <button type="button" class="btn shadow-none text-danger float-end border-radiusl-lg" onclick="postCheck('member_err', {'form_type':'practice_remove', 'practice_id':<?= $practice['practice_area_id'] ?>}, 0); return;" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa fa-trash me-2" aria-hidden="true"></i> Remove</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-secondary shadow-none btn-sm border-radiusl-lg <?= (isset($practice_id) && !empty($practice_id)) ? '' : 'col-12' ?>" onclick="postCheck('member_err', $('#practiceForm').serialize(), 0, true);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <?= (($practice != null) ? 'Edit' : 'Add') ?> </button>
                </div>

            </form>
        </div>

    </div>
    <div class="col-12" id="error_pop"></div>
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>