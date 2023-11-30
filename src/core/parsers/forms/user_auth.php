<?php if (isset($_SESSION['active_otp'])) : ?>
    <form class="form-horizontal" method="POST" id="loginAuthForm">
        <input type="hidden" name="form_type" value="form_user_login_otp">
        <label for="login_auth"> One Time Pin (OTP) </label>
        <div class="input-group mb-3 auth_inputs">
            <input type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="otp_1" id="otp_1" class="form-control" aria-label="OTP" onkeyup="next_input_focus(this, 'otp_2')">
            <input type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="otp_2" id="otp_2" class="form-control" aria-label="OTP" onkeyup="next_input_focus(this, 'otp_3')">
            <input type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="otp_3" id="otp_3" class="form-control" aria-label="OTP" onkeyup="next_input_focus(this, 'otp_4')">
            <input type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="otp_4" id="otp_4" class="form-control" aria-label="OTP" onkeyup="next_input_focus(this, 'otp_5')">
            <input type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="otp_5" id="otp_5" class="form-control" aria-label="OTP" onkeyup="next_input_focus(this, 'otp_6')">
            <input type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="otp_6" id="otp_6" class="form-control" aria-label="OTP" style="border-radius: 0 12px 12px 0 !important;">
        </div>

        <div id="user_login_auth_message" class="message mb-3">
            <div class="border-radius-lg py-1"> </div>
        </div>

        <div class="text-center w-100">
            <button id="login_auth_resend" class="btn btn-white border border-3 p-2/ border-dark shadow-none isLoggedBtn border-radius-lg me-2" type="button" onclick="postCheck('user_login_auth_message', {'form_type':'login_otp_auth_resend'}, 11)">
                <span class="font-weight-bolder"> Resend OTP </span>
            </button>

            <button id="login_auth_btn" class="btn btn-dark shadow-none isLoggedBtn border-radius-lg w-100/" type="button" onclick="postCheck('user_login_auth_message', $('#loginAuthForm').serialize(), 11, true)">
                <span class="font-weight-bolder"> Confirm OTP </span>
            </button>
        </div>
    </form>
<?php endif; ?>