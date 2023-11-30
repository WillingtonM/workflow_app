<div class="container">

    <div class="row">
        <div class="col-12 border-radius-xl p-0">
            <div class="card mb-4 p-3">
                <div class="card-header pb-0 ps- 0">
                    <h5 class="text-secondary font-weight-bolder fs-4 ps-0"> 
                        <span> Feedback Messages </span>
                    </h5>
                </div>
                <div class="card-body p-3">
                    <?php if (is_array($feedback_data) || is_object($feedback_data)) : ?>
                        <?php $count = 0 ?>
                        
                        <?php foreach ($feedback_data as $feedback) : ?>
                            <?php $count++ ?>
                            <?php $feedback_date       = DateTime::createFromFormat('Y-m-d H:i:s', $feedback['feedback_date_created']) ?>

                            <div class="row">
                                <div class="col-12 shadow border/ border-radius-lg bg-light mb-3 p-3">
                                    <h5 class="text-dark">
                                        <strong> <?= $feedback['feedback_name'] . ' ' . $feedback['feedback_last_name'] ?> </strong>
                                    </h5>
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><i class="fa-solid fa-browser"></i> <?= (isset($feedback['feedback_app'])) ? $feedback['feedback_app'] : '' ?> </li>
                                        <li class="list-inline-item"><i class="fa fa-calendar-o"></i> <?= $feedback_date->format('Y-M-d') ?> </li>
                                        <li class="list-inline-item"><i class="fa fa-clock-o"></i> <?= $feedback_date->format('h:i A') ?> </li>
                                        <li class="list-inline-item"><i class="fa-solid fa-envelope"></i> <a href="mailto:<?= $feedback['feedback_email'] ?>"><?= $feedback['feedback_email'] ?></a> </li>
                                    </ul>
                                    <p> <?= $feedback['feedback_message'] ?> </p>
                                </div>
                            </div>

                        <?php endforeach; ?>
                            
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

</div>