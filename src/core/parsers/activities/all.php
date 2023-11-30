<div class="row shadow-sm p-3 mb-5 bg-white rounded" style="border-radius: 15px !important;">

    <?php
    $intval             = 100;
    $article_type       = 'guest';
    $page_nmb           = (int) (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;

    $company_id         = get_company_id();
    $subscription       = company_subscription();

    if (HOST_IS_LIVE) {
        $cnt_sql        = "SELECT * FROM notifications WHERE notification_status = 1 AND company_id = ?";
        $cnt_dta        = [$company_id];
        $artcl_count    = (int) prep_exec($cnt_sql, $cnt_dta, $sql_request_data[3]);
    }
    
    $page_count         = ceil(($artcl_count / $intval));
    $sql_pg_strt        = (int)($page_nmb - 1) * $intval;
    
    if (HOST_IS_LIVE) {
        $rgst_sql       = "SELECT * FROM notifications WHERE notification_status = 1 AND company_id = ? ORDER BY notification_created_date DESC LIMIT $sql_pg_strt, $intval";
        $rgst_dta       = [$company_id];
        $nwsf_qry       = prep_exec($rgst_sql, $rgst_dta, $sql_request_data[1]);
    }

    ?>

    <div class="col-12"><br></div>
    <div class="col-12 p-0">

        <table class="table table-striped">
            <thead class="thead-light text-sm">
                <tr class="">
                    <th scope="col" class="px-2">User Name</th>
                    <th scope="col" class="px-2">Activity</th>
                    <th scope="col" class="px-2">Activity Value</th>
                    <th scope="col" class="px-2 d-none d-lg-block">Date</th>
                    <th scope="col" class="px-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($nwsf_qry) || is_object($nwsf_qry)) : ?>
                    <?php $cnt = 0 ?>
                    <?php foreach ($nwsf_qry as $key => $association) : ?>
                        <?php $cnt++ ?>
                        <?php $notif_msg = '' ?>
                        <?php $database = $association['notification_database'] ?>
                        <?php $dtbs_id  = $association['notification_database_id'] ?>
                        <?php $dtbs_ind = str_replace(' ', '', $association['notification_message_index']) ?>
                        <?php $dtbs_msg = (string) $association['notification_message'] ?>
                        <?php $db_stmt  = substr_replace($database, "", -1) . '_id = ' . $dtbs_id ?>

                        
                        
                        <?php if (!in_array($database, $allowed_db)) continue; ?>
                        
                        <?php $db_query = "SELECT * FROM $database WHERE $db_stmt LIMIT 1" ?>
                        <?php $rgst_dta = [] ?>
                        <?php $db_qry   = prep_exec($db_query, $rgst_dta, $sql_request_data[0]); ?>

                        <?php $user     = get_user_by_id($association['user_id']) ?>

                        <tr>
                            <td> <span> <?= ((!empty($user['name'])) ? $user['name'] : '') ?> </span> </td>
                            <?php if ($database == 'associations') : ?>
                                <?php $dtbs_msg_type    = (($dtbs_msg == '1' || $dtbs_msg == '0') ? 'updt_' . (string) $dtbs_msg : $dtbs_msg); ?>
                                <?php $activity         = $notifications_arr[$database][$dtbs_msg_type] ?>
                                <?php $notif_msg        = $activity['sts'] . ': ' . $activity['msg']  ?>
                                <td> <?= $activity['sts'] ?> </td>
                                <td> <?= short_paragrapth($activity['msg'], 45) ?> </td>
                            <?php elseif ($database == 'client_associations') : ?>
                                <?php $dtbs_msg_type    = (($dtbs_msg == 'insert') ? 'insert' : (($dtbs_ind  == 'update') ? 'update' : '')) ?>
                                <?php if (!empty($dtbs_msg_type)) : ?>
                                    <?php $activity     = $notifications_arr[$database][$dtbs_msg_type]['msg'] ?>

                                <?php elseif ($dtbs_msg == 'remove') : ?>
                                    <?php $activity     = $notifications_arr[$database][$dtbs_msg]['msg'] ?>
                                <?php else : ?>
                                    <?php $activity     = (isset($client_task_associations_msgs[$dtbs_ind])) ? $client_task_associations_msgs[$dtbs_ind]['notc'] : '' ?>
                                <?php endif; ?>
                                <?php $notif_msg        = (!empty($dtbs_msg_type) ? $dtbs_msg_type : ((!empty($activity)) ? 'update' : '')) . ': ' . $activity  ?>

                                <td> <?= (!empty($dtbs_msg_type) ? $dtbs_msg_type : ((!empty($activity)) ? 'update' : '')) ?> </td>
                                <td> <?= short_paragrapth($activity, 20) ?> </td>
                            <?php else : ?>
                                <td></td>
                                <td></td>
                            <?php endif; ?>

                            <td style="white-space: nowrap; width: 1" class="d-none d-lg-block">
                                <small> <?= ((!empty($association['notification_created_date'])) ? date("Y/m/d", strtotime($association['notification_created_date'])) : '') ?> </small>
                            </td> 
                            <td style="white-space: nowrap; width: 1">
                                <a class="me-3 float-end" type="button" onclick="requestModal(post_modal[15], post_modal[15], {'usr':<?= $association['notification_id'] ?>, 'msg':'<?= $notif_msg ?>' })" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa-solid fa-eye me-1"></i> View </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </tbody>
        </table>

    </div>

    <br><br>
</div>