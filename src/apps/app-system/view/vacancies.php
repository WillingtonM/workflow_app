<div class="container">

    <div class="row">
        <div class="col-12 border-radius-xl bg-white p-0">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6> 
                        <span> Vacancy Applications</span>
                    </h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <?php if (is_array($careers_data) || is_object($careers_data)) : ?>
                            <?php $count = 0 ?>

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Job Title </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Name </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Contact </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Date </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($careers_data as $career) : ?>
                                        <?php $count ++ ?>
                                        <?php $career_id = $career['career_id'] ?>
                                        <?php $career_item  = get_career_by_id($career_id) ?>
                                        <tr>
                                            <td class="align-middle text-center text-sm">
                                                <span class=""><?= $count ?></span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bolder mb-0"><?= (isset($career_item['career_name'])) ? $career_item['career_name'] : '' ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="font-weight-bolder mb-0"><?= (isset($career['application_name'])) ? $career['application_name'] : '' ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs/ font-weight-bold"><?= $career['application_contact'] ?></span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-danger"><?= date('Y-m-d', strtotime($career['application_date_created'])) ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" onclick="requestModal(post_modal[16], post_modal[16], {'career':<?= $career['application_id'] ?>, 'type':'vacancy'})" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>