<div class="container">
    <div class="row">

        <div class="col-12">
            <div class="col">
                <form action="" method="GET">
                    <input id="search_token" type="hidden" name="token" value="<?= get_token(); ?>">

                    <div class="form-floating mb-2 has-validation">
                        <input class="form-control shadow-none" type="search" name="name" placeholder="Search ..." aria-label="Search ..." aria-describedby="basic-addon2">
                        <label for="username">Search task...</label>
                        <div id="usernameFeedback" class="invalid-feedback ps-3 mt-0">
                            Invalid Search
                        </div>
                    </div>
                </form>
            </div>

            <?php if ($req_res != null) : ?>
                <div class="row shadow-sm px-0 mb-3 bg-white rounded" style="border-radius: 15px !important;">
                    <h5 class="col-12 alt_dflt mb-3 py-3 px-4"> Search results ...</h5>
                    <?php $nwsf_qry = $req_res ?>
                    <?php require $config['PARSERS_PATH'] . 'settings' . DS . 'tasks_table.php'; ?>
                </div>
            <?php else : ?>
                <div class="row shadow-sm px-0 mb-3 bg-white rounded" style="border-radius: 15px !important;">

                    <?php
                    $intval             = 15;
                    $article_type       = 'active';
                    $company_id         = get_company_id();
                    $subscription       = company_subscription();

                    $page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;

                    if (HOST_IS_LIVE) {
                        $cnt_sql        = "SELECT * FROM tasks WHERE task_status = 1 AND company_id = ?";
                        $cnt_dta        = [$company_id];
                        $artcl_count    = (int) prep_exec($cnt_sql, $cnt_dta, $sql_request_data[3]);
                    }

                    $page_count         = ceil(($artcl_count / $intval));
                    $sql_pg_strt        = (int)($page_nmb - 1) * $intval;

                    if (HOST_IS_LIVE) {
                        $rgst_sql       = "SELECT * FROM tasks WHERE task_status = 1 AND company_id = ? ORDER BY task_date_updated DESC LIMIT $sql_pg_strt, $intval";
                        $rgst_dta       = [$company_id];
                        $nwsf_qry       = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1]);
                    }

                    require $config['PARSERS_PATH'] . 'settings' . DS . 'tasks_table.php'; 

                    ?>

                    <br><br>
                </div>
                <div class="row">
                    <!-- paggination -->
                    <?php if ($page_count > 1) : ?>
                        <div class="col-12">
                            <br><br>
                            <nav aria-label="Page navigation text-secondary">
                                <ul class="pagination float-right">
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
