<div class="container">

    <div class="row p-7" style="padding: 90px;"></div>
    <div class="row text-center shadow bg-white p-3" style="border-radius: 25px;">
        <?php if (isset($_SESSION['status']) && $_SESSION['status']  == 'verified' && !$twt_data['error']) : ?>
            <div class="col-12 mt-3 shadow border-radius-xl bg-white">
                <h3 class="text-dark"> Twitter Dashboard </h3>

                <p class="mt-3 text-success"> You have alraedy verified your account </p>
            </div>
        <?php endif; ?>


        <?php if (!$twt_data['success'] && !empty($twt_data['data'])) : ?>
            <div class="col-12 p-3">
                <h6 class="text-secondary"> Or you can signin using:</h6>
            </div>

            <div class="col-12">
                <a type="button" id="social_login" class="col-12 btn btn-info btn-sm text-white" style="border-radius: 12px; font-weight: bolder;"> <i class="fab fa-twitter"></i> &nbsp; Login using Twitter </a>
            </div>
        <?php endif; ?>

        <?php if ($twt_data['error'] && !empty($twt_data['data'])) : ?>
            <div class="col-12 p-3">
                <h6 class="text-danger"> <?= $twt_data['data'] ?> </h6>
            </div>
        <?php endif; ?>

    </div>

</div>

<script>
    $('#social_login').on('click', function() {

        var href_data = $(this).prop('href');
        var data = $('#loginForm').serialize()
        data = data + '&form_type=twitter_signin';

        postCheck('login_message', data, 0, true);

    });
</script>