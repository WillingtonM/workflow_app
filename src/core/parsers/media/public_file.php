<div id="reg_file" class="col-12 article_container my-1 p-3">
    <div class="shadow gallery_contents artclt_bg2 p-2 border-radius-xl p-3">
        <h5 class="col-12">
            <a class="doc_anchor text-secondary me-2" href="<?= ABS_DOCS . $value['media_image'] ?>" style="padding-bottom: 15px !important;">
                <i class="fa-solid fa-folder me-2"></i> <?= $value['media_title'] ?>
            </a>
            <embed src="<?= ABS_DOCS . $value['media_image'] ?>#page=1&zoom=75" width="575" height="500" style="width: 100%; max-height: 300px; overflow-y: hidden !important; overflow: hidden;">
        </h5>

    </div>
</div>