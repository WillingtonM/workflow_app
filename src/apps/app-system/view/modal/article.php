<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
  <div id="error_pop" class="error_pop col-12"></div>
  <div class="col-12"></div>

  <form id="article_form_img" class="text-center" action="index.html" method="post">

    <div class="col-auto contact_radio">
      <label for="product_image" class="col-sm-12/ control-label/ file_label_2">Article Image</span></label>
      <?php if ($article_id) : ?>
        <br>
        <div class="col-sm-12 text-center" style="width: 300px;">
          <img class="img-thumbnail img-responsive" src="./img/articles/<?= $req_res['article_type'] . DS . $req_res['article_image'] ?>" alt="<?= $req_res['article_title'] ?>" height="120px">
        </div>&nbsp;
      <?php endif; ?>
      <div class="col-sm-12 text-center">
        <div id="kv-avatar-errors-1" class="center-block" style="display: none; width: auto;"></div>
        <div class="kv-avatar text-center">
          <input type="file" name="product_image" accept="image/*" value="" id="product_image" class="file-loading/">
        </div>
      </div>
    </div>
  </form>&nbsp;

  <form id="article_form" class="" action="index.html" method="post">
    <hr>
    <div class="col-auto contact_radio"><br>
      <label for="contact">Article type</label>
      <br>
      <div class=" custom-control custom-radio">
        <input class="custom-control-input" type="radio" name="article_type" id="reasonRadio1" value="business_day" <?= ((isset($req_res['article_type']) && $req_res['article_type'] == 'business_day') ? 'checked' : '') ?>>
        <label class="custom-control-label text-muted" for="reasonRadio1">Business Day</label>
      </div>&emsp;
      <div class=" custom-control custom-radio">
        <input class="custom-control-input" type="radio" name="article_type" id="reasonRadio2" value="everyday_economics" <?= ((isset($req_res['article_type']) && $req_res['article_type'] == 'everyday_economics') ? 'checked' : '') ?>>
        <label class="custom-control-label text-muted" for="reasonRadio2">Everyday Economics</label>
      </div>&emsp;
    </div>
    <br>

    <div class="col-auto">
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text text-default-cstm"> <i class="fa fa-list-alt" aria-hidden="true"></i> </div>
        </div>
        <input type="text" name="article_title" value="<?= ((isset($req_res['article_title'])) ? $req_res['article_title'] : '') ?>" class="form-control" id="article_title" placeholder="Article Title" required>
      </div>
      <small class="text-muted col">Article title</small>
    </div>&nbsp;

    <div class="col-auto">
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text text-default-cstm"> <i class="fa fa-list-alt" aria-hidden="true"></i> </div>
        </div>
        <input type="text" name="article_source" value="<?= ((isset($req_res['article_source'])) ? $req_res['article_source'] : '') ?>" class="form-control" id="article_source" placeholder="Article Source" required>
      </div>
      <small class="text-muted col">Article source</small>
    </div>&nbsp;

    <div class="col-auto">
      <div id="" class="input-group mb-2 editor">
        <textarea id="mytextarea" class="form-control/ col-12/" name="article_content" rows="8" cols="80" value="" placeholder="Article Content"><?= ((isset($req_res['article_content'])) ? htmlspecialchars($req_res['article_content']) : '') ?></textarea>
      </div>
      <small class="text-muted col">Article content</small>
    </div>

    <?php if ($article_id) : ?>
      <input id="article_id" type="hidden" name="article_id" value="<?= $article_id ?>">
    <?php endif; ?>

  </form>

  <div class="col-12 my-3">
    <button type="button" class="btn btn-sm btn-info" onclick="modal_post()" <?= ((!$is_admin) ? 'disabled' : '') ?>>Save changes</button>
  </div>

</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>