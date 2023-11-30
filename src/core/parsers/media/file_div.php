<div id="member_<?= $value['media_id'] ?>" class="col-12 col-sm-6 col-md-4 article_container my-1 p-1">
    <div class="shadow gallery_contents artclt_bg2 p-2 border-radius-xl">
        <h5 class="col-12">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a class="doc_anchor text-secondary mb-3 cursor-pointer" onclick="requestModal(post_modal[12], 'fileModal', {'media_id':<?= $value['media_id'] ?>})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                    <i class="me-2 fa <?= $fl_ext . ' ' . $text_colr ?> " aria-hidden="true"></i> <?= $value['media_title'] ?>
                </a>
            <?php else : ?>
                <a class="doc_anchor text-secondary mb-3" href="<?= ABS_FILES . $value['media_image'] ?>">
                    <i class="me-2 fa <?= $fl_ext . ' ' . $text_colr ?> " aria-hidden="true"></i> <?= $value['media_title'] ?>
                </a>
            <?php endif; ?>
            <embed src="<?= ABS_FILES . $value['media_image'] ?>#page=1&zoom=25" class="mt-2" width="575" height="500" style="width: 100%; max-height: 300px; overflow-y: hidden !important; overflow: hidden;">
        </h5>
    </div>
</div>