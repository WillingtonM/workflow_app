<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
<div class="container-fluid/ row">

    <h5 class="col-12 p-3 shadow font-weight-bolder">
        <?= (isset($client_name)) ? 'Client Association | <i class="text-danger"> ' . $client_name . ' </i>' : ' Add Client Association' ?>
    </h5>
    <div id="userformErrors" class="col-md-12 p-3"></div>
    <div class="col-12" id="form_member">
        <form id="userForm" class="form-horizontal" action="" method="POST">
            <div class="form-row align-items-center">

                <div class="form-floating mb-2 has-validation">
                    <select id="location" name="location" value="" class="form-control shadow-none" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                        <option value="">Select Office</option>
                        <?php foreach ($offices as $region) : ?>
                            <?php if (($usr_arr != null && $usr_arr['office_id'] == $region['office_id'])) : ?>
                                <option value="<?= $key ?>" selected> <?= ucfirst($region['office_name']) ?> </option>
                            <?php else : ?>
                                <option value="<?= $key ?>"><?= ucfirst($region['office_name']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <label for="username">Choose office</label>

                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="name" type="text" name="name" value="<?= (($usr_arr != null) ? $name : '') ?>" class="form-control shadow-none" placeholder="Name" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                    <label for="name">Name</label>
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="name_other" type="text" name="name_other" value="<?= (($usr_arr != null) ? $name_other : '') ?>" class="form-control shadow-none" placeholder="Surname" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                    <label for="name_other">Identifying name</label>
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="reference" type="text" name="reference" value="<?= (($usr_arr != null) ? $association_reference : '') ?>" class="form-control shadow-none" placeholder="Reference Number" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                    <label for="reference">Reference Number</label>
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="identity" type="text" name="identity" value="<?= (($usr_arr != null) ? $association_identity : '') ?>" class="form-control shadow-none" placeholder="Identity Number" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                    <label for="identity">Identity Number</label>
                </div>

                <div class="form-floating mb-2 has-validation">
                    <textarea class="form-control shadow-none" id="description" name="description" placeholder="Description." rows="4" <?= ((!$is_admin) ? 'disabled' : '') ?>><?= (($usr_arr != null) ? $association_description : '') ?></textarea>
                    <label for="description">Description</label>
                </div>

            </div>
            <?php if ($usr_arr != null) : ?>
                <input type="hidden" name="post_user" value="<?= $user_id ?>">
            <?php endif; ?>
            <input type="hidden" name="form_type" value="member_add">

            <div id="member_err" class="col-12" style="padding: 9px 0px;"></div>

            <button class="btn btn-dark col-12 text-white border-radius-lg" type="button" onclick="postCheck('member_err', $('#userForm').serialize(), 0, true);" <?= ((!$is_admin) ? 'disabled' : '') ?>> Submit <?= (($usr_arr != null) ? 'Changes' : '') ?> </button>

        </form>

        <?php if ($usr_arr != null) : ?>
            <hr>
            <div id="member_table" class="row">
                <form id="dataForm" class="col-12 form-horizontal" action="" method="POST">
                    <table id="member_table" class="table table-striped">
                        <thead class="thead-light">
                            <tr class="text-center/">
                                <th scope="col" class="px-2"> Completion Date </th>
                                <th scope="col" class="px-2">Task Completion</th>
                            </tr>
                        </thead>
                        <tbody class="member_body">

                            <?php $processed        = true ?>
                            <?php $trgtprcsd        = true ?>
                            <?php $new_procsd       = true ?>
                            <?php $cnt              = 0 ?>
                            <?php foreach ($practice_tasks as $key => $val) : ?>
                                <?php $cnt++ ?>
                                <?php $activity_task = get_activity_tasks_by_practice_task ($user_id, $val['practice_task_id']) ?>
                                <tr id="member_row<?= $cnt ?>">
                                    <th scope="row">
                                        <div class="col-12">
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fas fa-calendar-day"></i> </span>
                                                <?php $date_days = range(1, 31, 1) ?>
                                                <input type="date" id="<?= $key ?>" name="activity<?= $key ?>" value="<?= (($processed && !empty($activity_task['activity_task_date'])) ? date('Y-m-d', strtotime($activity_task['activity_task_date'])) : '') ?>" class="form-control form-sm shadow-none" placeholder="Date" <?= (($processed && !empty($activity_task['activity_task_date'])) ? '' : ((!$new_procsd) ? 'disabled' : '')) ?>>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="check<?= $key ?>" value="<?= $val['practice_task_id'] ?>" class="form-check-input" id="check<?= $key ?>" <?= (($processed && !empty($activity_task['activity_task_date'])) ? 'checked disabled' : ((!$new_procsd) ? '' : '')) ?>>
                                            <label class="form-check-label" for="check<?= $key ?>">
                                                <?= $val['practice_task_name'] ?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <?php $new_procsd   = (empty($last_task)) ? false : true ?>
                                <?php $processed    = (!$trgtprcsd || empty($last_task)) ? false : true ?>
                                <?php $trgtprcsd    = ( $processed == false || empty($last_task)) ? false : true ?>

                            <?php endforeach; ?>

                        </tbody>
                    </table>

                    <input type="hidden" name="form_type" value="member_update">
                    <input type="hidden" name="member" value="<?= $user_id ?>">
                    <input type="hidden" name="practice" value="<?= $practice_id ?>">

                    <div id="data_err" class="col-12" style="padding: 9px 0px;"></div>
                    <button class="btn btn-dark btn-sm" type="button" style="border-radius: 12px; font-weight: bolder;" onclick="postCheck('data_err', $('#dataForm').serialize(), 0, true);" <?= ((!$is_admin) ? 'disabled' : '') ?>> Submit Changes </button>
                    <button class="btn btn-danger btn-sm float-end" type="button" style="border-radius: 12px; font-weight: bolder;" onclick="postCheck('data_err', {'form_type':'remove_association', 'user':'<?= $usr_arr['client_association_id'] ?>', 0});" <?= ((!$is_admin) ? 'disabled' : '') ?>> Remove </button>

                </form>
            </div>
        <?php endif; ?>

    </div>

</div>
<div class="col-12" id="error_pop"></div>
<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>