<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
  <div id="contact_div/" class="col-12" style="padding-top: 25px;">

    <div class="text-center" style="padding-top: 7px !important;">
      <div class="card-body/">
        <br>
        <h3 class="text-warning col-12" style="padding-left: 15px; font-weight: bold; font-family: Lato; font-size: 1.9em !important;"> <?= $article_title ?> </h3>
      </div>
    </div>

    <div class="row text-center">
      <small class="col-12 text-muted">

        <?php if (!empty($article_publisher) && !empty($article_publisher)) : ?>
          <i class="text-muted"> First Published in <?= (isset($article_link) && check_url($article_link)) ? '<a href="' . $article_link . '" target="_blank" class="text-info"><b>' . $article_publisher . '</b></a>' : $article_publisher ?> on &nbsp; </i>
        <?php elseif (!empty($article_type) && $article_type == 'business_day') : ?>
          <i class="text-muted"> <?= ($article_type == 'business_day') ? 'First Published in ' . ((!empty($article_link) && check_url($article_link)) ? '<a href="' . $article_link . '" target="_blank" class="text-info"><b>Business Day</b></a>' : '<b>Business Day</b>') . ' on' : 'Published on' ?> &nbsp; </i>
        <?php else : ?>
          <i class="text-muted"> Published on &nbsp; </i>
        <?php endif; ?>

        <?php if (!empty($article_link) && check_url($article_link) && !empty($artcl_date)) : ?>
          <a href="<?= $article_link ?>" target="_blank" class="text-info"><?= $artcl_date->format('F jS, Y') ?></a>
        <?php elseif (!empty($artcl_date)) : ?>
          <span class="text-warning" style="color: #d4af37"> <?= $artcl_date->format('F jS, Y') ?></span>
        <?php endif; ?>

        &nbsp; | &nbsp; <i>by</i> &nbsp; <strong> Author<?= (isset($article_author) && $article_author != '') ? 's' : '' ?> | &nbsp; <?= PROJECT_TITLE ?> <?= (isset($article_author) && $article_author != '') ? ', ' . $article_author : '' ?> </strong>
      </small>
    </div>

    <br>
    <div class="row">
      <div class="col-12 text-center">
        <img id="view_img" style="max-height: 350px;" class="float-left/ img-thumbnail img-responsive" src="./img/home/plain-bg.png" alt="">
        <div class="">
          <?php if (isset($article_source) && $article_source != '') : ?>
            <small class="float-left/ text-muted"><i>Image source</i> &nbsp; | &nbsp; <?= $article_source ?></small>
          <?php endif; ?>
        </div>
      </div>
    </div> <br>

    <div class="row" st="padyleding: 15px;">
      <div class="col-12 textarea-container">
        <div class="col-12" style="border: 1px solid #efefef; background: #fafafa; border-radius: 15px; padding: 15px 18px; color: #555555;">
          <?= nl2br($article_post) ?>
        </div>
        <br>

        <div id="file_div">
          <span class="col-12 alt_dflt">Attachment</span> &emsp;

          <h5 class="col-12 file_modal_view" id="file_modal_view">
            <embed id="file_upload_modal" type="application/pdf" class="image" src="" height="500" style="width: 100%; max-height: 300px; overflow-y: hidden !important; overflow: hidden;">
          </h5>
        </div>

      </div>
    </div>

    <br><br>
  </div>

</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

<script>
  $(function() {

    var view_img = $('.image').prop('src');
    $('#view_img').prop('src', view_img);

    var file_src = $('#file_upload').prop('src');
    var orgn_src = $('#origin_file').prop('src');

    if (file_src != null) {
      $('#file_div').show();
      $('#file_upload_modal').prop('src', file_src);
    } else if (orgn_src != null) {
      $('#file_div').show();
      $('#file_upload_modal').prop('src', orgn_src);
    } else {
      $('#file_div').hide();
    }

  });
</script>