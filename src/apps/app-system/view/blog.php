<div class="container">

  <div class="row">

    <div class="col-12">

      <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
        <?php $tabbs_count = 0 ?>
        <?php foreach ($article_navba as $key => $nav) : ?>
          <?php $tabbs_count++ ?>
          <li class="shadow nav-item font-weight-bold article_nav m-1 <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'article_active' : '') ?>">
            <a get-variable="tab" data-name="<?= $key ?>" class="nav-link <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'active' : '') ?>" id="pills-<?= $key ?>-tab" data-bs-toggle="pill" href="#pills-<?= $key ?>" role="tab" aria-controls="pills-<?= $key ?>" aria-selected="<?= (((isset($_GET['tab']) && $_GET['tab'] == $key)  || empty($_GET['tab'])) ? 'true' : 'false') ?>">
              <span class="border-weight-bolder"> <i class="<?= $nav['imgs'] ?>"> &nbsp; </i> <?= $nav['short'] ?> </span>
              <hr class="horizontal dark mt-1 mb-0">
              <h6 class="text-center sm_text text-xs font-weight-bold mb-0" style="color: #777;"><?= $nav['long'] ?></h6>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>

    </div>

    <div class="tab-content col-12" style="padding: 25px 0;">
      <a href="blog-article" class="btn btn-secondary shadow-none border-radius-lg"> Create Article</a>

      <?php foreach ($article_array as $key => $article) : ?>
        <?php $array_count++; ?>
        <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">
          <div class="row">
            <?php require $config['PARSERS_PATH'] . 'articles' . DS . 'article_logic.php'; ?>
            <br><br>
          </div>
          <div class="row clearfix">
            <!-- paggination -->
            <?php require $config['PARSERS_PATH'] . 'articles' . DS . 'article_pagination.php'; ?>
          </div>
        </div>
      <?php endforeach; ?>

    </div>

  </div>

</div>