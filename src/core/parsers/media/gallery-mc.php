<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="col-12 pt-3 px-1">
        <button type="button" class="btn btn-sm btn-secondary shadow-none article_nav article_active" onclick="requestModal(post_modal[4], 'galleryModal', {'type':'gallery-mc'})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <span class=""> <i class="fas fa-media-plus me-2"></i> Upload Gallery </span> </button>
    </div>
<?php endif; ?>

<div class="col-12">

    <?php if (is_array($gall_qry) || is_object($gall_qry)) : ?>
        <?php foreach ($gall_qry as $value) : ?>
            <?php $myDateTime   = DateTime::createFromFormat('Y-m-d H:i:s', $value['media_publish_date']); ?>
            <?php $img_dir = ABS_GALLERY . $value['media_image'] . DS ?>

            <div id="member_<?= $value['media_id'] ?>" class="row px-3 pt-3">
                <div class="col-12 pt-3 border-top border-dark">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <p class="m-0 p-0">
                            <a type="button" class="font-weight-bolder text-dark me-2" onclick="requestModal(post_modal[4], 'galleryModal', {'media_id':<?= $value['media_id'] ?>})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                                <?= $value['media_title'] ?>
                            </a>
                        </p>
                        <p class="m-0 p-0"> <small class="text-dark text-xxs"><?= $myDateTime->format('F jS, Y') ?></small> </p>
                        <p class="font-weight-bold text-dark text-sm"><?= $value['media_content'] ?></p>
                    <?php else : ?>
                        <p class="m-0 p-0">
                            <span class="font-weight-bolder text-light me-2"> <?= $value['media_title'] ?> </span> <small class="text-light text-xxs"><?= $myDateTime->format('F jS, Y') ?></small>
                        </p>
                        <p class="font-weight-bold text-light text-sm"><?= $value['media_content'] ?></p>
                    <?php endif; ?>

                </div>
                <div class="col-12">
                    <div class="row">
                        <?= global_imgs($img_dir, 'col-md-2', 6, 'sqaure', $value['media_image'], $value['media_id']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>