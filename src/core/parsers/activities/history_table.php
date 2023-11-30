
    <div class="row">
        <div class="col-12 p-0">
            <?php if (is_array($task_history)) : ?>
            <table class="table table-striped table-sm">
                <thead class="thead-light">
                    <tr class="">
                        <th class="text-center" style="width:1px" scope="col">#</th>
                        <th scope="col" class="px-1 text-warning <?= (isset($user_id)) ? 'hidden' : '' ?>" style="width:1px">User</th>
                        <th scope="col" class="px-1 text-primary" style="width:1px">Task</th>
                        <th scope="col" class="px-1 text-info" style="width:1px">Activity</th>
                        <th scope="col" class="px-1 ">Comment</th>
                        <th scope="col" class="px-1">Date</th>
                    </tr>
                </thead>
                <tbody class="text-secondary">
                    <?php $count = 0 ?>
                    <?php foreach ($task_history AS $history): ?>
                        <?php $count ++ ?>
                        <?php $task_date    = date("Y-m-d H:i:s", strtotime($history['history_date_created'])) ?>
                        <?php $user         = get_user_by_id($history['user_id']) ?>
                        <?php $image        = (($user != null) ? img_path(ABS_USER_PROFILE, $user['user_image'], 1) : '') ?>
                        <tr>
                            <th class="text-center" scope="row"> <?= $count ?> </th>
                            <th class="text-center/ <?= (isset($user_id)) ? 'hidden' : '' ?>" scope="row">
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?= $user['name'] . ' ' . $user['last_name'] ?>">
                                    <img src="<?= $image ?>" width="35" class="border-radius-lg rounded rounded-circle" alt="...">
                                </span>
                            </th>
                            <td> <span> <?= (isset($history['task_name'])) ? $history['task_name'] : '' ?> </span> </td>
                            <td> <span> <?= ((!empty($history['activity_type'])) ? ucfirst($history['activity_type']) : '') ?> </span> </td>
                            <td> <span> <?= ((!empty($history['details'])) ? ucfirst($history['details ']) : '') ?> </span> </td>
                            <td> <span class=""> <?= date("d M Y", strtotime($task_date)) ?> </span> </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php endif ?>
        </div>
    </div>
