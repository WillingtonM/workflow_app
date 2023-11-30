<?php $user_side = get_user_by_id($_SESSION['user_id']); ?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main" data-color="dark">
    <div class="sidenav-header/">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>

        <div class="col py-0 px-3">
            <div class="col shadow border-radius-md text-center p-1">
                <a href="./" class="border-radius-md/">
                    <img src="<?= img_path(ABS_USER_PROFILE, $user_side['user_image'], 1) ?>" class="" alt="main_logo" style="width: 70px; height: 70px !important; padding: 1px; border-radius: 50%">
                </a>
            </div>
        </div>
        <div class="ms-1 text-center p-2">
            <span class="col font-weight-bold"> <?= $user_side['name'] ?></span>
            <small> @<?= $user_side['username'] ?> </small>
        </div>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto max-height-vh-100 h-100/" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= (($page == 'home') ? 'active' : '') ?>" href="./">
                    <div class=" icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span>
                            <i class="fas fa-home <?= (($page == 'home') ? 'white' : 'dark-col-custom') ?>" width="12px" height="12px" style="width: 22px; height: 22px;"></i>
                        </span>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <?php foreach ($admin_pages as $key => $admin_page) : ?>
                <?php if(isset($admin_links) && in_array($admin_page['link'], $admin_links) && !$is_admin ): continue; endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?= (($page == $key) ? 'active' : '') ?>" href="./<?= $admin_page['link'] ?>">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <span>
                                <i class="<?= $admin_page['imgs'] ?> <?= (($page == $key) ? 'white' : 'dark-col-custom') ?>" style="width: 22px; height: 22px;"></i>
                            </span>
                        </div>
                        <span class="nav-link-text ms-1"><?= $admin_page['short'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>

            <li class="nav-item">
                <a class="nav-link <?= (($page == 'logout') ? 'active' : '') ?>" href="./logout">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span>
                            <i class="fa-solid fa-power-off text-danger" style="width: 22px; height: 22px;"></i>
                        </span>
                    </div>
                    <span class="nav-link-text ms-1 text-danger font-weight-bolder">LOGOUT</span>
                </a>
            </li>

        </ul>
    </div>

    <div class="sidenav-footer mx-3 ">

    </div>
</aside>