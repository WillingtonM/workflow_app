<div class="bg-white/ shadow/" style="padding: 17px 5px; border-radius: 25px;">
    <h5 class="col-12 article_active p-3 mb-3">
        <span class="">
            Assign <strong class="text-warning">Applicant / Executor</strong> to <strong class="text-warning">Member</strong>
        </span>
    </h5>

    <?php if ($user_type == 'member') : ?>
        <div class="row">
            <div class="col-md-6">

                <div class="shadow-sm p-3 mb-5 bg-white border-radius-lg">
                    <small class="px-2 text-danger">  </small>
                    <h6 class="text-center px-2 font-weight-bolder"> <?= (($user_type == 'client') ? $user['username'] : $user['association_name']) ?> </h6>
                    <hr class="horizontal dark mt-1 mb-3">
                    <small class="px-2 text-danger"> Assigned Applicants / Executors </small>
                    <?php if (is_array($clients) || is_object($clients)) : ?>
                        <table class="table table-striped table-sm">
                            <tbody>
                                <?php foreach ($clients as $key => $client) : ?>
                                    <tr id="memb_row_<?= $key ?>">
                                        <th scope="row" class="pt-2">
                                            <a type="button" class="me-3 px-2 pt-0" onclick="requestModal(post_modal[10], post_modal[10], {'user_id':<?= $client['user_id'] ?>, 'user_type':'guest'})"> <span> <?= ((!empty($client['name'])) ? $client['name'] . ' | ' : '') ?> <?= $client['username'] ?> </span> </a> 
                                        </th>
                                        <td class="pb-0">
                                            <button class="btn btn-secondary py-2 float-end me-2 cursor-pointer font-weight-bolder border-radius-lg text-white px-3" type="button" onclick="postCheck('memb_row_<?= $key ?>', {'user':<?= $client['user_id'] ?>, 'member':<?= $user_id ?>, 'form_type':'remove_member' } )" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> 
                                                <i class="fa-solid fa-trash me-1"></i> Unlink 
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h6 class="text-danger"> There is no data to display </h6>
                    <?php endif; ?>
                </div>

            </div>

            <div class="col-md-6">

                <div class="shadow-sm p-3 mb-5 bg-white rounded" style="background-color: #fff; border-radius: 15px !important;">

                    <form action="?usr=<?= $user_id ?>&usr_type=<?= $user_type ?>>" method="GET">
                        <div id="searchDiv" class="input-group mb-1 <?= (isset($data['success']) && $data['success'] == true) ? 'has-validation' : '' ?>">
                            <div class="form-floating form-floating-group flex-grow-1">
                                <input id="searchInp" class="form-control shadow-none" type="search" name="name" value="<?= (isset($search) && !empty($search)) ? $search : '' ?>" style="border-radius: 12px 0 0 12px" placeholder="Search ..." aria-label="Search  Client/Applicant..." aria-describedby="basic-addon2">
                                <label for="searchInp">Search  Client/Applicant...</label>
                            </div>
                            <button class="input-group-text gul border-end" type="submit" style="border-radius: 0 12px 12px 0 !important;"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                            <section id="loginPasswordFeedback" class="valid-feedback px-3">
                                Invalid search
                            </section>
                            <input type="hidden" class="invalid_text" value="Invalid password">
                        </div>

                        <input id="search_token" type="hidden" name="token" value="<?= get_token(); ?>">
                        <input id="search_usr" type="hidden" name="usr" value="<?= $user_id ?>">
                        <input id="usr_type" type="hidden" name="usr_type" value="<?= $user_type ?>">
                        <input id="tab" type="hidden" name="tab" value="<?= $crrnt_tab ?>">
                    </form>

                    <h6 class="px-3"> <small class="text-warning"> Client/Applicant search results </small> </h6>
                    <div id="search_err" style="padding-top: 15px;"></div>
                    <?php if (is_array($req_res) || is_object($req_res)) : ?>
                        <?php foreach ($req_res as $key => $result) : ?>
                            <?php $user_check = get_client_association_by_user_id($result['user_id'], $user['client_association_id'], false) ?>
                            <?php $user_check = (($user_check && $user_check['client_association_status'] == 1) ? true : false) ?>
                            <div class="row px-3">
                                <div class="col-12 px-2 pb-0 border-bottom mb-0 pt-1">
                                    <a type="button" class="me-3 pt-2" onclick="requestModal(post_modal[10], post_modal[10], {'user_id':<?= $result['user_id'] ?>, 'user_type':'guest'})"> <span> <?= ((!empty($result['name'])) ? $result['name'] . ' | ' : '') ?> <?= $result['username'] ?> </span> </a> 
                                    <button type="button" class="btn btn-light px-3 text-warning float-end" onclick="<?php if($practice_count <= 1): ?> 
                                        postCheck('client_search_message', {'form_type':'search_assign', 'user_type':'client', 'member':<?= $user_id ?>, 'user':<?= $result['user_id'] ?>, 'practice_area':<?= $practice_area_id?>}) <?php else: ?> 
                                        requestModal(post_modal[26], post_modal[26], {'user_type':'client', 'member':<?= $user_id ?>, 'user':<?= $result['user_id'] ?>})
                                        <?php endif; ?>" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?> <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> 
                                        <i class="fas fa-puzzle-piece me-1"></i> <span>Assign</span> 
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-danger text-sm mx-2"> There are no search results to display... </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <h5 class="bg-light p-3 border-radius-lg" style="font-weight: normal;">
            <a href="./clients" class="text-info/ alt_dflt">    
                Select or search a Client Association ... 
            </a>
        </h5>
    <?php endif; ?>

</div>