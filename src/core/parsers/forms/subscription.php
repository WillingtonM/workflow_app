<div class="col-12">
    <div class="input-group mb-2">
        <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-user input_color"></i></span>
        <input type="text" class="form-control shadow-none" id="subscribe_name" name="name" placeholder="Name" value="<?= ((isset($user) && $user != null) ? $user['subscription_name'] : '') ?>" required>
    </div>
</div>
<div class="col-12">
    <div class="input-group mb-2">
        <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-user input_color"></i></span>
        <input type="text" class="form-control shadow-none" id="subscribe_last_name" name="last_name" placeholder="Last Name" value="<?= ((isset($user) && $user != null) ? $user['subscription_name'] : '') ?>" required>
    </div>
</div>
<div class="col-12">
    <div class="input-group mb-2">
        <span class="input-group-text text-warning" style="border-right: none;"><i class="fa fa-envelope input_color"></i></span>
        <input type="email" class="form-control shadow-none" id="signup_email" name="signup_email" placeholder="Email" value="<?= ((isset($user) && $user != null) ? $user['subscription_email'] : '') ?>" required>
    </div>
</div>

<div id="subscription_message_" class="my-3"></div>

<button type="button" class="btn btn-secondary col-12 shadow-none" onclick="postCheck('subscription_message_', $('#signup_form').serialize(), 0, true); cookieAction('email_subscribe', false);" style="border-radius: 12px; font-weight: bolder">
    <span>Subscribe</span>
</button>

<?php if (isset($_SESSION['admin_id'])) : ?>
    <input type="hidden" name="subscription_id" id="subscription_id" value="<?= ((isset($user) && $user != null) ? $user['subscription_id'] : '') ?>">
<?php endif; ?>