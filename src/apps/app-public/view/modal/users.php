<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
    <div class="col text-center">
        <img class="img text-center" src="<?= PROJECT_LOGO ?>" alt="<?= PROJECT_TITLE ?> Logo" width="150px" height="150px">
    </div>
    <div class="text-center my-3">
        <br>
        <small>Your username and email will be securely saved. You should use the same information for any future comments on this site.</small>
    </div>
    <div class="col-12 bg-light py-3 border-radius-lg">
        <form class="" id="loginFormUser" style="border-radius: 7px;">

            <div class="col-12">
                <div class="input-group mb-2">
                    <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-user input_color"></i></span>
                    <input type="text" class="form-control shadow-none" id="user_username" name="username" placeholder="Name" required>
                </div>
            </div>
            <div class="col-12">
                <div class="input-group mb-2">
                    <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-envelope input_color"></i></span>
                    <input type="email" class="form-control shadow-none" id="user_email" name="user_email" placeholder="Email" required>
                </div>
            </div>

            <div id="message_err" class="message mb-4"></div>


            <button id="submitFormUser" type="button" class="btn btn-secondary btn-sm col-12 border-radiusl-lg" onclick="postCheck('message_err', {'user_username': $('#user_username').val(), 'user_email': $('#user_email').val(), 'comment':$('#comment').val(), 'article': article_id});">Submit</button>
        </form>
    </div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>