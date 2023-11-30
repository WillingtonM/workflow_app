<div class="container">
    <div class="row">

        <div class="col-12">
            <button class="btn btn-sm btn-secondary border-radius-lg" type="button" onclick="requestModal(post_modal[17], post_modal[17], {'user_type':'guest'})" <?= ((!$is_admin) ? 'disabled' : '') ?>> Add Registry </button>
            <div class="col float-right">
                <form action="" method="GET">
                    <input id="search_token" type="hidden" name="token" value="<?= get_token(); ?>">

                    <div class="form-floating mb-2 has-validation">
                        <input class="form-control shadow-none" type="search" name="name" placeholder="Search ..." aria-label="Search ..." aria-describedby="basic-addon2">
                        <label for="username">Search...</label>
                        <div id="usernameFeedback" class="invalid-feedback ps-3 mt-0">
                            Invalid Search
                        </div>
                    </div>
                </form>
            </div>

            <?php if ($req_res != null) : ?>
                <div class="row shadow-sm p-3 mb-5 bg-white rounded" style="border-radius: 15px !important;">
                    <h5 class="col-12 alt_dflt mb-3"> Search results ...</h5>

                    <div class="col-12" style="padding: 0; border: 1px solid #ddd; border-radius: 0 0 15px 15px;">

                        <table class="table table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" scope="col">Date</th>
                                    <th class="px-2" scope="col">Message to: </th>
                                    <th class="px-2" scope="col">Comment</th>
                                    <th class="px-2" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $cnt = 0 ?>
                                <?php foreach ($req_res as $key => $association) : ?>
                                    <?php $cnt++ ?>
                                    <?php $usr = get_user_by_id($association['user_id']) ?>
                                    <?php $reg = get_user_by_id($association['registry_user_id']) ?>
                                    <?php $dte = DateTime::createFromFormat('Y-m-d H:i:s', $association['registry_date_created']); ?>
                                    <tr>
                                        <th class="text-center" scope="row"> <?= $dte->format('F jS, Y') ?> </th>
                                        <td> <span> <?= (isset($reg['username'])) ? $reg['username'] : ''; ?> </span> </td>
                                        <td> <span> <?= (isset($association['registry_comment'])) ? $association['registry_comment'] : ''; ?> </span> </td>
                                        <td class="">
                                            <button class="float-end me-3" type="button" onclick="requestModal(post_modal[10], post_modal[10], {'user_id':<?= $association['user_id'] ?>, 'user_type':'guest'})" <?= ((!$is_admin) ? 'disabled' : '') ?>> 
                                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit 
                                            </button>
                                            <a href="assign?usr=<?= $association['user_id'] ?>&usr_type=client&tab=client"> <span class="alt_dflt"> <i class="fas fa-clipboard-list me-1"></i> Assign </span> </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            <?php else : ?>
                <div class="row shadow-sm p-3 mb-5 bg-white rounded" style="border-radius: 15px !important;">

                    <?php
                    $intval             = 25;
                    $article_type       = '';
                    $page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;

                    if (HOST_IS_LIVE) {
                        $cnt_sql        = "SELECT * FROM registry WHERE registry_status = 1 " . $regs_sql;
                        $cnt_dta        = [];
                        $artcl_count    = (int) prep_exec($cnt_sql, $cnt_dta, $sql_request_data[3]);
                    }

                    $page_count         = ceil(($artcl_count / $intval));
                    $sql_pg_strt        = (int)($page_nmb - 1) * $intval;

                    if (HOST_IS_LIVE) {
                        $rgst_sql       = "SELECT * FROM registry WHERE  registry_status = 1 " . $regs_sql . " ORDER BY registry_date_created DESC LIMIT $sql_pg_strt, $intval";
                        $rgst_dta       = [];
                        $nwsf_qry       = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1]);
                    }
                    ?>

                    <div class="col-12"><br></div>
                    <div class="col-12" style="padding: 0; border: 1px solid #ddd; border-radius: 0 0 15px 15px;">

                        <table class="table table-striped">
                            <thead class="thead-light">
                                <tr class="">
                                    <th class="text-center" scope="col" style="width:1px">#</th>
                                    <th class="text-center" scope="col">Date</th>
                                    <?php if ($is_admin) : ?>
                                        <th class="px-2" scope="col">Message to: </th>
                                    <?php endif; ?>
                                    <th class="px-2" scope="col">Comment</th>
                                    <th class="px-2" scope="col">Status</th>
                                    <th class="px-2 float-end me-3" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (is_array($nwsf_qry) || is_object($nwsf_qry)) : ?>`
                                    <?php $cnt = 0 ?>
                                    <?php foreach ($nwsf_qry as $key => $association) : ?>
                                        <?php $cnt++ ?>
                                        <?php $usr = get_user_by_id($association['user_id']) ?>
                                        <?php $reg = get_user_by_id($association['registry_user_id']) ?>
                                        <?php $dte = DateTime::createFromFormat('Y-m-d H:i:s', $association['registry_date_created']); ?>
                                        <?php $apr = (isset($association['registry_approve']) && $association['registry_approve'] == 1) ? true : false ?>
                                        <tr>
                                            <th class="text-center" scope="row"> <?= $cnt ?> </th>
                                            <th class="text-center" scope="row"> <?= $dte->format('F jS, Y') ?> </th>
                                            <?php if ($is_admin) : ?>
                                                <td> <span> <?= (isset($reg['username'])) ? $reg['username'] : ''; ?> </span> </td>
                                            <?php endif; ?>
                                            <td> <span> <?= (isset($association['registry_comment'])) ? $association['registry_comment'] : ''; ?> </span> </td>
                                            <td>
                                                <span class="text-xxs badge rounded-pill bg-<?= ($apr) ? 'success' : 'danger' ?> rounded"> <?= ($apr) ? 'Approved' : "Not Approved" ?> </span>
                                            </td>
                                            <td class="">
                                                <?php if ($is_admin && !$apr) : ?>
                                                    <button class="float-end me-3 px-3 cursor-pointer border-radius-lg btn-secondary text-sm" type="button" onclick="requestModal(post_modal[17], post_modal[17], {'user':<?= $association['registry_user_id'] ?>, 'registry': <?= $association['registry_id'] ?>})"> 
                                                        <i class="fa-solid fa-pencil me-1"></i> Edit 
                                                    </button>
                                                <?php elseif (!$apr) : ?>
                                                    <button class="float-end me-3 px-3 cursor-pointer border-radius-lg btn-secondary text-sm" type="button" onclick="postCheck('null', {'form_type':'registry_approve', 'user':<?= $association['registry_user_id'] ?>, 'registry': <?= $association['registry_id'] ?>})" <?= ((!$is_admin) ? 'disabled' : '') ?>> 
                                                        <i class="fa-solid fa-thumbs-up me-1"></i> Approve 
                                                    </button>
                                                <?php else : ?>
                                                    <Span class="float-end me-3 text-sm"> No action </Span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                        </table>

                    </div>

                    <br><br>
                </div>
                <div class="row">
                    <!-- paggination -->
                    <?php if ($page_count > 1) : ?>
                        <div class="col-12">
                            <br><br>
                            <nav aria-label="Page navigation text-secondary text-center/">
                                <ul class="pagination text-center/ float-right">
                                    <li class="page-item">
                                        <a class="page-link text-secondary" href="?tab=<?= $article_type ?>&page=<?= (((int)$page_nmb - 1 <= 0) ? $page_nmb : $page_nmb - 1) ?>" <?= (($page_nmb - 1 <= 0) ? 'disabled' : '') ?> aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <?php for ($pg = 1; $pg <= $page_count; $pg++) : ?>
                                        <li class="page-item"><a class="page-link <?= (($pg == $page_nmb) ? 'text-danger' : 'text-secondary') ?>" href="?tab=<?= $article_type ?>&page=<?= $pg ?>"><?= $pg ?></a></li>
                                    <?php endfor; ?>
                                    <li class="page-item">
                                        <a class="page-link text-secondary" href="?tab=<?= $article_type ?>&page=<?= (($page_nmb >= $page_count) ? $page_nmb : $page_nmb + 1) ?>" <?= (($page_nmb >= $page_count) ? 'disabled' : '') ?> aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>




        </div>

    </div>
    <br><br>
</div>