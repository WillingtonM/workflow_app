<div class="col-12 col-sm-6 col-md-4 article_container mb-2" style="padding: 5px !important;">
    <div id="article_<?= $artcle_cnt ?>" class="media_div/ shadow article_contents artclt_bg2" style="padding: 17px 5px; border-radius: 25px; ">
        <a class="text-center col-12" style="padding: 0;" href="<?= $article_link ?>">
            <img class="img-thumbnail img-responsive/" src="<?= article_img($value['article_type'], $value['article_image'], 2) ?>" alt="<?= $value['article_title'] ?>" style="max-height: 229px; border: 1px solid #efefef; border-radius: 15px; display: block; margin: 0 auto;">
        </a>
        <div class="col-12" style="padding-top: 15px;">
            <div class="px-2 text-center">
                <h5 class="mt-0 mb-0 p-0">
                    <a class="text-dark font-weight-bolder" href="<?= $article_link ?>">
                        <?= $value['article_title'] ?>
                    </a>
                </h5>
                <?php if (!empty($value['article_publisher']) && !empty($value['article_publisher'])) : ?>
                    <span class="text-muted text-xs"> First Published by <?= (isset($value['article_link']) && check_url($value['article_link'])) ? '<a href="' . $value['article_link'] . '" target="_blank" class="text-info"><b>' . $value['article_publisher'] . '</b></a>' : $value['article_publisher'] ?> on &nbsp; </span>
                <?php elseif (!empty($value['article_type']) && $value['article_type'] == 'business_day') : ?>
                    <span class="text-muted text-xs"> <?= ($value['article_type'] == 'business_day') ? 'First Published by ' . ((!empty($value['article_link']) && check_url($value['article_link'])) ? '<a href="' . $value['article_link'] . '" target="_blank" class="text-info"><b>Business Day</b></a>' : '<b>Business Day</b>') . ' on' : 'Published on' ?> , </span>
                <?php else : ?>
                    <span class="text-muted text-xs"> Published on &nbsp; </span>
                <?php endif; ?>

                <?php if (!empty($value['article_link']) && check_url($value['article_link'])) : ?>
                    <a href="<?= $value['article_link'] ?>" target="_blank" class="text-info text-xs"><?= $artcl_date->format('F jS, Y') ?></a>
                <?php else : ?>
                    <span class="text-warning text-xs"> <?= $artcl_date->format('F jS, Y') ?></span>
                <?php endif; ?>
            </div>
            <div class="article_content hidden text-center" style="padding-top: 5px; overflow: hidden">
                <p style="font-size: .95rem;"><?= nl2br(short_paragrapth(strip_tags($value['article_content']), 2500)) ?>... </p>
                <a class="text-info text-xs font-weight-bolder" href="<?= $article_link ?>">Read More ... </a>
            </div>
        </div>
    </div>
</div>