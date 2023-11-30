<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row mb-5">
  <div class="col-12">
    <ul class="nav nav-pills nav-justified" id="pills-tab-media" role="tablist">
      <?php $tabbs_count = 0 ?>
      <?php foreach ($user_types_navs as $key => $nav) : ?>
        <?php $tabbs_count++ ?>
        <?php $type_edit = ($tabbs_count == 1 && !empty($req_res))? true : false; ?>
        <li class="shadow nav-item/ font-weight-bold article_nav m-1 <?= (( ((isset($user_tab) && $user_tab == $key) || (empty($user_tab) && $tabbs_count == 1) ) ) ? 'article_active' : '') ?>">
          <a get-variable="tab" data-name="<?= $key ?>" class="nav-link <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'active' : '') ?>" id="pills-<?= $key ?>-tab" data-bs-toggle="pill" href="#pills-<?= $key ?>" role="tab" aria-controls="pills-<?= $key ?>" aria-selected="<?= (((isset($_GET['tab']) && $_GET['tab'] == $key)  || empty($_GET['tab'])) ? 'true' : 'false') ?>">
            <span class="border-weight-bolder"> <i class="<?= $nav['imgs'] ?>"> &nbsp; </i> <?= $nav['short'] ?> </span>
            <h6 class="text-center sm_text text-xs font-weight-bold mb-0" style="color: #777;"><?= $nav['long'] ?></h6>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<!-- <hr class="horizontal dark mt-1 mb-3"> -->

<div class="row">
  <div class="col-12">
    <div class="tab-content" id="notif_tab_media">
      <?php $tabbs_count = 0; ?>
      <?php foreach ($user_types_navs as $key => $tabs) : ?>
        <?php $tabbs_count++; ?>
        <?php $type_edit = ($tabbs_count == 1 && !empty($req_res))? true : false; ?>

        <div class="tab-pane fade <?= (( (isset($user_tab) && $user_tab == $key) || (empty($user_tab) && $tabbs_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">

          <div class="row notif_content mb-3 bg-white border-radius-xl">
            <?php require_once $config['PARSERS_PATH'] . 'forms' . DS . $key . '.php' ?>
          </div>

        </div>

      <?php endforeach; ?>

    </div>

  </div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>
