<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
    <div class="col-12 mt-3">
        <div class="text-center py-3">
            <h3 class="text-secondary" style="font-weight: bolder;"> Newsletter Subscription </h3>
            <small class="m-0 alt2_color"> Please subscribe below to receive weekly insight on economic policy. </small>
        </div>
    </div>
    <br>
    <div class="col-12 p-3 shaow border-radius-xl bg-light mb-3">
        <form id="signup_form" class="" action="index.html" method="post" style="padding-top: 0; margin-top: 0;">


                <?php require_once $config['PARSERS_PATH'] . 'forms' . DS . 'subscription.php' ?>


        </form>
    </div>

    <div class="col-12">
        <div class="text-center social_med float-right bg-light p-3 border-radius-xl mb-3">
            <p class="p-0"> Follow me on social media </p>
            <?php foreach ($social_media as $key => $social) : ?>
                <a class="nav-link/" href="<?= $social['link'] ?>" target="_blank"><i style="color: #555 !important;" class="<?= $social['font'] ?> fa-2x"></i></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>


<script>
    $('.nav-modal').on('click', function() {
        change_bg()
    });
</script>