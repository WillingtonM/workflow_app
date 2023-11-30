<div class="p-1 px-3" style="border-radius: 25px; ">
    <h5 class="col-12 article_active p-3 mb-3">
        <span class="">
             Assign to <strong class="text-warning">Applicant / Executor</strong>
        </span>
    </h5>


    <?php if ($user_type == 'client') : ?>
        <div class="row">
            <div class="col-md-6">

                <div class="shadow-sm p-3 mb-5 bg-white border-radius-lg">
                    <small class="px-2 text-danger"> Applicant / Executor </small>
                    <h6 class="text-center px-2 font-weight-bolder"> <span> <?= ((!empty($user['name'])) ? $user['name'] . ' | ' : '') ?> <?= $user['username'] ?> </span> </h6>
                    <hr class="horizontal dark mt-1 mb-3">
                    <small class="px-2 text-danger"> Assigned ... </small>

                    <?php if (is_array($clients) || is_object($clients)) : ?>
                        <table class="table table-striped table-sm">
                            <tbody>
                                <?php foreach ($clients as $key => $client) : ?>
                                    <?php $client_assc_id = (isset($client['client_association_id'])) ? $client['client_association_id'] : '' ?>
                                    <tr id="clnt_row_<?= $key ?>">
                                        <th scope="row" class="pt-2">
                                            <a class="py-3" href="./view?usr=<?= $client_assc_id ?>&usr_type=member">
                                                <span class="text-secondary ms-2 py-3"> <?= ((!empty($client['name'])) ? $client['name'] . ' | ' : '') ?> <?= $client['association_name'] ?> </span>
                                            </a>
                                        </th>
                                        <td class="pt-2"> <small style="font-size: .7rem;"><?= short_paragrapth($client['practice_area'], 15) . '...' ?></small> </td>
                                        <td class="py-0 pt-1">
                                            <a class="btn btn-light float-end me-2 cursor-pointer font-weight-bold border-radius-lg px-3" href="./view?usr=<?= $client_assc_id ?>&usr_type=member">
                                                <span class="text-dark"> <i class="fa-solid fa-eye me-1"></i> View </span>
                                            </a>
                                            <button class="btn btn-secondary float-end me-2 cursor-pointer text-white px-3 font-weight-bold border-radius-lg" type="button" onclick="postCheck('clnt_row_<?= $key ?>', {'member':<?= $client_assc_id ?>, 'user':<?= $user_id ?>, 'form_type':'remove_member' } )" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> 
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

                    <form action="" method="GET">
                        <div id="searchDiv" class="input-group mb-1 <?= (isset($data['success']) && $data['success'] == true) ? 'has-validation' : '' ?>">
                            <div class="form-floating form-floating-group flex-grow-1">
                                <input id="searchInp" class="form-control shadow-none" type="search" name="name" value="<?= (isset($search) && !empty($search)) ? $search : '' ?>" style="border-radius: 12px 0 0 12px" placeholder="Search ..." aria-label="Search ..." aria-describedby="basic-addon2">
                                <label for="searchInp">Search...</label>
                            </div>
                            <button class="input-group-text gul border-end" type="submit" style="border-radius: 0 12px 12px 0 !important;"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                            <section id="loginPasswordFeedback" class="valid-feedback px-3">
                                Invalid search
                            </section>
                            <input type="hidden" class="invalid_text" value="Invalid password">
                        </div>

                        <input type="hidden" name="token" value="<?= get_token(); ?>">
                        <input type="hidden" name="usr" value="<?= $user_id ?>">
                        <input type="hidden" name="usr_type" value="<?= $user_type ?>">
                        <input type="hidden" name="tab" value="<?= $crrnt_tab ?>">
                    </form>

                    <h6 class="px-3"> <small class="text-warning"> Search results </small> </h6>
                    <div id="client_search_message"></div>
                    <?php if (is_array($req_res) || is_object($req_res)) : ?>
                            <?php foreach ($req_res as $key => $result) : ?>
                                <?php $client_assc_id   = (isset($result['client_association_id'])) ? $result['client_association_id'] : '' ?>
                                <?php $user_check       = get_client_association_by_user_id($user['user_id'], $client_assc_id, false) ?>
                                <?php $user_check       = (($user_check && $user_check['client_association_status'] == 1) ? true : false) ?>
                                <div class="row px-3 py-0">
                                    <div class="col-12 px-2 pb-0 border-bottom mb-0 pt-1">
                                        <a class="me-3 pt-2" href="view?usr=<?= $client_assc_id ?>&usr_type=member"> <span class="pt-5"> <?= $result['association_name'] ?> </span> </a> 
                                        <button class="btn btn-light px-3 text-warning float-end" onclick="<?php if($practice_count <= 1): ?> 
                                            postCheck('client_search_message', {'form_type':'search_assign', 'user_type':'member', 'member':<?= $client_assc_id ?>, 'user':<?= $user_id ?>, 'practice_area':<?= $practice_area_id?>}) <?php else: ?> 
                                            requestModal(post_modal[26], post_modal[26], {'user_type':'member', 'member':<?= $client_assc_id ?>, 'user':<?= $user_id ?>})
                                            <?php endif; ?>" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?> <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?> <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fas fa-puzzle-piece me-1"></i> 
                                            <span>Assign</span> 
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-danger text-sm px-3"> There are no search results to display... </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <h5 class="bg-light p-3 border-radius-lg" style="font-weight: normal;">
            <a href="./clients" class="text-info/ alt_dflt"> 
                Select or search Applicants | Executors from here ...
            </a>
        </h5>
    <?php endif; ?>

</div>