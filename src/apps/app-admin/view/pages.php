<div class="container">

    <div class="row mt-3">
        <div class="col-12">
            <ul class="nav nav-tabs nav-justified" id="myTab" style="border: none;">
                <?php $tabbs_count = 0 ?>
                <?php foreach ($pages_nav as $key => $article) : ?>
                    <?php $tabbs_count++ ?>
                    <li class="shadow nav-item font-weight-bold article_nav m-1 <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'article_active' : '') ?>">
                        <a onclick="changeURL('<?= $key ?>')" class="nav-link <?= (((isset($_GET['tab']) && $_GET['tab'] ==  $key) || (!isset($_GET['tab']) && $tabbs_count == 1)) ? 'active' : '') ?>" id="<?= $key ?>-tab" data-toggle="tab" href="#<?= $key ?>" role="tab" aria-controls="<?= $key ?>" aria-selected="true">
                            <span style="font-weight: bolder;"> <i class="far fa-newspaper <?= $article['imgs'] ?>"></i> &nbsp; <?= $article['short'] ?> </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>


    <div class="row">

        <div class="tab-content col-12" style="padding: 25px 0;">

            <?php $array_count = 0 ?>
            <?php foreach ($pages_nav as $key => $article) : ?>
                <?php $array_count++; ?>
                <?php $page_name = $key; ?>

                <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">
                    <div class="row shadow p-3 mb-5 bg-white border-radius-xl/" style="border-radius: 15px;">
                        <?php if ($key == 'home') : ?>
                            <?php $req_res = get_page_content_by_name($page_name) ?>

                            <form id="article_form" class="col-12" action="">
                                <div class="col-auto">
                                    <div id="" class="">
                                        <textarea id="mytextarea" class="form-control" name="" rows="8" cols="100" value="" placeholder="Page Content" style="border-radius: none !important; width:100% !important"><?= ((isset($req_res['page_content'])) ? htmlspecialchars($req_res['page_content']) : '') ?></textarea>
                                    </div>
                                    <small class="text-muted col px-3">Page content</small>
                                </div>

                                <input type="hidden" name="page_name" value="home">
                            </form>

                            <div class="col-12 mb-5 px-4">
                                <div id="error_pop" class="error_pop mb-3"></div>
                                <button type="button" class="btn btn-sm btn-secondary px-3 shadow-none" style="border-radius: 11px;" onclick="modal_post()" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>Save changes</button>
                            </div>

                        <?php elseif ($key == 'contact') : ?>

                        <?php endif; ?>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    </div>
</div>