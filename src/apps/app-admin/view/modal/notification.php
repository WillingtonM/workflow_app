<!-- Modal -->
<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
    <div class="col-12 shadow p-3 mb-3 bg-white rounded text-center text-dark ps-3">
        <sapn class="font-weight-bolder"> <?= $notif_user . '\'s' ?> </sapn> Activity Details
    </div>
</div>
<div class="row">
    <div class="col-12 mb-3" id="form_member">

        <h6 class="mb-4 p-3"> <span class="font-weight-bolder">Activity date:</span>  <span class="text-danger" style="font-weight: normal;"> <?= date("d M Y", strtotime($notification['notification_created_date'])) ?> </span> </h6>

        <h5 class="font-weight-bolder px-3 text-secondary">User Activity</h5>

        <div class="mb-4 text-danger bg-light p-3 border-radius-lg">
            <span class="text-danger"></span> <?= $notif_msg ?> </span>
        </div>

        <h5 class="font-weight-bolder px-3">Activity Details</h5>
        
        <div class="bg-light p-3 border-radius-lg"> 
            <?php if ($database == 'associations') : ?>
                <?php $dtbs_msg_type    = (($dtbs_msg == '1' || $dtbs_msg == '0') ? 'updt_' . (string) $dtbs_msg : $dtbs_msg); ?>
                <?php $activity         = $notifications_arr[$database][$dtbs_msg_type] ?>
                <?php $assoc_user       = get_user_by_id($dtbs_id) ?>
                <?php $assoc_member     = get_client_association_by_id($dtbs_alt, false) ?>
                <?php $client_assoc_id  = ($assoc_member && isset($assoc_member['association_id'])) ? $assoc_member['association_id'] : '' ?>
                <?php $association_name = ($assoc_member && isset($assoc_member['association_name'])) ? $assoc_member['association_name'] : '' ?>

    
                <?php if ($dtbs_msg_type == 'insert' && $assoc_member && $assoc_user) : ?>
                    <h6> <b><?= $notif_user ?></b> has assigned: </h6>
                    <span> <a href="assign?usr=<?= $assoc_user['user_id'] ?>&usr_type=client&tab=client"> <?= $assoc_user['name'] . ' ' . $assoc_user['last_name'] ?> </a> <small> <i>(Applicatnt/Executor)</i> </small> </span> to :
                    <span> <a href="assign?usr=<?= $client_assoc_id ?>&usr_type=member&tab=member"> <?= $association_name ?> </a> <small> <i>(Client Association)</i> </small> </span>
                <?php endif; ?>
    
                <?php if ($dtbs_msg_type == 'updt_0' && $assoc_member && $assoc_user) : ?>
                    <h6> <b><?= $notif_user ?></b> has removed the association between: </h6>
                    <span> <a href="assign?usr=<?= $assoc_user['user_id'] ?>&usr_type=client&tab=client"> <?= $assoc_user['name'] . ' ' . $assoc_user['last_name'] ?> </a> <small> <i>(Applicatnt/Executor)</i> </small> </span> and :
                    <span> <a href="assign?usr=<?= $client_assoc_id ?>&usr_type=member&tab=member"> <?= $association_name ?> </a> <small> <i>(Client Association)</i> </small> </span>
                <?php endif; ?>
    
                <?php if ($dtbs_msg_type == 'updt_1' && $assoc_member && $assoc_user) : ?>
                    <h6> <b><?= $notif_user ?></b> has reassigned the association between: </h6>
                    <span> <a href="assign?usr=<?= $assoc_user['user_id'] ?>&usr_type=client&tab=client"> <?= $assoc_user['name'] . ' ' . $assoc_user['last_name'] ?> </a> <small> <i>(Applicatnt/Executor)</i> </small> </span> and :
                    <span> <a href="assign?usr=<?= $client_assoc_id ?>&usr_type=member&tab=member"> <?= $association_name ?> </a> <small> <i>(Client Association)</i> </small> </span>
                <?php endif; ?>
    
            <?php elseif ($database == 'client_associations') : ?>
                <?php $dtbs_msg_type    = (($dtbs_msg == 'insert') ? 'insert' : (($dtbs_ind  == 'update') ? 'update' : '')) ?>
                <?php $member           = get_client_association_by_id($dtbs_id, false) ?>
                <?php $client_assoc_id  = ($member && isset($member['association_id'])) ? $member['association_id'] : '' ?>
                <?php $association_name = ($member && isset($member['association_name'])) ? $member['association_name'] : '' ?>
                <?php $association_reference  = ($member && isset($member['association_reference'])) ? $member['association_reference'] : '' ?>

                <?php if (!empty($dtbs_msg_type)) : ?>
    
                    <?php $activity = $notifications_arr[$database][$dtbs_msg_type]['msg'] ?>
    
                    <?php if ($dtbs_msg_type == 'insert') : ?>
                        <h6> <b><?= $notif_user ?></b> has created a new Client Association: </h6>
                        <span> <i>Name </i>: &nbsp; <a href="view?usr=<?= $dtbs_id ?>"> <?= $association_name ?> </a> &emsp; | &emsp; <i>Ref #: </i> &nbsp; <b> <?= $association_reference ?> </b></span>
    
                    <?php endif; ?>
    
                    <?php if ($dtbs_msg_type == 'update') : ?>
                        <?php if ($dtbs_msg == 'update') : ?>
    
                        <?php else : ?>
                            <?php $arr_dta = json_decode($dtbs_msg, true) ?>
                            <?php if (is_array($arr_dta) || is_object($arr_dta)) : ?>
                                <?php $arr_new = $arr_dta['new'] ?>
                                <?php $arr_old = $arr_dta['old'] ?>
    
                                <?php if (isset($arr_new['name'])) : ?>
                                    <h6> <b><?= $notif_user ?></b> has updates Client Association Information: </h6>
                                    <span> <i>Name </i>: &nbsp; <a href="view?usr=<?= $dtbs_id ?>"> <?= $association_name ?> </a> &emsp; | &emsp; <i>Ref #: </i> &nbsp; <b> <?= $association_reference ?> </b></span>
    
                                    <div class="row">
    
                                        <div class="col-12">
                                            <br>
                                            <span class="alert alert-info"> Prior Details : </span>
                                            <table class="table table-sm table-info">&nbsp;
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Reference #</th>
                                                        <th scope="col">Name </th>
                                                        <th scope="col">Last Name</th>
                                                        <th scope="col">Surname & Initials</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row"> <?= $arr_old['reference'] ?> </th>
                                                        <td> <?= $arr_old['name'] ?> </td>
                                                        <td> <?= $arr_old['surname'] ?> </td>
                                                        <td> <?= $arr_old['surname_initials'] ?> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
    
                                        <div class="col-12">
                                            <span class="alert alert-danger"> New details (changed to) : </span>
                                            <table class="table table-sm table-danger">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Reference #</th>
                                                        <th scope="col">Name </th>
                                                        <th scope="col">Last Name</th>
                                                        <th scope="col">Surname & Initials</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row"> <?= $arr_new['reference'] ?> </th>
                                                        <td> <?= $arr_new['name'] ?> </td>
                                                        <td> <?= $arr_new['surname'] ?> </td>
                                                        <td> <?= $arr_new['surname_initials'] ?> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
    
                                <?php else : ?>
    
                                    <h6> <b><?= $notif_user ?></b> has updated "Client Association" task completion date(s): </h6>
                                    <span> <i>Name </i>: &nbsp; <a href="view?usr=<?= $dtbs_id ?>"> <?= $association_name ?> </a> &emsp; | &emsp; <i class="me-2"></i>Ref #: </i> <b> <?= $association_reference ?> </b></span>
    
                                    <div class="row">
    
                                        <div class="col-12">
                                            <br>
                                            <span class="alert alert-info"> Prior Details : </span>
    
                                            <table class="table table-sm table-info">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Activity</th>
                                                        <th scope="col">Date </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($client_task_associations as $key => $val) : ?>
                                                        <?php if (isset($arr_old[$key])) : ?>
                                                            <tr>
                                                                <th scope="row">
                                                                    <span> <?= $val ?> </span>
                                                                </th>
                                                                <td>
                                                                    <span><?= date('Y-m-d', strtotime($arr_old[$key])) ?> </span>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
    
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
    
                                        <div class="col-12">
                                            <span class="alert alert-danger"> New details (changed to) : </span>
                                            <table class="table table-sm table-danger">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Activity</th>
                                                        <th scope="col">Date </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($client_task_associations as $key => $val) : ?>
                                                        <?php if (isset($arr_new[$key])) : ?>
                                                            <tr>
                                                                <th scope="row">
                                                                    <span> <?= $val ?> </span>
                                                                </th>
                                                                <td>
                                                                    <span><?= date('Y-m-d', strtotime($arr_new[$key])) ?> </span>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
    
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>
    
                            <?php endif; ?>
    
                        <?php endif; ?>
    
                    <?php endif; ?>
    
    
                <?php elseif ($dtbs_msg == 'remove') : ?>
                    <?php $activity     = $notifications_arr[$database][$dtbs_msg]['msg'] ?>
                    <h6> <b><?= $notif_user ?></b><i> has <b> removed </b> the following "client association" </i> :</h6>
                    <span> <i>Name </i>: &nbsp; <?= $association_name ?> &emsp; | &emsp; <i class="me-2"></i>Ref #: <b> <?= $association_reference ?> </b></span>
    
                <?php else : ?>
                    <?php $activity = (isset($client_task_associations_msgs[$dtbs_ind])) ? $client_task_associations_msgs[$dtbs_ind]['notc'] : '' ?>
    
                    <h6> <b><?= $notif_user ?></b><i> has completed the following activity</i> &nbsp; <b>(<?= $activity ?>)</b>, <i>for</i>:</h6>
                    <span> <i>Name </i>: &nbsp; <a href="view?usr=<?= $dtbs_id ?>"> <?= $association_name ?> </a> &emsp; | &emsp; <i class="me-2">Ref #: </i> <b> <?= $association_reference ?> </b></span>
    
                <?php endif; ?>
    
            <?php else : ?>
    
            <?php endif; ?>

        </div>


    </div>

</div>
<div class="col-12" id="error_pop"></div>
<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>