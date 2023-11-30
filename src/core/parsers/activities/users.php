<div class="row shadow-sm px-0 mb-3 bg-white rounded " style="border-radius: 15px !important;">

    <?php
    $company_id         = get_company_id();
    $subscription       = company_subscription();
    $intval             = 100;
    $article_type       = 'guest';
    $page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;

    if (HOST_IS_LIVE) {
        $cnt_sql        = "SELECT * FROM users WHERE user_type != 'guest' AND user_status = 1 AND company_id = ?";
        $cnt_dta        = [$company_id];
        $artcl_count    = (int) prep_exec($cnt_sql, $cnt_dta, $sql_request_data[3]);
    }

    $page_count         = ceil(($artcl_count / $intval));
    $sql_pg_strt        = (int)($page_nmb - 1) * $intval;

    if (HOST_IS_LIVE) {
        $rgst_sql       = "SELECT * FROM users WHERE user_type != 'guest' AND user_status = 1 AND company_id = ? ORDER BY date_created DESC LIMIT $sql_pg_strt, $intval";
        $rgst_dta       = [$company_id];
        $nwsf_qry       = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1]);
    }

    ?>

    <div class="col-12 pt-4 px-3">
        <a class="btn btn-dark border-radius-lg" type="button" onclick="requestModal(post_modal[16], post_modal[16], {'graph':true})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> 
            <i class="fas fa-user-plus me-2"></i> User Graphical Activities 
        </a>
    </div>
    <div class="col-12 p-0">
        <table class="table table-striped">
            <thead class="thead-light">
                <tr class="">
                    <th scope="col" class="px-3">Name</th>
                    <th scope="col" class="px-3">Role</th>
                    <th scope="col" class="px-3"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($nwsf_qry) || is_object($nwsf_qry)) : ?>
                    <?php $cnt = 0 ?>
                    <?php foreach ($nwsf_qry as $key => $association) : ?>
                        <?php $cnt++ ?>
                        <tr>
                            <td class="px-3"> <span> <?= ((!empty($association['name'])) ? $association['name'] . '  ' : '') ?> <small> (<?= $association['username']; ?>) </small> </span> </th>
                            <td class="px-3"> <?= ((!empty($association['user_position'])) ? $association['user_position'] : '') ?> </td>
                            <td class="px-3">
                                <a class="float-end btn btn-sm btn-secondary border-radius-lg" href="?tab=user&usr=<?= $association['username'] ?>"> View Activities </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </tbody>
        </table>

    </div>

</div>