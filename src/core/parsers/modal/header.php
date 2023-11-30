<!-- Modal -->
<div class="modal fade" id="<?= ((isset($modal_id) && !empty($modal_id)) ? $modal_id : '') ?>" <?= ((isset($modal_backdrop) && $modal_backdrop) ? 'data-bs-backdrop="static"' : '') ?> data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?= ((isset($modal_id) && !empty($modal_id)) ? $modal_id : '') ?>" aria-hidden="true">
    <div class="modal-dialog <?= ((isset($modal_size) && !empty($modal_size)) ? $modal_size : '') ?> <?= ((isset($modal_screen) && !empty($modal_screen)) ? $modal_screen : '') ?> <?= ((isset($modal_size) && !empty($modal_size)) ? $modal_size : '') ?> <?= ((isset($modal_centered) && !empty($modal_centered)) ? $modal_centered : '') ?> <?= ((isset($modal_scrollable) && !empty($modal_scrollable)) ? $modal_scrollable : '') ?>">
        <div class="modal-content p-0" style="border-radius: 30px">
            <div class="modal-header" style="border-bottom: none !important;">
                <span class="modal-title" style="font-weight: normal;">
                    <?= ((isset($modal_title) && !empty($modal_id)) ? $modal_title : '') ?>
                </span>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" <?php if (isset($cookie_action) && $cookie_action): ?> onclick="cookieAction('email_subscribe')" <?php else: ?>  onclick='closeModalByID("<?= ((isset($modal_id) && !empty($modal_id)) ? $modal_id : '') ?>", ""<?= ((isset($post_callback)) ? ', ' . true : '') ?><?= ((isset($post_callback) && !empty($post_callback)) ? ', ' . $post_callback : '') ?>)' <?php endif; ?>> </a>
            </div>
            <div id="modal-body" class="modal-body">