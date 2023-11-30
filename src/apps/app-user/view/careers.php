<div class="container">

    <div class="row">
        <div class="col-12 shadow/ border-radius-xl bg-white p-0">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6> <span> Careers</span>
                        <a type="button" class="btn btn-dark float-end border-radius-lg" onclick="requestModal(post_modal[16], post_modal[16], {'type':'career'})"> Add Career</a>
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Career Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Closing Date</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($careers_data as $career) : ?>
                                        <?php $count++ ?>
                                        <tr>
                                            <td class="align-middle text-center text-sm">
                                                <span class=""><?= $count ?></span>
                                            </td>
                                            <td>
                                                <p class="text-xs/ font-weight-bolder mb-0"><?= $career['career_name'] ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="font-weight-bolder mb-0"><?= $career['career_location'] ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs/ font-weight-bold"><?= $career_types[$career['career_period_type']] ?></span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-danger"><?= date('Y-m-d', strtotime($career['career_closing_date'])) ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" onclick="requestModal(post_modal[16], post_modal[16], {'career':<?= $career['career_id'] ?>})">
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