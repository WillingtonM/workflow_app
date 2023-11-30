<fieldset id="create_username_field">
    <div class="form-floating mb-3 has-validation">
        <input id="create_username" type="text" class="form-control shadow-none" aria-describedby="usernameFeedback" autocomplete=" off" placeholder="Username" aria-label="username-1" aria-describedby="username-1" required>
        <label for="username">Username</label>
        <div id="usernameFeedback" class="valid-feedback px-3">
            Invalid username
        </div>
    </div>
</fieldset>

<div id="create_username_message" class="message mb-3"></div>

<div class="form-group mt-3 mb-1">
    <div class="w-100 p-0 m-0">
        <button type="button" class="btn btn-danger shadow-none isLoggedBtn border-radius-lg" id="pills-account-tab" onclick="changeURL('account', 'mtab'); nav_activate('pills-tab-account', 'account', 'active','signup_tab');" data-toggle="pill" href="#pills-account" role="tab" aria-controls="pills-account" aria-selected="true">
            <i class="fa-solid fa-circle-arrow-left me-2"></i>
            <span id="" class="font-weight-bolder">
                Back
            </span>
        </button>
        <button class="btn btn-dark shadow-none isLoggedBtn border-radius-lg" type="button" id="create_username_btn" disabled>
            <span id="" class="font-weight-bolder">
                Create username
            </span>
        </button>
    </div>
</div>