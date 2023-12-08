<?php require_once $config['PARSERS_PATH'] . 'settings' . DS . 'logo_div.php' ?>

<div class="row">
  <div class="col-12">

    <div class="page-header min-height-300 my-4  wait-1s" data-animation="animated slideInDown" style="border-radius: 35px;">
        <?php require $config['PARSERS_PATH'] . 'home' . DS . 'login_head.php' ?>
    </div>

    <div class="mx-4 mt-n6 text-center">
        <div class="row">

            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php $c_count = 0 ?>
                    <?php foreach ($login_carousel as $carousel_key => $carousel) : ?>
                        <div class="carousel-item px-1 <?= ($c_count == 0) ? 'active' : '' ?>">
                            <div class="row">
                                <?php $count = 0 ?>
                                <?php foreach ($carousel as $home_key => $item) : ?>
                                    <?php $count ++ ?>
                                    <div id="" class="col-12 col-sm-6 p-3 h-200 hover_inimate">
                                        <div class="card shadow-lg card-blog/ bg-white text-center wait-<?= $count ?>s" data-animation="animated <?= $item['anim'] ?>" style="border-radius: 35px 35px 20px 20px;">
                                            <div class="position-relative">
                                                <a class="d-block">
                                                    <img src="<?= ABS_SERVICE .'rect' . DS . $item['page'] ?>" alt="data" class="img-fluid" style="border-radius: 35px 35px 0 0; ">
                                                </a>
                                            </div>
                                            <div class="card-body p-3">
                                                <p class="text-gradient text-dark mb-2 text-sm">
                                                    <span class="font-weight-bolder fs-6"> <?= $item['name'] ?> </span> <br>
                                                    <hr class="horizontal dark my-1">

                                                    <small class=""> <?= $item['long'] ?> </small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php $c_count ++ ?>
                    <?php endforeach; ?>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>
    </div>  

  </div>
</div>