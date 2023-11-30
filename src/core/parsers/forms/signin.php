<?php if (isset($_SESSION['active_otp'])) : ?>
    <div class="text-center">
        <ul class="mx-2 mb-1 nav nav-pills nav-fill text-center" id="pills-tab-account" role="tablist">
            <?php $tabbs_count = 0 ?>
            <?php foreach ($user_login_tabs as $key => $nav) : ?>
                <?php $tabbs_count++ ?>
                <li class="nav-item" style="margin: 3px;">
                    <a get-variable="mtab" data-name="<?= $key ?>" class="p-1 nav-link progress_ball" id="pills-<?= $key ?>-tab" data-bs-toggle="pill" href="#pills-<?= $key ?>" role="tab" aria-controls="pills-<?= $key ?>" aria-selected="<?= (((isset($_GET['mtab']) && $_GET['mtab'] == $key)  || empty($_GET['mtab'])) ? 'true' : 'false') ?>">
                        <span class="step <?= (((isset($_GET['mtab']) && $_GET['mtab'] ==  $key) || (!isset($_GET['mtab']) && $tabbs_count == 1)) ? 'active' : '') ?>"></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<div class="row">
    <div class="col-12 p-0">
        <!-- Tab panes -->
        <div class="tab-content" id="signin_tab">
            <?php $array_count = 0; ?>
            <?php foreach ($user_login_tabs as $key => $tabs) : ?>
                <?php $array_count++; ?>
                <div class="tab-pane fade <?= (((isset($_GET['mtab']) && $_GET['mtab'] == $key) || (!isset($_GET['mtab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">
                    <div class="col-12 p-3 pb-0">
                        <?php require $config['PARSERS_PATH'] . 'forms' . DS . $tabs['page'] . '.php' ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>