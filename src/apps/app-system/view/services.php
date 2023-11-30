<div class="container">


    <div class="row">
        <div class="col-12 shadow/ border-radius-xl bg-white p-0">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6> <span>Service Routes</span>
                        <a type="button" class="btn btn-dark float-end" onclick="requestModal(post_modal[13], post_modal[13], {})" <?= ((!$is_admin) ? 'disabled' : '') ?>> Add Route</a>
                    </h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <?php if (is_array($services) || is_object($services)) : ?>
                            <?php $count = 0 ?>

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Departure</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Destination</th>
                                        <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th> -->
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Period</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fare</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services as $service) : ?>
                                        <?php $count++ ?>
                                        <tr>
                                            <td class="align-middle text-center text-sm">
                                                <span class=""><?= $count ?></span>
                                            </td>
                                            <td>
                                                <p class="text-xs/ font-weight-bolder mb-0"><?= $service['service_departure'] ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="font-weight-bolder mb-0"><?= $service['service_destination'] ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs/ font-weight-bold"><?= $service['service_week_day'] ?></span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success"><?= $service['service_departure_time'] ?></span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-danger"><?= money_currency('R', $service['service_price']) ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" onclick="requestModal(post_modal[13], post_modal[13], {'service':<?= $service['service_id'] ?>})" <?= ((!$is_admin) ? 'disabled' : '') ?>>
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