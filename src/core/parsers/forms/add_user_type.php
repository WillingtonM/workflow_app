	<div class="col-12">
        <form id="user_type_form" class="col-12" method="POST">
            <input type="hidden" name="form_type" value="user_type_form">

            <div id="tittleDiv" class="input-group mb-3">
                <span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-user-group"></i> </b> </span>
                <div class="form-floating form-floating-group flex-grow-1">
                    <input type="text" name="user_type" class="special_form form-control shadow-none" id="user_type" value="<?= ((isset($req_res['user_type'])) ? $req_res['user_type'] : '') ?>" placeholder="User Type" style="border-radius: 0 12px 12px 0;">
                    <label for="user_type">User Type</label>
                </div>
                <section id="titleFeedback" class="valid-feedback">
                    Invalid User Type
                </section>
                <input type="hidden" class="invalid_text" value="Invalid User Type">
            </div>

            <div class="mb-3">
                 <h6 class="ms-3 mb-3">
                    <span class="text-secondary"> Is user admin? </span>
                </h6>
                <div class="ms-3 col">
                    <div class="form-check form-switch float-end/ me-3">
                        <input type="checkbox" name="is_admin" class="form-check-input" value="true" id="is_admin" <?= ((isset($req_res['user_type_admin']) && $req_res['user_type_admin'] == 1) ? 'checked' : '') ?>>
                        <label class="form-check-label font-weight-bolder text-secondary ms-1" for="is_admin"> Admin user </label>
                    </div>
                </div>
            </div>

            <div class="mb-2">
                 <h6 class="ms-3 mb-3">
                    <span class="text-secondary"> User type permission </span>
                </h6>
                <div class="ms-3 col">
                    <?php $count = 0 ?>
                    <?php foreach ($user_permissions as $key => $permision) : ?>
                        <?php $count++ ?>
                        <div class="form-check form-switch float-end/ me-3">
                            <input type="checkbox" name="<?= $key ?>" class="form-check-input" value="true" id="btncheck<?= $count ?>" <?= ((isset($req_res['permission_' . $key]) && $req_res['permission_' . $key] == 1) ? 'checked' : '') ?>>
                            <label class="form-check-label font-weight-bolder text-secondary ms-1" for="btncheck<?= $count ?>"> <?= $permision['short'] ?> </label>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

            <input type="hidden" name="user_type_id" value="<?= ((isset($user_type_id) && !empty($user_type_id)) ? $req_res['user_type_id'] : '') ?>">

        </form>

    </div>

    <div id="user_error_pop" class="user_error_pop col-12 mt-4 mb-1"></div>

    <div class="col-12">
        <?php if (isset($user_type_id) && !empty($user_type_id)) : ?>
        <button class="btn shadow-none text-danger float-end border-radiusl-lg" onclick="postCheck('user_error_pop', {'form_type':'user_type_remove', 'user_type_id':<?= $req_res['user_type_id'] ?>}, 0);" <?= ((!$is_admin) ? 'disabled' : '') ?>> <i class="fa fa-trash me-2" aria-hidden="true"></i> Remove</button>
        <?php endif; ?>
		<button class="btn btn-secondary shadow-none btn-sm border-radiusl-lg <?= (isset($user_type_id) && !empty($user_type_id)) ? '' : 'col-12' ?>" onclick="postCheck('user_error_pop', $('#user_type_form').serialize(), 0, true);" <?= ((!$is_admin) ? 'disabled' : '') ?>> <?= ((isset($_POST['user_type_uid']) && !empty($_POST['user_type_uid'])) ? 'Edit' : 'Add') ?> User Type</button>
    </div>
