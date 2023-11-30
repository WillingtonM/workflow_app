    <div class="col-12 shadow/ bg-white px-3" style="border-radius: 25px;">
        <div class="row">

            <div class="clearfix p-0 m-0"></div>

            <table class="table table-striped col-12">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class=""></th>
                        <th scope="col" class=""></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (is_array($usrt_qry) || is_object($usrt_qry)) : ?>
                        <?php $count = 0 ?>
                        <?php foreach ($usrt_qry as $key => $usr) : ?>
                            <?php $is_default = (isset($usr['user_type_default'])) ? $usr['user_type_default'] : 0 ?>
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-3">
                                            <b><?= ucfirst($usr['user_type']) ?></b> <br>
                                        </div>
                                    </div>
                                </th>
                                <td class="">
                                    <?php if (!$is_default): ?>
                                        <a type="button" class="btn btn-secondary float-end btn-sm/ me-2" name="button" onclick="requestModal(post_modal[19], post_modal[19], {'user_type_uid': <?= $usr['user_type_id'] ?>})" style="padding: 5px 15px;" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <span><i class="fas fa-user-edit me-2"></i> Edit </span> </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $count++ ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </tbody>
            </table>

        </div>
    </div>
