<div class="row shadow-sm px-0 mb-3 bg-white rounded" style="border-radius: 15px !important;">

    <?php
    $intval             = 60;
    $db_dta             = [];
    $username           = (isset($_GET['usr'])) ? $_GET['usr'] : '';
    $user               = get_user_by_username($username);
    $usr_id             = ($user) ? $user['user_id'] : '';

    $company_id         = get_company_id();
    $subscription       = company_subscription();

    $article_type       = 'guest';
    $page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;

    if (HOST_IS_LIVE) {
        $cnt_sql        = "SELECT * FROM notifications WHERE user_id = ?  AND notification_status = 1 AND company_id = ?";
        $cnt_dta        = [$usr_id, $company_id];
        $artcl_count    = (int) prep_exec($cnt_sql, $cnt_dta, $sql_request_data[3]);
    }

    $page_count         = ceil(($artcl_count / $intval));
    $sql_pg_strt        = (int)($page_nmb - 1) * $intval;

    if (HOST_IS_LIVE) {
        $rgst_sql       = "SELECT * FROM notifications WHERE user_id = ? AND notification_status = 1 AND company_id = ? ORDER BY notification_created_date DESC LIMIT $sql_pg_strt, $intval";
        $rgst_dta       = [$usr_id, $company_id];
        $nwsf_qry       = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1]);
    }

    ?>

    <?php foreach ($nwsf_qry as $key => $association) : ?>
        <?php $cnt++ ?>
        <?php $notif_msg    = '' ?>
        <?php $database     = $association['notification_database'] ?>
        <?php $dtbs_id      = $association['notification_database_id'] ?>
        <?php $dtbs_ind     = str_replace(' ', '', $association['notification_message_index']) ?>
        <?php $dtbs_msg     = (string) $association['notification_message'] ?>
        <?php $db_stmt      = substr_replace($database, "", -1) . '_id = ' . $dtbs_id ?>
        
        <?php if (!in_array($database, $allowed_db)) continue; ?>
        
        <?php $db_query     = "SELECT * FROM $database WHERE $db_stmt LIMIT 1" ?>
        <?php $rgst_dta     = [] ?>
        <?php $db_qry       = prep_exec($db_query, $rgst_dta, $sql_request_data[0]); ?>

        <?php $user         = get_user_by_id($association['user_id']) ?>


    <?php endforeach; ?>
                            

    <?php if ($user) : ?>
        <div class="col-12 p-4">
            <h5 class="text-secondary"> <?= $user['name'] . ' ' . $user['last_name'] . '\'s' ?> <small> <i>(<?= $user['username'] ?>)</i> </small> Activities</h5>
        </div>
        <div class="col-12 p-0 mb-3">
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr class="">
                        <th scope="col" class="px-3">Activity</th>
                        <th scope="col" class="px-3">Activity Value</th>
                        <th scope="col" class="px-3 d-none d-lg-block">Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($nwsf_qry) || is_object($nwsf_qry)) : ?>
                        <?php $cnt = 0 ?>
                        <?php foreach ($nwsf_qry as $key => $association) : ?>
                            <?php $cnt++ ?>
                            <?php $notif_msg    = '' ?>
                            <?php $database     = $association['notification_database'] ?>
                            <?php $dtbs_id      = $association['notification_database_id'] ?>
                            <?php $dtbs_ind     = str_replace(' ', '', $association['notification_message_index']) ?>
                            <?php $dtbs_msg     = (string) $association['notification_message'] ?>
                            <?php $db_stmt      = substr_replace($database, "", -1) . '_id = ' . $dtbs_id ?>

                            <?php if (!in_array($database, $allowed_db)) continue; ?>

                            <?php $db_query     = "SELECT * FROM $database WHERE $db_stmt LIMIT 1" ?>
                            <?php $db_qry       = prep_exec($db_query, $rgst_dta, $sql_request_data[0]); ?>

                            <?php $user         = get_user_by_id($association['user_id']) ?>

                            <tr>
                                <?php if ($database == 'associations') : ?>
                                    <?php $dtbs_msg_type    = (($dtbs_msg == '1' || $dtbs_msg == '0') ? 'updt_' . (string) $dtbs_msg : $dtbs_msg); ?>
                                    <?php $activity         = $notifications_arr[$database][$dtbs_msg_type] ?>
                                    <?php $notif_msg        = $activity['sts'] . ': ' . $activity['msg']  ?>
                                    <td class="px-3"> <?= $activity['sts'] ?> </td>
                                    <td class="px-3"> <?= short_paragrapth($activity['msg'], 35) ?> </td>
                                <?php elseif ($database == 'client_associations') : ?>
                                    <?php $dtbs_msg_type    = (($dtbs_msg == 'insert') ? 'insert' : (($dtbs_ind  == 'update') ? 'update' : '')) ?>
                                    <?php if (!empty($dtbs_msg_type)) : ?>
                                        <?php $activity     = $notifications_arr[$database][$dtbs_msg_type]['msg'] ?>

                                    <?php else : ?>
                                        <?php $activity     = (isset($client_task_associations_msgs[$dtbs_ind])) ? $client_task_associations_msgs[$dtbs_ind]['notc'] : '' ?>
                                    <?php endif; ?>
                                    <?php $notif_msg        = (!empty($dtbs_msg_type) ? $dtbs_msg_type : ((!empty($activity)) ? 'update' : '')) . ': ' . $activity  ?>

                                    <td class="px-3"> <?= (!empty($dtbs_msg_type) ? $dtbs_msg_type : ((!empty($activity)) ? 'update' : '')) ?> </td>
                                    <td class="px-3"> <?= short_paragrapth($activity, 35) ?> </td>
                                <?php else : ?>
                                    <td></td>
                                    <td></td>
                                <?php endif; ?>

                                <td class="d-none d-lg-block px-3"> <small> <?= ((!empty($association['notification_created_date'])) ? date("Y/m/d", strtotime($association['notification_created_date'])) : '') ?> </small> </td>
                                <td class="px-3">
                                    <a class="float-end me-3 cursor-pointer" type="button" onclick="requestModal(post_modal[15], post_modal[15], {'usr':<?= $association['notification_id'] ?>, 'msg':'<?= $notif_msg ?>' })" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa-solid fa-eye me-1"></i> View </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </tbody>
            </table>

        </div>
        <br><br>
    <?php else : ?>
        <div class="col-12 p-4 text-center mt-3">
            <h6 class="text-danger"> No user is selected </h6>
        </div>
    <?php endif; ?>


</div>