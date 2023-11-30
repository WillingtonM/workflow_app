<?php $event_date       = DateTime::createFromFormat('Y-m-d H:i:s', $event['event_host_date']) ?>
<?php $event_begindate  = DateTime::createFromFormat('Y-m-d H:i:s', $event['event_begin_date']) ?>
<?php $event_enddate    = DateTime::createFromFormat('Y-m-d H:i:s', $event['event_end_date']) ?>

<div class="row notif_content mb-3 bg-light border-radius-xl p-3 border">
    <div class="col-2 text-right text-center">
        <h1 class="display-6"><span class="bg-dark badge"><?= $event_date->format('d') ?></span></h1>
        <h2><?= $event_date->format('M') ?></h2>
    </div>
    <div class="col-10">
        <h3 class="text-uppercase/ text-dark">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a type="button" onclick="requestModal(post_modal[9], post_modal[9], {'event':<?= $event['event_id'] ?>, 'type':'event'})"> <strong> <?= $event['event_title'] ?> </strong> </a>
            <?php else : ?>
                <strong> <?= $event['event_title'] ?> </strong>
            <?php endif; ?>
        </h3>
        <ul class="list-inline">
            <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?= $event_date->format('D') ?> </li>
            <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $event_begindate->format('h:i A') . ' - ' . $event_enddate->format('h:i A') ?> </li>
            <li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i> <?= $event['event_venue'] ?></li>
        </ul>
        <p> <?= $event['event_description'] ?> </p>
    </div>
</div>