<div class="container">

    <div class="col-12">

        <div class="col">
            <form action="" method="GET">
                <input id="search_token" type="hidden" name="token" value="<?= get_token(); ?>">

                <div class="form-floating mb-2 has-validation">
                    <input class="form-control shadow-none" type="search" name="name" value="<?= (isset($_GET['name'])) ? $_GET['name'] : ''  ?>" placeholder="Search ..." aria-label="Search ..." aria-describedby="basic-addon2">
                    <label for="username">Search ...</label>
                    <div id="usernameFeedback" class="invalid-feedback ps-3 mt-0">
                        Invalid Search
                    </div>
                </div>
            </form>
        </div>

        <?php if ($req_res != null) : ?>
            <div class="row shadow-sm px-0 mb-3 bg-white rounded" style="border-radius: 15px !important;">
                <h5 class="col-12 alt_dflt mb-3 py-3 px-4"> Search results ...</h5>
                <?php $nwsf_qry = $req_res ?>
                <?php require $config['PARSERS_PATH'] . 'activities' . DS . 'history_table.php'; ?>
            </div>
        <?php else : ?>
            <div class="row shadow-sm px-0 mb-3 bg-white" style="border-radius: 25px !important;">
                
                    <?php require $config['PARSERS_PATH'] . 'activities' . DS . 'history_table.php'; ?>

                    <div class="row">
                        <!-- paggination -->
                        <?php if ($page_count > 1) : ?>
                            <div class="col-12">
                                <br><br>
                                <nav aria-label="Page navigation text-secondary text-center/">
                                    <ul class="pagination float-right">
                                        <li class="page-item">
                                            <a class="page-link text-secondary" href="?page=<?= (((int)$page_nmb - 1 <= 0) ? $page_nmb : $page_nmb - 1) ?>" <?= (($page_nmb - 1 <= 0) ? 'disabled' : '') ?> aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <?php for ($pg = 1; $pg <= $page_count; $pg++) : ?>
                                            <li class="page-item"><a class="page-link <?= (($pg == $page_nmb) ? 'text-danger' : 'text-secondary') ?>" href="?page=<?= $pg ?>"><?= $pg ?></a></li>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                            <a class="page-link text-secondary" href="?page=<?= (($page_nmb >= $page_count) ? $page_nmb : $page_nmb + 1) ?>" <?= (($page_nmb >= $page_count) ? 'disabled' : '') ?> aria-label="Next">
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
        <?php endif; ?>


        <div class="tab-content col-12" style="padding: 25px 0;">

                <div class="tab-pane fade <?= (((isset($_GET['tab']) && $_GET['tab'] == $key) || (!isset($_GET['tab']) && $array_count == 1)) ? 'show active' : '') ?>" id="pills-<?= $key ?>" role="tabpanel" aria-labelledby="pills-<?= $key ?>-tab">

                    
                        
                    </div>

        </div>

    </div>

</div>