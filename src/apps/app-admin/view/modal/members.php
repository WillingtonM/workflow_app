<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
<div class="container-fluid/ row">

    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <?php $image = (($usr_arr != null) ? img_path(ABS_USER_PROFILE, $usr_arr['user_image'], 1) : '') ?>
            <img src="<?= $image ?>" width="90" class="border-radius-lg" alt="...">
        </div>
        <div class="flex-grow-1 ms-3">
            <h5 class=""> 
                <?= $usr_arr['name'] . ' ' . $usr_arr['last_name'] ?> <br>
                <span class="alt_dflt text-sm"> <small>(<?= $usr_arr['user_type'] ?>)</small> </span>
            </h5>

            <ul class="list-inline">
                <li class="list-inline-item">
                    <small>
                        <i class="fa-solid fa-list-check"></i> Total tasks : <span class="badge bg-primary"><?= (!empty($users_tasks)) ? count($users_tasks) : 0 ?></span>
                    </small>
                    <!-- <small class="font-weight-bolder">Category:</small> <span class="badge bg-primary"> <?= $category['category'] ?> </span> -->
                </li>
                <li class="list-inline-item">
                     <small>
                        <i class="fa-regular fa-clock"></i> Completion rate : <span class="badge bg-success"><?= (!empty($users_tasks)) ? ($completed_tasks / count($users_tasks)) * 100 : 0 ?> % </span>
                    </small>
                </li>
                <li class="list-inline-item">

                </li>
            </ul>

        </div>
    </div>

    <hr class="horizontal dark mt-1 mb-3">

    <label for="" class="text-dark fs-6 px-4 font-weight-light">User activity history</label> <br>

    <div class="col-12" id="form_member">
        <div class="accordion bg-light py-4" id="accordionExample" style="border-radius: 25px">
            <?php if (is_array($users_tasks) || is_object($users_tasks)) : ?>
                <?php $count = 0 ?>
                <?php foreach ($users_tasks as $key => $task) : ?>
                    <?php $count ++ ?>
                    <?php $task_id      = $task['task_id'] ?>
                    <?php $task_history = get_user_task_history($user_id, $task_id) ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header bg-light border border-white" id="heading<?= $count ?>">
                            <button class="accordion-button text-dark font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $count ?>" aria-expanded="<?= ($count == 1) ? 'true' : 'false' ?>" aria-controls="collapse<?= $count ?>">
                                <i class="fa-solid fa-caret-right me-3"></i> <?= $task['task_name'] ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $count ?>" class="accordion-collapse collapse <?= ($count == 1) ? 'show' : '' ?>" aria-labelledby="heading<?= $count ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-0">

                                <div class="bg-white">
                                    <table class="table table-striped/ table-sm">
                                        <thead class="thead-light">
                                            <tr class="">
                                                <th class="text-center" style="width:1px" scope="col">#</th>
                                                <th scope="col" class="px-1" style="width:1px">Activity</th>
                                                <th scope="col" class="px-1">Comment</th>
                                                <th scope="col" class="px-1">Date</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-secondary">
                                            <?php if(is_array($task_history) || is_object($task_history)): ?>
                                                <?php $h_count = 0 ?>
                                                <?php foreach ($task_history as $key => $history): ?>
                                                    <?php $h_count ++ ?>
                                                    <?php $task_date    = date("Y-m-d H:i:s", strtotime($history['history_date_created'])) ?>
                                                    <?php $user         = get_user_by_id($history['user_id']) ?>

                                                    <?php $image        = (($user != null) ? img_path(ABS_USER_PROFILE, $user['user_image'], 1) : '') ?>

                                                    <tr>
                                                        <th class="text-center" scope="row"> <?= $h_count ?> </th>
                                                        <td> <span> <?= ((!empty($history['activity_type'])) ? ucfirst($history['activity_type']) : '') ?> </span> </td>
                                                        <td> <span> <?= ((!empty($history['details'])) ? ucfirst($history['details ']) : '') ?> </span> </td>
                                                        <td> <span class=""> <?= date("d M Y", strtotime($task_date)) ?> </span> </td>
                                                        <td>
                                                            <!-- <a class="float-end font-weight-bolder me-3 btn btn-xs btn-dark px-3 py-2 border-radius-lg" type="button" onclick="requestModal(post_modal[21], post_modal[21], {'task_id':<?= $task['task_id'] ?>})" <?= ((!$is_admin) ? 'disabled' : '') ?>> view </a> -->
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        

    </div>

</div>
<div class="col-12" id="error_pop"></div>
<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>
