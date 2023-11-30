<div class="container">

    <div class="row">

        <div class="tab-content col-12"">

            <?php $array_count = 0; ?>
            <?php foreach ($association_navs as $key => $tabs) : ?>
                <?php $array_count++; ?>
                <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">
                    <div class="row">
                        <div class="col-12" style="padding: 5px !important;">
                            <?php require $config['PARSERS_PATH'] . 'assigns' . DS . $key . '.php'; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>

</div>