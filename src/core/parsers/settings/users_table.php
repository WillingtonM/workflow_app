<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th scope="col" class=""></th>
            <th scope="col" class=""></th>
        </tr>
    </thead>
    <tbody>

        <?php if (is_array($usr_qry) || is_object($usr_qry)) : ?>
            <?php $count = 0 ?>
            <?php foreach ($usr_qry as $key => $usr) : ?>
                <?php $image = (($usr != null) ? img_path(ABS_USER_PROFILE, $usr['user_image'], 1) : '') ?>
                <?php $ful_name = $usr['name'] . ' ' . $usr['last_name'] ?>
                <?php $usr_name = $usr['username'] ?>
                <?php $usr_pstn = $usr['user_position'] ?>

                <tr>
                    <th scope="row">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="<?= $image ?>" width="45" class="border-radius-lg" alt="...">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <b><?= $ful_name ?></b> <small style="color: #777777;"></small>
                                <br>
                                <span class="alt_dflt"> <?= $usr_pstn ?> <small>(<?= $usr['user_type'] ?>)</small> </span>
                            </div>
                        </div>
                    </th>
                    <td class="">
                        <button type="button" class="btn btn-warning float-end me-2" name="button" onclick="requestModal(post_modal[11], post_modal[11],  {'user': <?= $usr['user_id'] ?>})" style="padding: 5px 15px;" <?= ((!$is_admin) ? 'disabled' : '') ?>> <span><i class="fa-solid fa-list-check me-2"></i> Tasks </span> </button>
                        <button type="button" class="btn btn-secondary float-end me-1" name="button" onclick="requestModal(post_modal[10], post_modal[10],  {'user_id': <?= $usr['user_id'] ?>})" style="padding: 5px 15px;" <?= ((!$is_admin) ? 'disabled' : '') ?>> <span><i class="fas fa-user-edit me-2"></i> Edit </span> </button>
                    </td>
                </tr>
                <?php $count++ ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </tbody>
</table>