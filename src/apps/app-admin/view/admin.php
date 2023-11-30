<div class="container-fluid bg-white border-radius-xl" style="border-radius: 25px;">
    <div class="row">
        <div class="col-12 mt-3">
            <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                <?php $tabbs_count = 0 ?>
                <?php foreach ($admin_pagenav as $key => $nav) : ?>
                    <?php $tabbs_count++ ?>
                    <?php $disable = ($tabbs_count != 1 && $stage !== NULL && $tabbs_count !== $stage && ($tabbs_count > ($stage))) ? TRUE : FALSE ?>
                    <?php $disable = FALSE ?>
                    <li class="shadow nav-item/ font-weight-bold article_nav m-1 <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'article_active' : '') ?>">
                        <a <?= ($disable) ? 'disabled' : 'get-variable="tab"' ?> data-name="<?= $key ?>" class="nav-link <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'active' : '') ?>" id="pills-<?= $key ?>-tab" data-bs-toggle="pill" href="#pills-<?= $key ?>" role="tab" aria-controls="pills-<?= $key ?>" aria-selected="<?= (((isset($_GET['tab']) && $_GET['tab'] == $key)  || empty($_GET['tab'])) ? 'true' : 'false') ?>">
                            <span class="border-weight-bolder fs-6"> <i class="<?= $nav['imgs'] ?>"> &nbsp; </i> <?= $nav['short'] ?> </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="tab-content col-12" style="padding: 25px 0;">
        <?php $array_count = 0; ?>
        <?php foreach ($admin_pagenav as $key => $tabs) : ?>
            <?php $array_count++; ?>
            <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">

                <?php require $config['PARSERS_PATH'] . 'settings' . DS . $key .'.php'; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>
