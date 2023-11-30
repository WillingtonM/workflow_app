    <!-- Modal -->
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
    <div class="row">
        <h5 class="col-12 p-3 shadow mb-3"> <?= ($registry) ? 'Edit': 'Add' ?> Activity Registry </h5>

        <div class="col-12" id="form_member">

            <form id="registryForm" class="form-horizontal" action="" method="POST">
                <div class="form-row align-items-center">

                    <label for="username" class="ps-2">Choose user</label>
                    <div class="form-floating mb-2 has-validation">
                        <select id="user" name="user" value="" class="form-control shadow-none" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                            <option value="">Select User</option>
                            <?php foreach ($registry_users as $key => $usr) : ?>
                                <?php $username = $usr['username'] ?>
                                <?php $name     = $usr['name'] ?>
                                <?php $lastname = $usr['last_name'] ?>
                                <?php if ($usr_arr != null && $user_id == $usr['user_id']) : ?>
                                    <option value="<?= $usr['user_id'] ?>" selected> <?= ucfirst($name . ' ' . $lastname) ?> </option>
                                <?php else : ?>
                                    <option value="<?= $usr['user_id'] ?>"><?= ucfirst($name . ' ' . $lastname) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <textarea class="special_form form-control shadow-none" name="comment" id="comment" placeholder="User comment" rows="3" cols="80" style="border-radius: 12px;"><?= (($registry != null) ? $registry['registry_comment'] : '') ?></textarea>
                        <label for="username">Comment/Message</label>
                    </div>
                
                </div>
                <?php if ($registry != null) : ?>
                    <input type="hidden" name="registry" value="<?= $rgst_id ?>">
                <?php endif; ?>
                <input type="hidden" name="form_type" value="registry_add">

                <div id="member_err" class="col-12" style="padding: 9px 0px;"></div>

                <button class="btn btn-secondary btn-sm col-12" type="button" style="border-radius: 12px; font-weight: bolder;" onclick="postCheck('member_err', $('#registryForm').serialize(), 0, true);" <?= ((!$is_admin) ? 'disabled' : '') ?>> <?= (($usr_arr != null) ? 'Edit' : 'Add') ?> Registry </button>

            </form>
        </div>

    </div>
    <div class="col-12" id="error_pop"></div>
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>