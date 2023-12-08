<div class="min-vh-100">  
  
  <div id="services_div" class="container pt-10">
    
       <div class="page-pricing page-header min-height-300/ border-radius-xl/ my-4 wait-2s" data-animation="animated pulse" style="border-radius: 35px;">
           <span class="mask" style="background-color: rgb(41, 55, 75, .5); ">
               <div class="p-0">
                   <div class="text-center py-3 pt-5">
                       <h3 class="font-weight-bolder text-white"> <span class="me-2"> <?= PROJECT_TITLE ?> </span> <i class="me-2 text-warning"> features </i></h3>

                       <small class="m-0 text-light fs-6">
                            <?= PROJECT_TITLE ?> is a powerful and intuitive task management platform designed specifically for teams and companies. <br>
                            It provides a centralized platform to manage deceased estate administrations, conveyancing, marriage contracts, notary services, and wills etc.
                            <br> <br>
                            <span class="font-weight-bolder"><?= PROJECT_TITLE ?> offers the following key features:</span>
                       </small>
                   </div>
               </div>
           </span>
       </div>
    </div>
    
    <div class="container-fluid bg-white p-3 py-5 mb-5">
        <div class="container">

            <div class="d-flex align-items-start row">
                <div class="col-12 col-lg-3" id="pills-tab">
                    <ul class="nav nav-pills border bg-dark py-3" id="pills-tab" style="border-radius: 25px" role="tablist" aria-orientation="vertical">
                        <?php $tabbs_count = 0 ?>
                        <?php foreach ($serviceopt_array as $key => $nav) : ?>
                            <?php $tabbs_count++ ?>
                            <li class="service_nav nav-item font-weight-bolder article_nav/ m-1 <?= ($tabbs_count == 1) ? 'article_active/' : '' ?>">
                                <a get-variable="tab" data-name="<?= $key ?>" class="nav-link <?= ($tabbs_count == 1) ? 'active' : '' ?>" id="v-pills-<?= $key ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?= $key ?>" type="button" role="tab" aria-controls="v-pills-<?= $key ?>" aria-selected="<?= ($tabbs_count == 1) ? 'active' : '' ?>">
                                    <span class="border-weight-bolder"> <i class="me-2 <?= $nav['font'] ?>"></i> <?= $nav['short'] ?> </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="tab-content col-12 col-lg-9" id="pills-tabContent">
                    <?php $cnt = 0 ?>
                    <?php foreach ($serviceopt_array as $home_key => $opt_val) : ?>
                        <?php $cnt ++ ?>
                        <div class="tab-pane fade <?= ($cnt == 1) ? 'show active' : '' ?>" id="v-pills-<?= $home_key ?>" role="tabpanel" aria-labelledby="v-pills-<?= $home_key ?>-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-6 wait-1s" data-animation="animated bounceIn">
                                    <h3 class="font-weight-bolder py-2 font-weight-bolder mb-3">
                                        <span class="text-warning"><?= $opt_val['short'] ?></span>
                                    </h3>
                                    <p class="text-dark fs-5">
                                        <?php require_once $config['PARSERS_PATH'] . 'services' . DS . $home_key . '.php' ?>
                                    </p>
                                </div>

                                <div class="col-lg-6 d-none d-lg-block <?= $opt_val['clas'] ?> mb-3 wait-<?= $opt_val['wait'] ?>s" data-animation="animated <?= $opt_val['anim'] ?>" style="z-index: 10 !important;">
                                    <div class="mt-3 py-4"></div>
                                    <img src="<?= img_path(ABS_SERVICE, $opt_val['page'] .'.jpg', '')   ?>" alt="data" class="img-fluid" style="border-radius: 5px; ">
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-md-8 col-lg-6 mt-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6 px-2">
                                                    <button type="button" class="btn btn-dark col-12 border-radius-lg" style="border-radius: 12px;" onclick="requestModal(post_modal[9], post_modal[9], {})">Pricing Enquiry</button>
                                                </div>
                                                <div class="col-12 col-md-6 px-2">
                                                    <button type="button" class="btn btn-warning col-12 border-radius-lg" style="border-radius: 12px;" onclick="requestModal(post_modal[0], post_modal[0], {})">Register a new Account</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-12 col-md-2 col-lg-3"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
            <div class="row">
                    
            </div>
        </div>

   </div>
</div>