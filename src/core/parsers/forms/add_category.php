	<div class="col-12">
        <form id="category_form" class="col-12" method="POST">
            <input type="hidden" name="form_type" value="category_form">

            <div id="tittleDiv" class="input-group mb-3">
                <span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-cubes-stacked"></i> </b> </span>
                <div class="form-floating form-floating-group flex-grow-1">
                    <input type="text" name="category" class="special_form form-control shadow-none" id="category" value="<?= ((isset($req_res['category'])) ? $req_res['category'] : '') ?>" placeholder="Task Category" style="border-radius: 0 12px 12px 0;">
                    <label for="category">Task Category</label>
                </div>
                <section id="titleFeedback" class="valid-feedback">
                    Invalid Task Category
                </section>
                <input type="hidden" class="invalid_text" value="Invalid Task Category">
            </div>

            <input type="hidden" name="category_id" value="<?= ((isset($category_id) && !empty($category_id)) ? $req_res['category_id'] : '') ?>">

        </form>

    </div>

    <div id="user_error_pop" class="user_error_pop col-12 mt-4 mb-1"></div>

    <div class="col-12">
        <?php if (isset($category_id) && !empty($category_id)) : ?>
        <button class="btn shadow-none text-danger float-end border-radiusl-lg" onclick="postCheck('user_error_pop', {'form_type':'category_remove', 'category_id':<?= $req_res['category_id'] ?>}, 0);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa fa-trash me-2" aria-hidden="true"></i> Remove</button>
        <?php endif; ?>
		<button class="btn btn-secondary shadow-none btn-sm border-radiusl-lg <?= (isset($category_id) && !empty($category_id)) ? '' : 'col-12' ?>" onclick="postCheck('user_error_pop', $('#category_form').serialize(), 0, true);" <?= ((!$is_admin) ? 'disabled' : '') ?>> <?= ((isset($_POST['category_uid']) && !empty($_POST['category_uid'])) ? 'Edit' : 'Add') ?> Task Category</button>
    </div>
