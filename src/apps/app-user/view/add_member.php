<div class="container-fluid/ row">

    <h5 class="col-12 p-3">
        <div class="p-3 shadow font-weight-bolder border-radius-lg bg-white">
            <?= (isset($client_name)) ? 'Client Association | <i class="text-danger"> ' . $client_name . ' </i>' : ' Add Client Association' ?>
        </div>
    </h5>
    <div id="userformErrors" class="col-md-12 p-3"></div>
    <div class="col-12" id="form_member">
        <form id="userForm" class="form-horizontal" action="" method="POST">
            <div class="row align-items-center/">

                <div class="col-12 col-lg-6">
                    <div class="form-floating mb-2 has-validation">
                        <select id="location" name="location" value="" class="form-control shadow-none border-radius-lg" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
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

                    <div class="col-auto contact_radio mb-3 p-3">
                        <label for="practice_area" class="text-secondary">Choose Practice Area to upload </label> <br>
                        <?php $count = 0 ?>
                        <?php if ( is_array($practices) || is_object($practices)) : ?>
                            <?php foreach ($practices as $key => $pract) : ?>
                                <?php $count++ ?>
                                <div class="form-check form-check-inline me-3">
                                    <input class="form-check-input me-2" type="radio" name="practice_area" id="reasonRadio<?= $count ?>" value="<?= $pract['practice_area_id'] ?>" <?= (( $count == 1 ) ? 'checked' : '') ?> <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                                    <label class="custom-control-label text-muted" for="reasonRadio<?= $count ?>"><?= $pract['practice_area'] ?></label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="name" type="text" name="name" value="<?= (($usr_arr != null) ? $name : '') ?>" class="form-control shadow-none" placeholder="Name" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                        <label for="name">Name</label>
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="name_other" type="text" name="name_other" value="<?= (($usr_arr != null) ? $name_other : '') ?>" class="form-control shadow-none" placeholder="Surname" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                        <label for="name_other">Identifying name</label>
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="reference" type="text" name="reference" value="<?= (($usr_arr != null) ? $association_reference : '') ?>" class="form-control shadow-none" placeholder="Reference Number" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                        <label for="reference">Reference Number</label>
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="identity" type="text" name="identity" value="<?= (($usr_arr != null) ? $association_identity : '') ?>" class="form-control shadow-none" placeholder="Identity Number" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                        <label for="identity">Identity Number</label>
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <textarea class="form-control shadow-none border-radius-lg" id="description" name="description" placeholder="Description." rows="4" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>><?= (($usr_arr != null) ? $association_description : '') ?></textarea>
                        <label for="description">Description</label>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="px-3 fs-5" for="username">Assign Client/Applicant</label>

                    <div id="searchDiv" class="input-group mb-1">
                        <div class="form-floating form-floating-group flex-grow-1">
                            <input id="searchInp" class="form-control shadow-none" type="search" name="search" value="" style="border-radius: 12px 0 0 12px" placeholder="Search ..." aria-label="Search  client/applicant..." aria-describedby="basic-addon2">
                            <label for="searchInp">Search  client/applicant...</label>
                        </div>
                        <button class="input-group-text gul border-end" type="submit" style="border-radius: 0 12px 12px 0 !important;"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                        <section id="loginPasswordFeedback" class="valid-feedback px-3">
                            Invalid search
                        </section>
                        <input type="hidden" class="invalid_text" value="Invalid search">
                    </div>

                    <div id="search_div" class="">
                        <div id="search_add" class="py-3 border-radius-lg mb-3"></div>
                        <div id="search_res" class="bg-white border-radius-lg"></div>
                    </div>
                </div>

            </div>
            <?php if ($usr_arr != null) : ?>
                <input type="hidden" name="post_user" value="<?= $user_id ?>">
            <?php endif; ?>
            <input type="hidden" name="form_type" value="member_add">

            <hr class="horizontal dark my-1">

            <div id="member_err" class="col-12" style="padding: 9px 0px;"></div>

            <button class="btn btn-dark col-12 text-white border-radius-lg" type="button" onclick="postCheck('member_err', $('#userForm').serialize(), 0, true);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Submit <?= (($usr_arr != null) ? 'Changes' : '') ?> </button>

        </form>

        <?php if ($usr_arr != null) : ?>
            <hr>
            <div id="member_table" class="row">
                <form id="dataForm" class="col-12 form-horizontal" action="" method="POST">
                    <?php if (is_array($practice_tasks) || is_object($practice_tasks)) : ?>
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
                    <button class="btn btn-dark btn-sm" type="button" style="border-radius: 12px; font-weight: bolder;" onclick="postCheck('data_err', $('#dataForm').serialize(), 0, true);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Submit Changes </button>
                    <button class="btn btn-danger btn-sm float-end" type="button" style="border-radius: 12px; font-weight: bolder;" onclick="postCheck('data_err', {'form_type':'remove_association', 'user':'<?= $usr_arr['client_association_id'] ?>', 0});" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Remove </button>
                    
                    <?php elseif($is_admin): ?>
                        <p class="p-3 text-danger">
                            There are curently no tasks, create tasks from <a class="font-weight-bolder" href="./admin">The Admin Page</a>
                        </p>
                    <?php endif; ?>

                </form>
            </div>
        <?php endif; ?>

    </div>

</div>
<div class="col-12" id="error_pop"></div>

<script>


    // $('#searchInp').keyup(function(e){
    //     console.log("hello");
    //     var search_val = e.target.value;
    //     var data = {'form_type': 'search_client', 'user': search_val};

    //     if (search_val.length > 1){
    //         postCheck('search_res', data, 0);
    //     }
    // });

</script>