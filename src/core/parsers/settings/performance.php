<div class="row p-3 mb-5">
    
    <nav aria-label="breadcrumb mb-0">
        <ol class="breadcrumb bg-white px-0 shadow-none bg-none" style="border-radius: 15px">
            <li class="breadcrumb-item font-weight-bolder"><a class="def_text/" href="#">User Performance</a></li>
            <li class="breadcrumb-item font-weight-bolder" aria-current="page">Manage</li>
        </ol>
    </nav>
    <div class="col-12 p-0 mb-3">
        <div class="row">

            <?php if (is_array($usr_qry) || is_object($usr_qry)) : ?>
                <?php $count = 0 ?>
                <?php foreach ($usr_qry as $key => $usr) : ?>
                    <?php $image = (($usr != null) ? img_path(ABS_USER_PROFILE, $usr['user_image'], 1) : '') ?>
                    <?php $ful_name = $usr['name'] . ' ' . $usr['last_name'] ?>
                    <?php $usr_name = $usr['username'] ?>
                    <?php $usr_pstn = $usr['user_position'] ?>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="card">
                            <a class=""  type="button" onclick="requestModal(post_modal[11], post_modal[11], {'user':<?= $usr['user_id'] ?>})">
                                <img src="<?= $image ?>" class="card-img-top col-12" alt="...">
                                <div class="card-body p-2 bg-light" style="border-radius: 0 0 15px 15px">
                                    <p class="card-text/ text-center">
                                        <b class="text-dark"></b><?= $ful_name ?></b> 
                                        <!-- <small style="color: #777777;">@<?= $usr_name ?></small> -->
                                        <br>
                                        <span class="alt_dflt text-sm"> <?= $usr_pstn ?> <small>(<?= $usr['user_type'] ?>)</small> </span>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <?php $count++ ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        


    </div>


</div>