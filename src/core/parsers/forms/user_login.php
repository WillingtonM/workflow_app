<form class="form-horizontal loginForm" method="POST" id="loginForm">
    <div class="reset_pass_text col-12 <?= (($is_login) ? 'hidden' : '') ?>">
        <h5 class="text-dark px-3"> Reset password </h5>
    </div>

    <div id="usernameDiv" class="form-floating mb-1">
        <input id="login_username" type="text" class="form-control shadow-none col-12" autocomplete="username" placeholder="Username" value="<?= ((isset($username) && !empty($username) && $data['success']) ? $username : '') ?>" aria-label="username-1" aria-describedby="username-1" <?= ((isset($username) && !empty($username) && $data['success']) ? 'disabled' : '') ?>>
        <label for="login_username">Username <?= ((isset($username) && !empty($username) && $data['success']) ? '' : 'or email') ?></label>
        <div id="loginUsernameFeedback" class="valid-feedback px-3">
            Invalid username or email
        </div>
        <input type="hidden" class="invalid_text" value="Invalid username">
    </div>

    <?php if (isset($user_text) && !empty($user_text)) : ?>
        <div class="mb-3" style="font-size: smaller; padding-left: 53px !important; text-align: left;"> <span style="padding-left: 0 !important; font-size: 1em"> <?= $user_text ?> </span> </div>
    <?php endif; ?>

    <div id="emailDiv" class="form-floating mb-1 has-validation <?= (($is_login) ? 'hidden' : '') ?>">
        <input id="login_email" type="email" class="form-control shadow-none" placeholder="Email" aria-label="email-1" aria-describedby="email-1" autocomplete="email">
        <label for="login_email">Email address</label>
        <div id="loginEmailFeedback" class="valid-feedback px-3">
            Invalid email address
        </div>
        <input type="hidden" class="invalid_text" value="Invalid email address">
    </div>

    <div id="passwordDiv" class="input-group mb-1 <?= (isset($data['success']) && $data['success'] == true) ? 'has-validation' : '' ?>">
        <div class="form-floating form-floating-group flex-grow-1">
            <input id="login_password" type="password" class="form-control shadow-none" style="border-radius: 12px 0 0 12px" autocomplete="current-password" placeholder="<?= ((isset($data['success']) && $data['success'] == true) ? 'New ' : '') ?>Password" aria-label="password-1" aria-describedby="password-1">
            <label for="login_password"><?= ((isset($username) && !empty($username) && $data['success']) ? 'New' : '') ?> Password</label>
        </div>
        <span id="password_span" class="input-group-text gul border-end" style="border-radius: 0 12px 12px 0 !important;" onclick="show_pwd('login_password', 'password_span')"> <i class="fas fa-eye mt-3"></i> </span>
        <section id="loginPasswordFeedback" class="valid-feedback px-3">
            Invalid password
        </section>
        <input type="hidden" class="invalid_text" value="Invalid password">
    </div>

    <div id="rememberDiv" class="form-check mt-2 <?= ((!$is_login) ? 'hidden' : '') ?>">
        <input id="remember_me" class="form-check-input" type="checkbox" value="" checked>
        <label class="form-check-label" for="remember_me">
            Remember me?
        </label>
    </div>

    <!-- Password reset -->
    <div id="passreset" class="form-group py-3 mb-3 <?= ((!$is_login) ? 'hidden' : '') ?>">
        <a type="button" id="passreset_btn" class="shadow-none float-right text-info" onclick="passReset()">
            <small id="resetText" class="text-dark font-weight-bold">Forgot your username or password ?</small>
        </a>
    </div>

    <div id="user_login_message" class="message mb-3">
        <div class="border-radius-lg py-1 <?= (((isset($data['message']) && !empty($data['message']))) ? 'alert alt_alert_warning' : '') ?>">
            <?= ((isset($data['message'])) ? $data['message'] : '') ?>
        </div>
    </div>

    <button id="login_btn" class="btn btn-dark shadow-none isLoggedBtn border-radius-lg w-100" type="button" <?= (isset($data['success']) && $data['success'] == true) ? 'disabled' : '' ?>>
        <span class="font-weight-bolder">
            <?= ($is_login && (isset($data['success']) && $data['success'] == true) ? 'Reset Password' : 'Login') ?>
        </span>
    </button>
</form>