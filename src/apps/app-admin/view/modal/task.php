<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div id="contactModal" class="row">

    <div id="bookingForm" class="col-12/" style="padding-top: 0; margin-top: 0;">
        <div class="rounded-0/">
            <div class="col-12">
                <div class="text-center py-2">
                    <h3 class="text_default" style="font-weight: bolder;">
                        <?= (isset($task['task_name'])) ? $task['task_name'] : '' ?>
                    </h3>
                    <small class="m-0 alt2_color">
                        View this tasks information
                    </small>
                </div>
            </div>

            <hr class="horizontal dark my-1">

            <div class="col-12">
                <a href="task?task_id=<?= $task['task_id'] ?>" class="btn btn-secondary px-3 border-radius-lg me-1"> <i class="fa-solid fa-pen-to-square me-1"></i> Edit Task </a>
                <a class="font-weight-bolder me-3 btn btn-warning px-3 border-radius-lg" href="view?task=<?= $task['task_id'] ?>&type=active&tab=active" <?= ((!$is_admin) ? 'disabled' : '') ?>> <i class="fa-solid fa-clock-rotate-left me-1"></i> View task log </a>

            </div>


            <form id="category_form" class="col-12" method="POST">
                <input type="hidden" name="form_type" value="task_form">

                <div class="col-12 mb-3">
                    <label for=""> Task status </label>
                    <p class=""> 
                        <span class="me-3 badge rounded-pill bg-<?= (!$state) ? 'success' : 'warning' ?>"><?= (!$state) ? 'Active' : 'Completed' ?></span>
                        <span class="me-3 badge rounded-pill bg-<?= (!$is_due) ? 'success' : 'danger' ?>"><?= (!$is_due) ? '' : 'Task due' ?></span>
                    </p>
                </div>

                <div class="col-12 mb-3">
                    <label for=""> Task deadline </label>
                    <ul class="list-inline">
                        <li class="list-inline-item"> 
                            <span class="bg-danger badge"><?= $deadline->format('d') ?></span>
                            <?php if (date("Y") != $deadline->format('Y')): ?>
                                <spam><?= $deadline->format('M Y') ?></spam>
                            <?php else: ?>
                                <spam><?= $deadline->format('M') ?></spam>
                            <?php endif; ?>
                        </li>
                        <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?= $deadline->format('D') ?> </li>
                        <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?= ($deadline->format('h:i A') != $deadline->format('h:i A')) ? $deadline->format('h:i A') . ' - ' . $deadline->format('h:i A') : $deadline->format('h:i A') ?> </li>
                    </ul>
                    <p class=""> 
                        <small class="font-weight-bolder">Priority:</small> <span class="badge me-3 rounded-pill bg-<?= $priority_level[$task['task_priority']]['class'] ?>"> <?= ucfirst($task['task_priority']) ?> </span>
                        <small class="font-weight-bolder">Category:</small> <span class="badge bg-primary"> <?= $category['category'] ?> </span>
                    </p>

                </div>

                <div class="col-12 mb-3">
                    <label for=""> Assigned users </label>
                    <div class="input-group mb-2">

                        <?php if ($user): ?>
                            <?php $image = (($user != null) ? img_path(ABS_USER_PROFILE, $user['user_image'], 1) : '') ?>
                            <img src="<?= $image ?>" width="45" class="border-radius-lg" alt="...">
                        <?php endif ?>
                        
                    </div>
                </div>


                <div id="tittleDiv" class="col-12 mb-3">
                    <label for=""> Task information </label>
                    <div class="col mb-3 bg-light/ p-3 border-radius-lg border border-4">
                        <?=nl2br($task['task_text']) ?>
                    </div>
                </div>

            </form>

            <br>

        </div>
    </div>

</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>