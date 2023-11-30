<div style="z-index: 12;" class="col-12 col-sm-4 col-md-4 p-2 h-200 wait-<?= $home_val['wait'] ?>s" data-animation="animated <?= $home_val['anim'] ?>">
    <div class="card_work_home p-0">
        <div class="text-center w-100 home_card p-3">
            <a class="w-100 text-center p-3 text-warning" href="<?= $home_val['link'] ?>">
                <i class="<?= $home_val['font'] ?> fa-2x p-2"></i>
            </a>
        </div>
        <div class="card-body p-3 bg-dark/">
            <p class="text-warning mb-2 text-sm">
                <span class="font-weight-bolder fs-5 text-warning">
                    <?= $home_val['short'] ?>
                </span> <br> <br>
                <small class="">
                    <!-- <?= $home_val['long'] ?> -->
                </small>
            </p>
            <button onclick="javascript:location.href='<?= $home_val['link'] ?>'" class="btn btn-outline-dark/ btn-light btn-sm mb-0 border-radius-lg text-sm text-dark border-radius-xl cursor-pointer">
                Learn more ... 
            </button>
        </div>
    </div>
</div>