<div class="container">

    <div class="row">
        <div id="bookingForm" class="media_div/ col-12 p-4 shadow bg-white" style="border-radius: 25px;">
            <div class="row">
                <div class="col-12 pt-3">
                    <div class="text-center py-2">
                        <h3 class="text_default" style="font-weight: bolder;">
                            Add Tasks
                        </h3>
                        <small class="m-0 alt2_color">
                            Manage user tasks
                        </small>
                    </div>
                </div>

                <hr class="horizontal dark my-1">

                <form id="task_form" class="col-12" method="POST">

                    <input type="hidden" name="form_type" value="task_form"> 
                    <input type="hidden" name="task_id" value="<?= $task_id ?>">

                    <div id="tittleDiv" class="input-group mb-3">
                        <span class="input-group-text"><b class="mt-3"> <i class="fas fa-clipboard-list"></i> </b> </span>
                        <div class="form-floating form-floating-group flex-grow-1">
                            <input type="text" name="task" class="special_form form-control shadow-none" id="category" value="<?= ((isset($task['task_name'])) ? $task['task_name'] : '') ?>" placeholder="Task Name" style="border-radius: 0 12px 12px 0;">
                            <label for="category">Task Name</label>
                        </div>
                        <section id="titleFeedback" class="valid-feedback">
                            Invalid Task Name
                        </section>
                        <input type="hidden" class="invalid_text" value="Invalid Task Name">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="px-2" for=""> Assign Administrators </label>
                        <div class="input-group mb-2 px-2">
                            <?php if (is_array($admins) || is_object($admins)): ?>
                                <?php foreach ($admins AS $user): ?>
                                    <?php $task_admins = (isset($task['task_admins']) && !empty($task['task_admins'])) ? json_decode($task['task_admins'], true) : NULL ?>
                                    <?php $checked = (count($admins) == 1 || (empty($task) && $user['user_id'] == $_SESSION['user_id']) || (!empty($task_admins) && in_array($user['user_id'], $task_admins) )) ? true : false ?>
                                    <div class="form-check form-check-inline px-3">
                                        <label class="form-check-label" for="inlineCheckbox<?= $user['user_id'] ?>">
                                            <input class="form-check-input" type="checkbox" name="admins[]" id="inlineCheckbox<?= $user['user_id'] ?>" value="<?= $user['user_id'] ?>" <?= ($checked) ? 'checked' : '' ?>>
                                            <img id="image_profile" class="image me-3 rounded rounded-circle" style="height: 60px;" src="<?= (($user != null) ? img_path(ABS_USER_PROFILE, $user['user_image'], 1) : '') ?>" alt="<?= ((isset($req_res) && $req_res != NULL) ? $req_res['article_title'] : '') ?>">
                                            <span><?= $user['name'] ?></span>
                                        </label>
                                    </div>
                                <?php endforeach ; ?>
                            <?php else: ?>
                                <span class="px-1 text-danger">
                                    There is no administrator
                                </span>
                            <?php endif ; ?>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="px-2" for=""> Assign user </label>
                        <div class="input-group/ mb-2 px-2">
                            <?php foreach ($users AS $user): ?>
                                <?php $checked = (count($users) == 1 || (!empty($task) && $task['assigned_to'] == $user['user_id'] )) ? true : false ?>
                                <div class="form-check form-check-inline me-3 border bg-light border-radius-lg px-3">
                                    <input class="form-check-input" type="radio" name="user" id="task_user<?= $user['user_id'] ?>" value="<?= $user['user_id'] ?>" <?= ($checked) ? 'checked' : '' ?> <?= (!empty($task)) ? 'disabled' : '' ?>>
                                    <label class="form-check-label" for="task_user<?= $user['user_id'] ?>">
                                        <img id="image_profile" class="image rounded rounded-circle" style="height: 60px;" src="<?= (($user != null) ? img_path(ABS_USER_PROFILE, $user['user_image'], 1) : '') ?>" alt="<?= ((isset($req_res) && $req_res != NULL) ? $req_res['article_title'] : '') ?>">
                                        <span><?= $user['name'] ?></span>
                                    </label>
                                </div>
                            <?php endforeach ; ?>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="px-2" for=""> Assign Task Checker </label>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="border-right: none;"><b class="mt-3"> <i class="fa-solid fa-user"></i> </b> </span>
                            <select class="form-select shadow-none" id="task_checker" name="checker" placeholder="Select task checker"">
                                <option value=""> Select task checker </option>
                                <?php foreach ($checkers AS $user): ?>
                                    <option value="<?= (isset($user['user_id'])) ? $user['user_id'] : '' ?>" <?= (isset($user['user_id']) && isset($task['assigned_to']) && $user['user_id'] == $task['assigned_to']  || (!empty($checkers) && count($checkers) == 1)) ? 'selected':'' ?>> <?= $user['name'] . ' ' . $user['last_name'] ?> </option>
                                <?php endforeach ; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="px-2" for=""> Select task category </label>
                        
                        <?php if (is_array($task_categories) || is_object($task_categories)): ?>
                        <div class="input-group mb-2">
                            <span class="input-group-text" style="border-right: none;"><b class="mt-3"> <i class="fa-solid fa-cubes-stacked"></i> </b> </span>
                            <select class="form-select shadow-none" id="category" name="category" placeholder="Select task category"">
                                <option value=""> Select task category </option>
                                <?php foreach ($task_categories AS $category): ?>
                                    <option value="<?= (isset($category['category_id'])) ? $category['category_id'] : '' ?>" <?= ((isset($category['category_id']) && isset($task['category_id']) && $category['category_id'] == $task['category_id']) || (!empty($checkers) && count($checkers) == 1) ) ? 'selected':'' ?>> <?= $category['category'] ?> </option>
                                <?php endforeach ; ?>
                            </select>
                        </div>
                        <?php else: ?>
                            <div class="px-2 mb-3">
                                <span>
                                    There are currently no task categoriies, 
                                    <a class="btn/ btn-sm/ btn-warning/ border-radius-lg px-3/" type="button" onclick="requestModal(post_modal[17], post_modal[17], {'user_type':'guest'})" <?= ((!$is_admin) ? 'disabled' : '') ?>> add task category. </a>
                                </span>
                            </div>
                        <?php endif ; ?>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth"> Due Date & Time</label>

                        <div class="row g-3 align-items-center">

                            <div class="col-auto">
                                <?php $date_days = range(1, 31, 1) ?>
                                &nbsp; <span class="me-2">Day</span>
                                <?php $d_date = ($date_check) ? date('d', strtotime($current_date . ' + 24 hours')) : date('d') ?>
                                <?php $event_day =  (isset($task['task_deadline'])) ? date('d', strtotime($task['task_deadline'])) : '' ?>
                                <select class="form-control shadow-none" name="dob">
                                    <?php foreach ($date_days as $value) : ?>
                                        <option value="<?= $value ?>" <?= ((isset($task['task_deadline']) && $event_day == $value) ? 'selected' : (($value == $d_date) ? 'selected' : '')) ?>><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-sm">
                                &nbsp; <span class="me-2">Month</span>
                                <?php $event_m =  (isset($task['task_deadline'])) ? date('F', strtotime($task['task_deadline'])) : '' ?>
                                <select class="form-control shadow-none" name="mob">
                                    <?php $m_date = ($date_check) ? date('F', strtotime($current_date . ' + 24 hours')) : date('F') ?>
                                    <?php foreach ($date_months as $key => $month) : ?>
                                        <option value="<?= $key ?>" <?= ((isset($task['task_deadline']) && $event_m == $month) ? 'selected' : (($month == $m_date) ? 'selected' : '')) ?>><?= $month ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-sm">
                                <?php $event_y =  (isset($task['task_deadline'])) ? date('Y', strtotime($task['task_deadline'])) : '' ?>
                                <?php $y_date = date("Y") ?>
                                <?php $date_days = range($y_date, date("Y", strtotime($y_date . '+ 3 years')), +1) ?>
                                <?php $oy_date = ($date_check) ? date('Y', strtotime($current_date . ' + 24 hours')) : date('Y') ?>
                                &nbsp; <span class="me-2">Year</span>
                                <select class="form-control shadow-none" name="yob">
                                    <?php foreach ($date_days as $value) : ?>
                                        <option value="<?= $value ?>" <?= ((isset($task['task_deadline']) && $event_y == $value) ? 'selected' : (($value == $oy_date) ? 'selected' : '')) ?>><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-sm">
                                &nbsp; <span class="me-2">Time</span>
                                <?php $event_t      = (isset($task['task_deadline'])) ? date('G:i A', strtotime($task['task_deadline'])) : '' ?>
                                <?php $t_date       = ($date_check) ? date('H:i', strtotime($current_date . ' + 24 hours')) : date('H:i') ?>
                                <?php $current_time = date('H:i', strtotime($current_date)); ?>
                                <?php $current_time = date('G:i A', strtotime($current_time)); ?>
                                <?php $date_days    = create_time_range("00:00", "23:00", "30 mins", "24") ?>
                                <select class="form-control shadow-none" name="tod">
                                    <?php foreach ($date_days as $value) : ?>
                                        <option value="<?= $value ?>" <?= ((isset($task['task_deadline']) && $event_t == $value) ? 'selected' : (((isset($service['service_departure_time']) && $service['service_departure_time'] == $value) || ($value == $current_time)) ? 'selected' : '')) ?>><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="form-row mb-3 px-2">
                        <div class="col-12" id="gender">
                            <label for="" class="text-secondary">Priority</label> <br>
                            <?php foreach ($priority_level AS $key => $priority): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="priority" id="<?= $key ?>" value="<?= $key ?>" <?= ((isset($task['task_priority']) && $task['task_priority'] == $key || (!isset($task['task_priority']) && $key == 'medium')) ? 'checked' : '') ?>>
                                    <label class="form-check-label" for="<?= $key ?>"><?=ucfirst($key) ?></label>
                                </div>
                            <?php endforeach ; ?>
                        </div>
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <textarea id="mytextarea" class="form-control shadow-none border-radius-none" name="" rows="8" cols="100" value="<?= (isset($task['task_text'])) ? $task['task_text'] : '' ?>" placeholder="Task Description" style="border-radius: none !important; border-radius: 0 !important;"><?= ((isset($task['task_text'])) ? htmlspecialchars($task['task_text']) : '') ?></textarea>
                        <label for="merchant_name"> </label>
                        <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                            <span>Invalid Task Description</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid Task Description">
                    </div>

                    <br>
                </form>

                <div id="msg_div" class="col-12 p-3 mb-3">
                    <!-- <div id="" class="alert/ alt_alert_warning p-3 border-radius-lg"> Hello </div> -->
                </div>

                <div class="col-12 px-3">
                    <a type="button" class="btn btn-sm btn-secondary shadow-none border-radius-lg me-2" onclick="function_tinytext_forms('task_form', 'mytextarea', 'msg_div')">Save changes</a>

                    <a href="./tasks" class="btn btn-warning shadow-none border-radius-lg me-2 btn-sm float-end"> Cancel </a>
                    <?php if (isset($task_id) && !empty($task_id)) : ?>
                    <button type="button" class="btn btn-sm btn-danger float-end shadow-none border-radius-lg me-2" onclick="postCheck('null',{'task_id': <?= $task_id ?>, 'task_remove' : true})"> Remove task </button>
                    <?php endif; ?>
                </div>
                <br>

            </div>
        </div>

    </div>
    
</div>
