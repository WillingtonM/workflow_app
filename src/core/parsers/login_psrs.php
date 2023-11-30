<div class="row">
  <div class="col-12 pt-5">
    <ul class="nav nav-pills nav-justified text-center" id="pills-tab" role="tablist">
      <?php $tabbs_count = 0 ?>
        <?php foreach ($login_tabs as $key => $nav) : ?>
          <?php $tabbs_count++ ?>
          <?php if ($key == 'file') { continue; } ?>
          <li class="shadow nav-item font-weight-bold article_nav m-1 <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'article_active' : '') ?>">
            <a get-variable="tab" data-name="<?= $key ?>" class="nav-link <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'active' : '') ?>" id="pills-<?= $key ?>-tab" data-bs-toggle="pill" href="#pills-<?= $key ?>" role="tab" aria-controls="pills-<?= $key ?>" aria-selected="<?= (((isset($_GET['tab']) && $_GET['tab'] == $key)  || empty($_GET['tab'])) ? 'true' : 'false') ?>">
              <span class="border-weight-bolder"> <i class="<?= $nav['imgs'] ?> me-2 d-none d-lg-block"></i> <?= $nav['name'] ?> </span>
              <hr class="horizontal dark mt-1 mb-0">
              <h6 class="text-center sm_text text-xs font-weight-bold mb-0" style="color: #777;"><?= $nav['long'] ?></h6>
            </a>
          </li>
        <?php endforeach; ?>
    </ul>
  </div>

  <div class="col-12 p-3">
    
    <!-- Tab panes -->
    <div class="tab-content" id="login_form_div/">

      <?php $array_count = 0; ?>
      <?php foreach ($login_tabs as $key => $tabs) : ?>
        <?php $array_count++; ?>
        <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">
          <div class="col-12 border-radius-xl p-0 pb-0">
            <?php require $config['PARSERS_PATH'] . 'forms' . DS . $tabs['page'] . '.php' ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- default inputs -->
    <form id="loginFormInputs">
      <input type="hidden" class="form_create_stage" name="form_create_stage" id="form_create_stage" value="0">
      <input type="hidden" class="user_create" name="user_create" id="user_create" value="0">
      <input type="hidden" class="user_remember" name="user_remember" id="user_remember" value="0">
      <input type="hidden" class="user_email_confirm" name="user_email_confirm" id="user_email_confirm" value="<?= (isset($user) && $user['user_email_confirm'] == 1) ? 1 : 0 ?>">

      <input id="logintype" type="hidden" name="logintype" value="<?= $is_login ?>">
      <input id="passresetInpt" type="hidden" name="passreset" value="<?= ($passreset) ? 1 : 0 ?>">

      <?php if (isset($data['success']) && $data['success'] == true) : ?>
        <input id="passresetConfirm" type="hidden" name="passreset_confirm" value="1">
        <input id="reset_code" type="hidden" name="reset_code" value="<?= $token ?>">
        <input id="user_type" type="hidden" name="user_type" value="<?= $user_type ?>">
        <input id="userkey" type="hidden" name="userkey" value="<?= $userkey ?>">
        <?php if ($user_type == 'admin') : ?>
          <input id="merchant" type="hidden" name="merchant" value="<?= $merchant_id ?>">
          <input id="user" type="hidden" name="user" value="<?= ((isset($user_id)) ? $user_id : '') ?>">
        <?php endif; ?>
      <?php endif; ?>
    </form>

  </div>

</div>

<div class="col-12 mx-auto my-3 text-center">
  <span class="text-secondary">
    <small class="me-1">Copyright © <?= date("Y") ?> </small> <span class="me-1" style="font-size: 1rem;"> &middot;</span>
    <small class="me-1"> <a href="./policy" class="text-secondary">Privacy policy</a></small> <span class="me-1" style="font-size: 1rem;"> &middot;</span>
    <small class="me-1"> <a href="./about" class="text-secondary">About</a></small> <span class="me-1" style="font-size: 1rem;"> &middot;</span>
  </span>
</div>