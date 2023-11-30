<div class="container">

    <div class="row">
        <div class="col-12 px-0">
            <div class="card mb-4">
                <div class="col-12 px-4 mt-3">
                    <?php if (isset($_GET['rsvp']) && $_GET['rsvp'] == 'all') : ?>
                        <a class="text-warning" href="?rsvp=min">View Minimal</a>
                    <?php else : ?>
                        <a class="text-warning" href="?rsvp=all">View All</a>
                    <?php endif; ?>
                    <h3 class="float-end " style="font-size: 2.2em;"> <button class="btn btn-warning" onclick="requestModal(post_modal[9], post_modal[9], {})" <?= ((!$is_admin) ? 'disabled' : '') ?>> Add RSVP</button> </h3>
                </div>
                <div class="card-header pb-0">
                    <h6>RSVP table (total: <strong class="text-danger"><?= (($rsvp != null) ? count($rsvp) : 0) ?></strong>)</h6>
                </div>
                <div class="col-12" id="user_messages"></div>

                <div class="card-body px-0 pt-0 pb-2 col-12">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name & Surname</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Attendance</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Date</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (is_array($rsvp) || is_object($rsvp)) : ?>
                                    
                                    <?php foreach ($rsvp as $value) : ?>
                                        <?php $attendees += (int) $value['event_guests'] ?>

                                        <tr>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"> <?= $count ?> </span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?= $value['event_user_name'] ?></p>
                                                <p class="text-xs text-secondary mb-0"><?= $value['event_last_name'] ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-<?= (($value['event_attendance'] == 'yes') ? 'success' : (($value['event_attandence'] == 'no') ? 'danger' : 'warning')) ?>"><?= $value['event_attendance'] ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"><?= date('Y/m/d', strtotime($value['event_date_created'])) ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <a type="buttton" class="cursor-pointer" onclick="requestModal(post_modal[9], post_modal[9], {'event_id': <?= ((isset($value['event_id'])) ? $value['event_id'] : '') ?>})" <?= ((!$is_admin) ? 'disabled' : '') ?>> <i class="fas fa-edit text-dark me-2"></i> View </a>
                                            </td>
                                        </tr>

                                        <?php $count++ ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 mb-3 px-4">
                        <?php if (isset($_GET['rsvp']) && $_GET['rsvp'] == 'all') : ?>
                            <a class="text-warning" href="?rsvp=min">View Minimal</a>
                        <?php else : ?>
                            <a class="text-warning" href="?rsvp=all">View All</a>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 px-4 mb-3">
                        <p> Expected number of attendees: <b class="text-danger"><?= $attendees + $count - 1 ?></b> </p>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <br><br>
</div>