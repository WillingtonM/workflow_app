<div class="container">
  <div class="row">
    <br>
    <div id="" class="media_div col-12 shadow bg-white" style="border-radius: 25px;">

      <?php if (!isset($_SESSION['request_vars']) || empty($_SESSION['request_vars'])) : ?>
        <div class="col-12 shadow bg-white" style="border-radius: 12px;"><br>
          <!-- <h6 class="text-secondary"> Please note that this article may not be posted automatically to your Twitter timeline </h6> -->
          <?php if ($twt_data['success'] && !empty($twt_data['data'])) : ?>
            <div class="row text-center">
              <div class="col-12 py-0 px-3">
                <h6 class="text-secondary"> You need to signin to to automatically post your blog to your Twitter timeline</h6>
              </div>

              <div class="col-12 pb-2">
                <a href="<?= $twt_data['data'] ?>" target="_blank" class="col-12 btn btn-info btn-sm" style="border-radius: 12px; font-weight: bolder;"> <i class="fab fa-twitter"></i> &nbsp; Login using Twitter </a>
              </div>
              <div class="col-12 text-secondary pb-3">
                <small class="text-center">Once loggedin to Twitter, your article may be posted automatically, otherwise refresh the page!</small>
              </div>

            </div>
          <?php endif; ?>
        </div>
        <br>
      <?php endif; ?>

      <form id="article_form_img" class="text-center" action="index.html" method="post">

        <div id="profile_img_form" class="text-center body_element" style="border: 1px solid #ddd; background-color: #eee; border-radius: 25px; padding: 5px;">
          <a id="img_cspture" class="w-100 shadow p-3 bg-light border-radius-xl" type="button" name="button">
            <img class="image me-3 p-1 border-radius-xl border" style="height: 160px;" src="<?= ((isset($_GET['article_id'])) ? article_img($req_res['article_type'], $req_res['article_image'], 1) : '') ?>" alt="<?= ((isset($req_res) && $req_res != NULL) ? $req_res['article_title'] : '') ?>">

            <span style="top: 17px;">
              <i class="fas fa-camera fa-3x me-3"></i>
            </span>
            <br>
            <small> Upload profile image </small>
          </a>
          <input id="post_image" type="file" name="post_image" accept="image/*" style="display: none;">
        </div>
      </form>
      <form id="article_form" class="" action="index.html" method="post">
        <br>
        <div class="clear-fix">
          <div id="file_uplod">

            <?php if (isset($req_res['article_file']) && !empty($req_res['article_file'])) : ?>
              <?php
              $file_name  = $req_res['article_file'];
              $file_parts = pathinfo($file_name);
              $fl_ext     = 'fa-file';
              $text_colr  = 'text-secondary';
              if (array_key_exists('extension', $file_parts)) {
                switch ($file_parts['extension']) {
                  case "pdf":
                    $fl_ext = 'fa-file-pdf';
                    $text_colr = 'text-danger';
                    break;
                  case "doc" || 'docx':
                    $fl_ext = 'fa-file-word';
                    $text_colr = 'text-primary';
                    break;
                  case "": // Handle file extension for files ending in '.'
                    $fl_ext = 'fa-file';
                  case NULL: // Handle no file extension
                    $fl_ext = 'fa-file';
                    break;
                }
              }
              ?>
              <span class="col-12 alt_dflt">File Attachment</span>

              <h5 class="col-12">
                <a class="doc_anchor text-secondary" href="<?= ABS_FILES . $file_name ?>" style="padding-bottom: 15px !important;">
                  <i class="fa <?= $fl_ext . ' ' . $text_colr ?> " aria-hidden="true"></i> &nbsp; <?= $req_res['article_title'] ?>
                </a>
                <embed id="origin_file" src="<?= ABS_FILES . $file_name ?>#page=1&zoom=75" width="575" height="500" style="width: 100%; max-height: 300px; overflow-y: hidden !important; overflow: hidden;">

              </h5>

            <?php endif; ?>

          </div>
          <button type="button" class="btn btn-secondary btn-sm border-radius-lg shadow-none" onclick="requestModal(post_modal[5], 'fileModal', {})"> Upload Files</button>
        </div>

        <div class="bg-light p-3 border-radius-lg">
          <div class="col-auto contact_radio mb-3"><br>
            <label for="article_type" class="text-secondary">Article type</label> <br>
            <?php foreach ($article_array as $key => $article) : ?>
              <?php $count++ ?>
              <div class="form-check form-check-inline me-3">
                <input class="form-check-input me-2" type="radio" name="article_type" id="reasonRadio<?= $count ?>" value="<?= $key ?>" <?= ((($key == 'article' && !isset($req_res['article_type'])) || (isset($req_res['article_type']) && $req_res['article_type'] == $key)) ? 'checked' : '') ?>>
                <label class="custom-control-label text-muted" for="reasonRadio<?= $count ?>"><?= $article ?></label>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="form-floating mb-2 has-validation">
            <input type="text" name="article_title" value="<?= ((isset($req_res['article_title'])) ? $req_res['article_title'] : '') ?>" class="form-control shadow-none" id="article_title" placeholder="Article Title" required>
            <label for="merchant_name"> Article title </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
              <span>Invalid Article title</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Article title">
          </div>

          <div class="form-floating mb-2 has-validation">
            <input type="text" name="article_link" value="<?= ((isset($req_res['article_link'])) ? $req_res['article_link'] : '') ?>" class="form-control shadow-none" id="article_link" placeholder="Article link" required>
            <label for="merchant_name"> Article Link </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
              <span>Invalid Article Link</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Article Link">
          </div>

          <div class="form-floating mb-2 has-validation">
            <input type="text" name="article_publisher" value="<?= ((isset($req_res['article_publisher'])) ? $req_res['article_publisher'] : '') ?>" class="form-control shadow-none" id="article_publisher" placeholder="First publisher" required>
            <label for="merchant_name"> First publisher </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
              <span>Invalid First publisher</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid First publisher">
          </div>

          <div class="form-floating mb-2 has-validation">
            <input type="text" name="article_author" value="<?= ((isset($req_res['article_author'])) ? $req_res['article_author'] : '') ?>" class="form-control shadow-none" id="article_author" placeholder="Article authors" required>
            <label for="merchant_name"> Article Authors (Separate by a comma) </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
              <span>Invalid Authors</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Authors">
          </div>

          <div class="form-floating mb-2 has-validation">
            <input type="text" name="article_source" value="<?= ((isset($req_res['article_source'])) ? $req_res['article_source'] : '') ?>" class="form-control shadow-none" id="article_source" placeholder="Article image source" required>
            <label for="merchant_name"> Article Image source </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
              <span>Invalid Article Image source</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Article Image source">
          </div>

          <div class="col-auto mb-3">
            <label for="" class="px-2 text-secondary">Article Publication date</label>
            <div class="row g-3 mb-0">
              <div class="col-4 col-md-2/">
                <div class="input-group">
                  <span class="input-group-text"> <i class="fas fa-calendar-day"></i> </span>
                  <?php $date_days = range(1, 31, 1) ?>
                  <select class="form-control shadow-none" name="publication_day">
                    <?php foreach ($date_days as $value) : ?>
                      <option value="<?= $value ?>" <?= ((isset($req_res['article_publish_date']) && (int) date('d', strtotime($req_res['article_publish_date'])) == $value) ? 'selected' : ((!isset($req_res['article_publish_date']) && empty($req_res['article_publish_date']) && $value == (int)date('d')) ? 'selected' : '')) ?>> <?= $value ?> </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="col-4 col-md-2/">
                <select class="form-control shadow-none" name="publication_month">
                  <?php foreach ($date_months as $val => $month) : ?>
                    <option value="<?= $val ?>" <?= ((isset($req_res['article_publish_date']) && (int) date('m', strtotime($req_res['article_publish_date'])) == $val) ? 'selected' : ((!isset($req_res['article_publish_date']) && empty($req_res['article_publish_date']) && $val == (int)date("m")) ? 'selected' : '')) ?>> <?= $month ?> </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-4 col-md-2/">
                <?php $date_days = range(date("Y"), 1900, -1) ?>
                <select class="form-control shadow-none" name="publication_year">
                  <?php foreach ($date_days as $value) : ?>
                    <option value="<?= $value ?>" <?= ((isset($req_res['article_publish_date']) && (int) date('Y', strtotime($req_res['article_publish_date'])) == $value) ? 'selected' : ((!isset($req_res['article_publish_date']) && empty($req_res['article_publish_date']) && $value == date("Y")) ? 'selected' : '')) ?>> <?= $value ?> </option>
                  <?php endforeach; ?>
                </select>
              </div>

            </div>
          </div>

          <div class="form-floating mb-2 has-validation">
            <textarea id="mytextarea" class="form-control shadow-none border-radius-none" name="" rows="8" cols="100" value="" placeholder="Article Content" style="border-radius: none !important; border-radius: 0 !important;"><?= ((isset($req_res['article_content'])) ? htmlspecialchars($req_res['article_content']) : '') ?></textarea>
            <label for="merchant_name"> </label>
            <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
              <span>Invalid Article content</span>
            </div>
            <input type="hidden" class="invalid_text" value="Invalid Article content">
          </div>

        </div>

        <div class="p-3 col-12">
          <?php if (isset($_SESSION['request_vars']) && !empty($_SESSION['request_vars'])) : ?>
            <div class="form-check">
              <input id="twitter_publish" class="form-check-input" name="twitter_publish" value="true" type="checkbox" checked>
              <label class="form-check-label" for="flexCheckDefault">
                Publish to Twitter
              </label>
            </div>
          <?php endif; ?>

          <?php if (!isset($req_res)) : ?>
            <div class="form-check">
              <input id="subscription_publish" class="form-check-input" name="subscription_publish" value="true" type="checkbox" checked>
              <label class="form-check-label" for="flexCheckDefault">
                Publish to subscribers
              </label>
            </div>
          <?php endif; ?>

          <div class="form-check">
            <input id="cronjob" name="cronjob" class="form-check-input" value="true" type="checkbox" <?= ((isset($req_res['article_cronjob']) && $req_res['article_cronjob'] == 1) ? 'checked' : '') ?>>
            <label class="form-check-label" for="flexCheckDefault">
              Schedule
            </label>
          </div>


          <div class="col-auto mb-3">
            <label for="" class="px-2 text-secondary">Schedule Date</label>
            <div class="row g-3 mb-0">

              <div class="col-12 col-sm-3">
                <small class="text-xs ps-3"> Day </small>
                <div class="input-group">
                  <span class="input-group-text"> <i class="fas fa-calendar-day"></i> </span>
                  <?php $date_days = range(1, 31, 1) ?>
                  <select class="form-control shadow-none" name="dob">
                    <?php foreach ($date_days as $value) : ?>
                      <option value="<?= $value ?>" <?= ((isset($req_res['article_publish_date']) && (int) date('d', strtotime($req_res['article_publish_date'])) == $value) ? 'selected' : ((!isset($req_res['article_publish_date']) && empty($req_res['article_publish_date']) && $value == (int)date('d')) ? 'selected' : '')) ?>> <?= $value ?> </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="col-12 col-sm-3">
                <small class="text-xs ps-3"> Month </small>
                <select class="form-control shadow-none" name="mob">
                  <?php foreach ($date_months as $val => $month) : ?>
                    <option value="<?= $val ?>" <?= ((isset($req_res['article_publish_date']) && (int) date('m', strtotime($req_res['article_publish_date'])) == $val) ? 'selected' : ((!isset($req_res['article_publish_date']) && empty($req_res['article_publish_date']) && $val == (int)date("m")) ? 'selected' : '')) ?>> <?= $month ?> </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-12 col-sm-3">
                <small class="text-xs ps-3"> Year </small>
                <?php $date_days = range(date("Y"), 1900, -1) ?>
                <select class="form-control shadow-none" name="yob">
                  <?php foreach ($date_days as $value) : ?>
                    <option value="<?= $value ?>" <?= ((isset($req_res['article_publish_date']) && (int) date('Y', strtotime($req_res['article_publish_date'])) == $value) ? 'selected' : ((!isset($req_res['article_publish_date']) && empty($req_res['article_publish_date']) && $value == date("Y")) ? 'selected' : '')) ?>> <?= $value ?> </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-12 col-sm-3">
                <small class="text-xs ps-3"> @ hour </small>
                <?php $date_days = range(1, 24, 1) ?>
                <select class="form-control shadow-none" name="hour">
                  <?php foreach ($date_days as $value) : ?>
                    <option value="<?= $value ?>" <?= ((isset($req_res['article_cronjob_date']) && (int) date('d', strtotime($req_res['article_cronjob_date'])) == $value) ? 'selected' : ((!isset($req_res['article_cronjob_date']) && empty($req_res['article_cronjob_date']) && $value == 6) ? 'selected' : '')) ?>><?= $value ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

            </div>
          </div>
        </div>

        <?php if ($article_id) : ?>
          <input id="article_id" type="hidden" name="article_id" value="<?= $article_id ?>">
        <?php endif; ?>

      </form>

      <div id="error_pop" class="error_pop col-12 px-3"></div>

      <div class="col-12 px-3">
        <button type="button" class="btn btn-sm btn-secondary shadow-none border-radius-lg me-2" onclick="modal_post()" <?= ((!$is_admin) ? 'disabled' : '') ?>>Save changes</button>
        <button type="button" class="btn btn-sm btn-info shadow-none border-radius-lg me-2" onclick="requestModal( post_modal[7], post_modal[7], $('#article_form').serialize() + '&article_content=' + encodeURIComponent(tinyMCE.get('mytextarea').getContent()), 1); " <?= ((!$is_admin) ? 'disabled' : '') ?>>View Article</button>

        <a href="./blog" class="btn btn-warning shadow-none border-radius-lg me-2 btn-sm float-end">Cancel</a>
        <?php if (isset($article_id) && !empty($article_id)) : ?>
          <button type="button" class="btn btn-sm btn-danger float-end shadow-none border-radius-lg me-2" onclick="postCheck('null',{'article_id': <?= $article_id ?>, 'article_remove':true, 'article_type':'<?= $req_res['article_type'] ?>'})" <?= ((!$is_admin) ? 'disabled' : '') ?>>Remove article</button>
        <?php endif; ?>
      </div>
      <br>

    </div>

  </div>

</div>