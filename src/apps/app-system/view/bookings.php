<div class="container">
    <div class="row mb-3">
        <div class="col-12">
            <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                <?php $tabbs_count = 0 ?>
                <?php foreach ($admin_booking as $key => $nav) : ?>
                    <?php $tabbs_count++ ?>
                    <li class="shadow nav-item font-weight-bold article_nav m-1 <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'article_active' : '') ?>">
                        <a get-variable="tab" data-name="<?= $key ?>" class="nav-link <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'active' : '') ?>" id="pills-<?= $key ?>-tab" data-bs-toggle="pill" href="#pills-<?= $key ?>" role="tab" aria-controls="pills-<?= $key ?>" aria-selected="<?= (((isset($_GET['tab']) && $_GET['tab'] == $key)  || empty($_GET['tab'])) ? 'true' : 'false') ?>">
                            <span class="border-weight-bolder"> <i class="<?= $nav['imgs'] ?>"> &nbsp; </i> <?= $nav['short'] ?> </span>
                            <hr class="horizontal dark mt-1 mb-0">
                            <h6 class="text-center sm_text text-xs font-weight-bold mb-0" style="color: #777;"><?= $nav['long'] ?></h6>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="tab-content" id="notif_tab">
                <?php $array_count = 0; ?>
                <?php foreach ($admin_booking as $key => $tabs) : ?>
                    <?php $array_count++; ?>

                    <?php $bookings = (($key == 'processed') ? $processed_events : get_events(FALSE)) ?>
                    
                    <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">
                        
                        <div class="row notif_content">

                            <div class="col-12 shadow bg-white border-radius-xl p-3">

                                <div class="mb-4">
                                    <?php if ($key != 'processed') : ?>
                                        <!-- <div class="col-12 py-3 px-1">
                                            <a type="button" class="btn btn-sm/ btn-warning shadow-none article_nav article_active float-end/" onclick="requestModal(post_modal[17], post_modal[17], {'type':'<?= $key ?>'})"> <i class="fa-solid fa-calendar-check me-2"></i> <span> Add Event Booking </span> </a>
                                        </div> -->
                                    <?php else : ?>
                                    <?php endif; ?>
                                    <div class="col-12 py-3 px-1"></div>

                                    <div class="col-12" id="user_messages"></div>

                                    <div class="card-body px-0 pt-0 pb-2 col-12">
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width:1px">#</th> -->
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name & Surname</th>
                                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> <?= ($key == 'orders') ? 'Track Code': 'Event Type' ?> </th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center/ ps-2"> Date</th>
                                                        <th class="text-secondary opacity-7"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php if (is_array($bookings) || is_object($bookings)) : ?>
                                                        <?php $count = 0 ?>

                                                        <?php foreach ($bookings as $value) : ?>
                                                            <?php if (isset($value['event_type']) && $value['event_type'] == 'event') : continue; endif; ?>
                                                            <?php $count++ ?>
                                                            <?php $names = ($key == 'orders') ? get_event_by_id($value["event_id"]): $value ?>
                                                            <?php $event_id = ($key == 'orders') ? $names['event_id'] : $value['event_id'] ?>
                                                            <?php $event_text = ($key == 'orders') ? $value['order_track_code'] : ((isset($booking_types[$value['event_type']]['text'])) ? $booking_types[$value['event_type']]['text'] : '') ?>
                                                            <?php $date = ($key == 'orders') ? $value["order_date"] : $value['event_date_created'] ?>
                                                            <?php $mode = ($key == 'orders') ? 27: 27 ?>

                                                            <tr>
                                                                <!-- <td class="align-middle text-center">
                                                                    <span class="text-secondary text-xs font-weight-bold"> <?= $count ?> </span>
                                                                </td> -->
                                                                <td>
                                                                    <span class="text-secondary text-sm font-weight-bold"><?= $names['event_user_name'] . ' ' . $names['event_last_name'] ?></span>
                                                                </td>
                                                                <td class="align-middle text-center text-sm">
                                                                    <p class="text-xs font-weight-bold mb-0"> <span class="text-primary font-weight-bolder"> <?= $event_text ?> </span> </p>
                                                                </td>
                                                                <td class="align-middle text-center/">
                                                                    <span class="text-secondary text-xs font-weight-bold"><?= date('d M Y, @ H:i', strtotime($date)) ?></span>
                                                                </td>
                                                                <td class="align-middle">
                                                                    <a type="buttton" class="cursor-pointer" onclick="requestModal(post_modal[<?= $mode ?>], post_modal[<?= $mode ?>], {'event_id': <?= ((!empty($event_id)) ? $event_id : '') ?>,'type':'<?= (isset($value['event_type'])) ? $value['event_type'] : '' ?>'})"> <i class="fas fa-edit text-dark me-2"></i> Edit </a>
                                                                </td>
                                                            </tr>

                                                        <?php endforeach; ?>
                                                    <?php endif; ?>

                                                </tbody>
                                            </table>
                                        </div>


                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>
    </div>
</div>