<?php $cnt++ ?>
<?php $client_assc_id = (isset($association['client_association_id'])) ? $association['client_association_id'] : '' ?>
<?php $member_state = get_activity_tasks_by_client_association_id($client_assc_id) ?>
<?php $practice_area = get_practice_area_by_id($association['practice_area_id']) ?>
<tr>
    <th class="text-center d-none d-lg-block" scope="row"> <?= $association['association_reference'] ?> </th>
    <td> <a href="view?usr=<?= $client_assc_id ?>"> <span> <?= $association['association_name']; ?> </span> </a> </td>
    <td> <a href="view?usr=<?= $client_assc_id ?>"> <span> <?= (isset($practice_area['practice_area'])) ? $practice_area['practice_area'] : '' ?> </span> </a> </td>
    <td class="d-none d-lg-block"> <?= (isset($member_state['practice_task']) && !empty($member_state['practice_task']))? short_paragrapth($member_state['practice_task'], 20) : ''; ?> </td>
    <td class=""> <?= (isset($member_state['activity_task_updated']) && !empty($member_state['activity_task_updated'])) ? date("d/m/Y", strtotime($member_state['activity_task_updated'])) : ''; ?> </td>
    <td class="d-none d-lg-block"> <?= (isset($member_state['activity_task_date']) && !empty($member_state['activity_task_date'])) ? date("d/m/Y", strtotime($member_state['activity_task_date'])) : ''; ?> </td>
    <td class="d-block/ d-md-none/">
        <div class="float-end">
            <a href="assign?usr=<?= $client_assc_id ?>&usr_type=member&tab=member" class="me-3"> <i class="fas fa-clipboard-list me-1"></i> <span class="d-none/ d-md-block/">Assign</span> </a>
            <a class="" type="button" onclick="requestModal(post_modal[11], post_modal[11], {'member':<?= $client_assc_id ?>})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa-solid fa-pen-to-square me-1"></i> <span class="d-none/ d-md-block/">Edit</span> </a>
        </div>
    </td>
</tr>
