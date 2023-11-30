<fieldset id="create_account_field" class="py-2">
    <!-- <h6 class="text-center font-weight-bolder">Create or request a demo account. <br> You can also <a href="mailto:<?= $_ENV['MAIL_MAIL'] ?>" class="text-warning">contatc us</a> </h6> -->
    <div class="form-floating mb-2 has-validation">
        <input id="create_name" type="text" name="name" value="<?= (isset($event)) ? $event['event_user_name'] : '' ?>" class="form-control shadow-none" autocomplete="name" placeholder="Name" required>
        <label for="create_name">Name</label>
        <div id="nameFeedback" class="invalid-feedback ps-3 mt-0">
            Invalid name format
        </div>
    </div>
    <div class="form-floating mb-2 has-validation">
        <input id="create_last_name" type="text" name="last_name" value="<?= (isset($event)) ? $event['event_last_name'] : '' ?>" class="form-control shadow-none" autocomplete="Last name" placeholder="Last name" required>
        <label for="create_last_name">Last name</label>
        <div id="lastnameFeedback" class="invalid-feedback ps-3 mt-0">
            Invalid last name format
        </div>
    </div>
    <div class="form-floating mb-2 has-validation">
        <input id="create_email" type="email" name="email" value="<?= (isset($event)) ? $event['event_user_email'] : '' ?>" class="form-control shadow-none" autocomplete="email" placeholder="Email" required>
        <label for="create_email">Email address</label>
        <div id="emailFeedback" class="invalid-feedback ps-3 mt-0">
            Invalid email address format
        </div>
    </div>
    <div class="form-floating mb-2 has-validation">
        <input id="create_contact" type="tel" name="contact" value="<?= (isset($event)) ? $event['event_user_phone'] : '' ?>" class="form-control shadow-none" autocomplete="tel" placeholder="Contact number" required>
        <label for="create_contact">Contact number</label>
        <div id="contactFeedback" class="invalid-feedback ps-3 mt-0">
            Invalid Contact number format
        </div>
    </div>
    <div class="form-floating mb-2 has-validation">
        <input id="company" type="text" name="company" value="<?= (isset($event)) ? $event['event_company_name'] : '' ?>" class="form-control shadow-none" autocomplete="company_name" placeholder="Company name" required>
        <label for="company">Company name</label>
        <div id="companyFeedback" class="invalid-feedback ps-3 mt-0">
            Invalid Company name format
        </div>
    </div>

    <div id="create_account_message" class="message mb-3"></div>

    <?php if(!isset($_SESSION['user_id'])): ?>
        <div class="form-group text-center mt-3 mb-1">
            <button id="create_account" class="btn btn-dark shadow-none isLoggedBtn border-radius-lg w-100" type="button">
                <span class="font-weight-bolder">
                    Create Account
                </span>
            </button>
        </div>
    <?php endif; ?>
</fieldset>