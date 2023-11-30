<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="w-100 pt-3 px-1">
        <button type="button" class="btn btn-sm btn-secondary shadow-none article_nav article_active float-end/" onclick="requestModal(post_modal[1], 'mediaModal', {'type':'podcast'})"> <span class=""> <i class="fas fa-media-plus me-2"></i> Upload Media Podcast</span> </button>
    </div>
<?php endif; ?>
<!-- <hr> -->
<div class="col-12">
    <div class="row">

        <?php if (is_array($gall_qry) || is_object($gall_qry)) : ?>
            <?php foreach ($gall_qry as $value) : ?>
                <?php $media_date  = DateTime::createFromFormat('Y-m-d H:i:s', $value['media_publish_date']); ?>
                <div class="col-12 px-2 col-lg-6 mb-3 py-1  bg-white shadow" style="border-radius: 25px;">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <div id="media_error_<?= $value['media_id'] ?>" class=""></div>
                        <div class="row">
                            <h5 class="col-12 font-weight-bolder p-0 px-4 pt-2">
                                <a type="button" class="text-warning" onclick="requestModal(post_modal[1], 'mediaModal', {'media_id':<?= (int) $value['media_id'] ?>})">
                                    <?= $value['media_title'] ?>
                                </a>
                            </h5>
                            <div class="col-12 py-0 px-4">
                                <span class="fs-8">Published on: &nbsp; <small class="alt_dflt" style="padding-bottom: 5px; "><?= $media_date->format('F jS, Y') ?></small></span>
                                <?php if (!empty($value['media_url'])) : ?>
                                    <span class=""> <small> Source: &nbsp; <b><?= $value['media_url'] ?></b> </small> </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row card py-3 px-1 mx-0">
                            <div class="col-12 py-2 px-1" style="border-radius: 25px">
                                <div class="col-12" style="padding-top: 56.25%; height:fit-content">
                                    <?= $value['media_content'] ?>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row card shadow py-3 px-3 mx-1">
                            <div class="col-12 py-2 px-1 border-radius-xl">
                                <div class="col-12 border-none" style="padding-top: 56.25%; height:fit-content">
                                    <?= $value['media_content'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>