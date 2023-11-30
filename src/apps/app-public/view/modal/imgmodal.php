<div class="modal fade" id="<?= ((isset($modal_id) && !empty($modal_id)) ? $modal_id : '') ?>" <?= ((isset($modal_backdrop) && $modal_backdrop) ? 'data-bs-backdrop="static"' : '') ?> data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?= ((isset($modal_id) && !empty($modal_id)) ? $modal_id : '') ?>" aria-hidden="true">
  <div class="modal-dialog <?= ((isset($modal_size) && !empty($modal_size)) ? $modal_size : '') ?> <?= ((isset($modal_screen) && !empty($modal_screen)) ? $modal_screen : '') ?> <?= ((isset($modal_size) && !empty($modal_size)) ? $modal_size : '') ?> <?= ((isset($modal_centered) && !empty($modal_centered)) ? $modal_centered : '') ?> <?= ((isset($modal_scrollable) && !empty($modal_scrollable)) ? $modal_scrollable : '') ?>">
    <div class="modal-content bg-dark/" style="background: rgb(0, 0, 0, .5);">
      <div class="modal-header p-0 m-0" style="border-bottom: none !important;">
        <a class="btn-close float-end pe-5 pt-3" style="z-index: 10000;" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalByID('<?= ((isset($modal_id) && !empty($modal_id)) ? $modal_id : '') ?>')"> </a>
      </div>
      <div class="modal-body my-0 p-0 ">

        <div id="product_carousel" class="carousel carousel-fade slide p-0" data-bs-touch="false" data-bs-interval="false" data-wrap="false">
          <div class="carousel-inner text-center border/ w-100">
            <?= $img_output ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#product_carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#product_carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>



      </div> <!-- end of modal-body -->

      <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> -->
    </div>
  </div>
</div>