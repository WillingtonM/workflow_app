<div class="container">
    <div class="row">
        <div class="col-12 shadow border-radius-xl bg-white p-4" style="border-radius: 30px">
            <h3 class="text-dark"> <i class="fas fa-columns me-3"></i> Dashboard </h3>
            <hr class="horizontal dark mt-0">

            <div class="row">
                <?php foreach ($system_pages as $page_key => $a_page) : ?>
                    <div class="col-12 col-md-3 p-2">
                        <div class="card shadow-sm border-radius-xl" style="border-radius: 25px">
                            <div class="card-body/ text-center">
                                <h5 class="card-title alert-light/ btn-dark border-radius-lg p-3 text-warning" style="border-radius: 25px 25px 0 0"> <a href="<?= $page_key ?>" class="text-white"> <i class="me-2 <?= $a_page['imgs'] ?>"></i> <?= $a_page['short'] ?> </a> </h5>
                                <p class="text-dark px-3 fs-6"> <?= $a_page['long'] ?> </p>
                                <!-- <hr class="horizontal dark mt-0"> -->
                                <!-- <a href="<?= $page_key ?>" class="card-link"> Visit Page </a> -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
</div>