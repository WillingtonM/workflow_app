<div class="container">

    <div class="col-12">

        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                    <?php $tabbs_count = 0 ?>
                    <?php foreach ($user_activities as $key => $nav) : ?>
                        <?php $tabbs_count++ ?>
                        <li class="shadow nav-item font-weight-bold article_nav m-1 <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'article_active' : '') ?>">
                            <a get-variable="tab" data-name="<?= $key ?>" class="nav-link <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'active' : '') ?>" id="pills-<?= $key ?>-tab" data-bs-toggle="pill" href="#pills-<?= $key ?>" role="tab" aria-controls="pills-<?= $key ?>" aria-selected="<?= (((isset($_GET['tab']) && $_GET['tab'] == $key)  || empty($_GET['tab'])) ? 'true' : 'false') ?>">
                                <span class="border-weight-bolder"> <i class="<?= $nav['imgs'] ?>"> &nbsp; </i> <?= $nav['short'] ?> </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="tab-content col-12" style="padding: 25px 0;">

            <?php $array_count = 0; ?>
            <?php foreach ($user_activities as $key => $tabs) : ?>
                <?php $array_count++; ?>
                <?php $media = ($key == 'appearance') ? get_media_by_media_type($key) : null ?>
                <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">

                    <?php require $config['PARSERS_PATH'] . 'activities' . DS . $key .'.php'; ?>

                    <div class="row">
                        <!-- paggination -->
                        <?php if ($page_count > 1) : ?>
                            <div class="col-12">
                                <br><br>
                                <nav aria-label="Page navigation text-secondary text-center/">
                                    <ul class="pagination text-center/ float-right">
                                        <li class="page-item">
                                            <a class="page-link text-secondary" href="?tab=<?= $article_type ?>&page=<?= (((int)$page_nmb - 1 <= 0) ? $page_nmb : $page_nmb - 1) ?>" <?= (($page_nmb - 1 <= 0) ? 'disabled' : '') ?> aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <?php for ($pg = 1; $pg <= $page_count; $pg++) : ?>
                                            <li class="page-item"><a class="page-link <?= (($pg == $page_nmb) ? 'text-danger' : 'text-secondary') ?>" href="?tab=<?= $article_type ?>&page=<?= $pg ?>"><?= $pg ?></a></li>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <a class="page-link text-secondary" href="?tab=<?= $article_type ?>&page=<?= (($page_nmb >= $page_count) ? $page_nmb : $page_nmb + 1) ?>" <?= (($page_nmb >= $page_count) ? 'disabled' : '') ?> aria-label="Next">
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