<div class="container-fluid bg-white border-radius-xl" style="border-radius: 25px;">
    <div class="container min-vh-100">

        <?php if ($task_history) : ?>
            <div class="row">
                <div id="home-first" class="col-12 text-center px-3 mt-4 mb-1">
                    <h5 class="text-secondary" style="font-weight: normal;">
                        <span class="font-weight-bolder"> Task history nformation</span>
                    </h5>
                </div>
            </div>
            <hr class="horizontal dark mt-1 mb-3">

            <div class="col-12 mb-3">
                <label for=""> Task created by: </label>
                <p class="">
                    <?php $task_user         = get_user_by_id($task['user_id']) ?>
                    <?php $task_image        = (($task_user != null) ? img_path(ABS_USER_PROFILE, $task_user['user_image'], 1) : '') ?>
                    <img src="<?= $task_image ?>" width="35" class="border-radius-lg me-2 rounded rounded-circle" alt="...">
                    <span class=""> <?= $task_user['name'] . ' ' . $task_user['last_name'] ?> </span>
                </p>
            </div>
            <div class="col-12 mb-3">
                <label for=""> Summary </label>
                <p class="">
                    <small class="font-weight-bolder"># Actions:</small> <span class="badge me-3 rounded-pill bg-info"> <?= (!empty($task_history)) ? count($task_history) : 0 ?> </span>
                    <small class="font-weight-bolder">Priority:</small> <span class="badge me-3 rounded-pill bg-<?= $priority_level[$task['task_priority']]['class'] ?>"> <?= ucfirst($task['task_priority']) ?> </span>
                    <small class="font-weight-bolder">Category:</small> <span class="badge bg-primary"> <?= $category['category'] ?> </span>
                </p>
            </div>

            <div class="col-12 mt-4" style="border-radius: 35px;">
                <div class="col-row">
                    <div class="col-12 bg-white p-0 shadow/ border border-radius-lg" style="border-radius: 20px">
                        <table class="table table-striped table-sm">
                            <thead class="thead-light">
                                <tr class="">
                                    <th class="text-center" style="width:1px" scope="col">#</th>
                                    <th scope="col" class="px-1" style="width:1px">User</th>
                                    <th scope="col" class="px-1" style="width:1px">Activity</th>
                                    <th scope="col" class="px-1">Comment</th>
                                    <th scope="col" class="px-1">Date</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="text-secondary">
                                <?php $count = 0 ?>
                                <?php foreach ($task_history as $key => $history): ?>
                                    <?php $count ++ ?>
                                    <?php $task_date    = date("Y-m-d H:i:s", strtotime($history['history_date_created'])) ?>
                                    <?php $user         = get_user_by_id($history['user_id']) ?>
                                    <?php $image        = (($user != null) ? img_path(ABS_USER_PROFILE, $user['user_image'], 1) : '') ?>
                                        
                                    <tr>
                                        <th class="text-center" scope="row"> <?= $count ?> </th>
                                        <th class="text-center/" scope="row">
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?= $user['name'] . ' ' . $user['last_name'] ?>">
                                                <img src="<?= $image ?>" width="35" class="border-radius-lg rounded rounded-circle" alt="...">
                                            </span>
                                        </th>
                                        <td> <span> <?= ((!empty($history['activity_type'])) ? ucfirst($history['activity_type']) : '') ?> </span> </td>
                                        <td> <span> <?= ((!empty($history['details'])) ? ucfirst($history['details ']) : '') ?> </span> </td>
                                        <td> <span class=""> <?= date("d M Y", strtotime($task_date)) ?> </span> </td>
                                        <td>
                                            <!-- <a class="float-end font-weight-bolder me-3 btn btn-xs btn-dark px-3 py-2 border-radius-lg" type="button" onclick="requestModal(post_modal[21], post_modal[21], {'task_id':<?= $task['task_id'] ?>})" <?= ((!$is_admin) ? 'disabled' : '') ?>> view </a> -->
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
        <?php endif; ?>

    </div>
</div>