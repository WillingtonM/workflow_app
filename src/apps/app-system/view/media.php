<div class="container">
  <div class="row mb-3">
    <div class="col-12">
      <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
        <?php $tabbs_count = 0 ?>
        <?php foreach ($media_navba as $key => $nav) : ?>
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
  </div>

  <div class="row">
    <div class="col-12">
      <div class="tab-content" id="notif_tab">
        <?php $array_media_count = 0; ?>
        <?php foreach ($media_navba as $key => $tabs) : ?>
          <?php $array_media_count++; ?>

          <?php $media = ($key == 'appearance') ? get_media_by_media_type($key) : null ?>
          <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_media_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">

            <div class="row notif_content mb-3 shadow bg-white border-radius-xl">

              <div class="col-12 p-3">

                <div class="card/ mb-4" style="background: none">

                  <div class="col-12" id="user_messages"></div>
                  <?php require $config['PARSERS_PATH'] . 'media' . DS . 'media_action.php' ?>
                  <?php require $config['PARSERS_PATH'] . 'media' . DS . $key . '.php' ?>

                </div>

              </div>
            </div>

            <div class="row">
              <!-- paggination -->
              <?php if ($pggl_count > 1) : ?>
                <div class="col-12">
                  <nav aria-label="Page navigation text-secondary">
                    <ul class="pagination float-right">
                      <li class="page-item">
                        <a class="page-link text-secondary" href="?tab=<?= $key ?>&page=<?= (((int)$pggl_nmb - 1 <= 0) ? $pggl_nmb : $pggl_nmb - 1) ?>&type=<?= $key ?>" <?= (($pggl_nmb - 1 <= 0) ? 'disabled' : '') ?> aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>

                      <?php for ($pg = 1; $pg <= $pggl_count; $pg++) : ?>
                        <li class="page-item"><a class="page-link <?= (($pg == $pggl_nmb) ? 'text-danger' : 'text-secondary') ?>" href="?tab=<?= $key ?>&page=<?= $pg ?>&type=<?= $key ?>"><?= $pg ?></a></li>
                      <?php endfor; ?>

                      <li class="page-item">
                        <a class="page-link text-secondary" href="?tab=<?= $key ?>&page=<?= (($pggl_nmb >= $pggl_count) ? $pggl_nmb : $pggl_nmb + 1) ?>&type=<?= $key ?>" <?= (($pggl_nmb >= $pggl_count) ? 'disabled' : '') ?> aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
                </div>
              <?php endif; ?>

            </div>

          </div>

        <?php endforeach; ?>

      </div>

    </div>
  </div>

</div>