<?php if (is_array($clients) || is_object($clients)) : ?>
    <div class="px-3 mb-0 py-0">
        <h6 class="pt-2 pb-2 mb-0 text-center text-warning border-top border-start border-end" style="border-radius: 15px 15px 0 0">Practice areas</h6>
    </div>
    <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
    <?php $tabbs_count = 0 ?>
    <?php foreach ($clients as $key => $client) : ?>
        <?php $practice     = get_practice_area_by_id($client['practice_area_id']) ?>
        <?php $tabbs_count++ ?>
        <li class="shadow nav-item font-weight-bold my-0 article_nav m-1 <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'article_active' : '') ?>">
            <a get-variable="tab" data-name="<?= $key ?>" class="nav-link <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'active' : '') ?>" id="pills-<?= $key ?>-tab" data-bs-toggle="pill" href="#pills-<?= $key ?>" role="tab" aria-controls="pills-<?= $key ?>" aria-selected="<?= (((isset($_GET['tab']) && $_GET['tab'] == $key)  || empty($_GET['tab'])) ? 'true' : 'false') ?>">
                <span class="border-weight-bolder"> <?= (isset($practice['practice_area'])) ? $practice['practice_area'] : '' ?> </span>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>

    <div class="tab-content col-12" style="padding: 25px 0;">
    <?php $array_count = 0; ?>
    <?php foreach ($clients as $key => $client) : ?>
        <?php $array_count++; ?>
        <?php $practice_tasks   = get_practice_tasks_by_practice($client['practice_area_id']) ?>
        <?php $practice         = get_practice_area_by_id($client['practice_area_id']) ?>
        <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">
            <div class="col-12 mb-4" style="border-radius: 15px; padding-top: 9px; border: 1px solid #eee">
                <table class="table table-striped table-striped">
                    <thead>
                        <tr class="table-head">
                            <th class="px-3 text-dark font-weight-bolder" scope="col"> Task </th>
                            <th class="px-3 text-dark font-weight-bolder" scope="col"> Completion Date </th>
                        </tr>
                    </thead>
                    <tbody class="text-secondary">
                    <?php if (is_array($practice_tasks) || is_object($practice_tasks)) : ?>
                    <?php foreach ($practice_tasks as $key => $prac_task) : ?>
                        <?php $task = get_activity_tasks_by_practice_task($member_id, $prac_task['practice_area_id']) ?>
                        <tr>
                            <th class="px-3" scope="row"> <?= $prac_task['practice_task_name'] ?> </th>
                            <td class="px-3"><?= ((!empty($task['consultation_date'])) ? date(PRIMARY_DATE_FORMAT, strtotime($task['consultation_date'])) : 'NA') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>
            
            <h6 class="bg-secondary text-white px-3 border-radius-xl" style="padding: 5px;"> Assigned applicants | Executors </h6>
            <table class="table table-striped table-sm">
                <tbody>
                        <tr id="memb_row_<?= $key ?>">
                            <td class="px-3">
                                <span> <?= ((!empty($client['name'])) ? $client['name'] . ' | ' : '') ?> <i> <?= $client['username'] ?> </i> </span>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>


    <?php endforeach; ?>
    </div>
        
<?php else : ?>
    <h6 class="text-danger"> There is no data to display </h6>
<?php endif; ?>

