<!-- default inputs -->
<form id="loginFormInputs">
    <input id="logintype" type="hidden" name="logintype" value="<?= $is_login ?>">
    <input id="passresetInpt" type="hidden" name="passreset" value="false">

    <?php if (isset($data['success']) && $data['success'] == true) : ?>
        <input id="passresetConfirm" type="hidden" name="passreset_confirm" value="1">
        <input id="reset_code" type="hidden" name="reset_code" value="<?= $token ?>">
        <input id="user_type" type="hidden" name="user_type" value="<?= $user_type ?>">
        <input id="userkey" type="hidden" name="userkey" value="<?= $userkey ?>">
        <input id="user" type="hidden" name="user" value="<?= ((isset($user_id)) ? $user_id : '') ?>">
    <?php endif; ?>
</form>

<div class="reset_pass_text col-12  bg-light px-3 py-2">
    <h5 class="text-dark fs-5 font-weight-bolder"> <?= ($is_login && (isset($data['success']) && $data['success'] == true) ? 'Password Reset' : 'Login to your account') ?> </h5>
</div>

<?php require_once $config['PARSERS_PATH'] . 'forms' . DS . 'signin.php' ?>