    <!-- Modal -->
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
    <div class="row">
        <p class="co-12 px-4 mb-3">
            <small class="font-weight-light font-size-sm mb-3">
                <?php if ($user_type == 'client') : ?>
                    Assign <strong class="text-warning"> Applicant / Executor </strong> to <strong class="text-warning"> Client Association </strong>
                <?php else: ?>
                    Assign <strong class="text-warning"> Client Association </strong> to <strong class="text-warning"> Applicant / Executor </strong>
                <?php endif; ?>

            </small>
        </p>
        <h5 class="col-12 p-3 px-4 shadow mb-3">
            <?php if ($user_type == 'client') : ?>
                    Assign <span class="text-danger font-weight-bolder"><?= (isset($member['name'])) ? $member['name'] . ' | ' . $member['username']  : '' ?></span> to <span class="text-warning font-weight-bolder"><?= (isset($user['association_name'])) ? $user['association_name'] : '' ?></span> 
                <?php else: ?>
                    Assign <span class="text-danger font-weight-bolder"><?= (isset($member['association_name'])) ? $member['association_name'] : '' ?></span> to <span class="text-warning font-weight-bolder"><?= (isset($user['name'])) ? $user['name'] . ' | ' . $user['username'] : '' ?></span> 
            <?php endif; ?>
        </h5>

        <div class="col-12" id="form_member">

            <form id="assignForm" class="form-horizontal">
                <div class="col-auto contact_radio mb-3 px-3"><br>
                    <label for="practice_area" class="text-secondary">Choose practice area</label> <br>
                    <?php $count = 0 ?>
                    <?php foreach ($practices as $key => $practice) : ?>
                        <?php $count++ ?>
                        <div class="form-check form-check-inline me-3">
                            <input class="form-check-input me-2" type="radio" name="practice_area" id="reasonRadio<?= $count ?>" value="<?= $practice['practice_area_id'] ?>" <?= ((( $count) == 1 ) ? '' : '') ?>>
                            <label class="custom-control-label text-muted" for="reasonRadio<?= $count ?>"><?= $practice['practice_area'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <input type="hidden" name="form_type" value="search_assign">
                <input type="hidden" name="user" value="<?= $user_id ?>">
                <input type="hidden" name="member" value="<?= $member_id ?>">
                <input type="hidden" name="user_type" value="<?= $user_type ?>">

                <div id="assign_message" class="col-12" style="padding: 9px 0px;"></div>

                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-secondary px-3 shadow-none col-12" style="border-radius: 11px;" onclick="postCheck('assign_message', $('#assignForm').serialize(), 0, true)" <?= ((!$is_admin) ? 'disabled' : '') ?>> Assign </button>
                </div>
            </form>
        </div>

    </div>
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>
