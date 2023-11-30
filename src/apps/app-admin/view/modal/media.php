<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
<div class="row">
  <div class="col-12 shadow p-3 mb-3 bg-white rounded">
    <sapn class="font-weight-bolder text-center text-secondary ps-3"><?= (isset($req_res) && !empty($req_res)) ? 'Edit' : 'Add' ?> Media Appearance</sapn>
  </div>
</div>

<div class="row">

  <form id="media_form" class="col-12" method="POST">

    <div id="tittleDiv" class="input-group mb-2">
      <span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-newspaper"></i> </b> </span>
      <div class="form-floating form-floating-group flex-grow-1">
        <input type="text" name="media_title" class="special_form form-control shadow-none" id="media_title" value="<?= ((isset($req_res['media_title'])) ? $req_res['media_title'] : '') ?>" placeholder="Media Title" style="border-radius: 0 12px 12px 0;">
        <label for="media_title">Media title</label>
      </div>
      <section id="titleFeedback" class="valid-feedback">
        Invalid media title
      </section>
      <input type="hidden" class="invalid_text" value="Invalid media title">
    </div>

    <div id="sourceDiv" class="input-group mb-2">
      <span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-link"></i> </b> </span>
      <div class="form-floating form-floating-group flex-grow-1">
        <input type="text" name="media_url" class="special_form form-control shadow-none" id="media_url" value="<?= ((isset($req_res['media_url'])) ? $req_res['media_url'] : '') ?>" placeholder="Media Source" style="border-radius: 0 12px 12px 0;">
        <label for="media_url">Media source</label>
      </div>
      <section id="sourceFeedback" class="valid-feedback">
        Invalid media source
      </section>
      <input type="hidden" class="invalid_text" value="Invalid media source">
    </div>

    <div id="dateDiv" class="input-group mb-2">
      <span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-calendar-day"></i> </b> </span>
      <div class="form-floating form-floating-group flex-grow-1">
        <input type="date" name="media_publish_date" class="special_form form-control shadow-none" id="media_publish_date" value="<?= ((isset($req_res['media_publish_date'])) ? date('Y-m-d', strtotime($req_res['media_publish_date'])) : '') ?>" placeholder="YYYY/mm/dd" style="border-radius: 0 12px 12px 0;">
        <label for="media_publish_date">Media Published date</label>
      </div>
      <section id="dateFeedback" class="valid-feedback">
        Invalid Published date
      </section>
      <input type="hidden" class="invalid_text" value="Invalid Published date">
    </div>

    <div id="contentDiv" class="mb-2 d-flex">
      <span class="input-group-text flex-shrink-1 border-end-0 border-radius-end-none" style="border-radius: 12px 0 0 12px"><b class="mt-3"> <i class="fa-solid fa-photo-film"></i> </b> </span>
      <div class="form-floating form-floating-group w-100">
        <textarea class="special_form form-control shadow-none" id="media_content" name="media_content" value="" rows="4" cols="80" placeholder="Media Content" style="border-radius: 0 12px 12px 0;"><?= ((isset($req_res['media_content'])) ? $req_res['media_content'] : '') ?></textarea>
        <label for="media_content">Media content</label>
      </div>
      <section id="dateFeedback" class="valid-feedback">
        Invalid content
      </section>
      <input type="hidden" class="invalid_text" value="Invalid content">
    </div>

    <input type="hidden" id="media_type" name="media_type" value="<?= $media_type ?>">
    <input type="hidden" name="media_id" value="<?= ((isset($media_id) && !empty($media_id)) ? $req_res['media_id'] : '') ?>">

    <div id="error_pop" class="error_pop col-12"></div>
  </form>

</div>

<div class="row">
  <div class="col-12 mt-4">
    <?php if (isset($media_id) && !empty($media_id)) : ?>
      <button type="button" class="btn shadow-none text-danger float-end border-radiusl-lg" onclick="postCheck('error_pop', {'media_remove':true,'media_id':<?= $req_res['media_id'] ?>}, 0);" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa fa-trash me-2" aria-hidden="true"></i> Remove</button>
    <?php endif; ?>
    <button type="button" class="btn btn-sm btn-secondary shadow-none border-radiusl-lg" onclick="postCheck('error_pop',  $('#media_form').serialize(), 0, true)" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>Save changes</button>
  </div>
</div>


<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>