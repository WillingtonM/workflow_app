<table class="table table-striped">
    <thead class="thead-light">
        <tr class="">
            <!-- <th class="text-center" style="width:1px" scope="col">#</th> -->
            <th scope="col" class="px-2 font-weight-bolder">Practice Tasks</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($practice_tasks)): ?>
            <?php $count = 0 ?>
            <?php foreach ($practice_tasks as $key => $practice) : ?>
                <?php $count++ ?>
                <tr>
                    <!-- <th class="text-center" scope="row"> <?= $count ?> </th> -->
                    <td> <span> <?= ((!empty($practice['practice_task_name'])) ? $practice['practice_task_name'] : '') ?> </span> </td>
                    <td>
                        <a class="float-end me-3 cursor-pointer" type="button" onclick="requestModal(post_modal[24], post_modal[24], {'practice_task':<?= $practice['practice_task_id'] ?>})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa-solid fa-pen-to-square me-1"></i> Edit </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>