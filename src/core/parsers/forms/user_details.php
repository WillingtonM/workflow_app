<fieldset id="create_details_field">
    <div class="form-floating mb-1 has-validation">
        <input type="text" class="form-control shadow-none" id="profile_name" name="profile_name" value="<?= ((isset($user)) ? $user['profile_name'] : '') ?>" placeholder="Profile Name" required>
        <label for="profile_name">Public Profile Name</label>
        <div id="profileFeedback" class="valid-feedback">
            <span>Invalid profile name</span>
        </div>
        <input type="hidden" class="invalid_text" value="Invalid profile name">
    </div>

    <div class="form-floating mb-1 has-validation">
        <input type="text" class="form-control shadow-none" id="name" name="name" value="<?= ((isset($user)) ? $user['name'] : '') ?>" placeholder="Name">
        <label for="name">Name</label>
        <div id="nameFeedback" class="valid-feedback">
            <span>Invalid name</span>
        </div>
        <input type="hidden" class="invalid_text" value="Invalid name">
    </div>

    <div class="form-floating mb-1 has-validation">
        <input type="text" class="form-control shadow-none" id="last_name" name="last_name" value="<?= ((isset($user)) ? $user['last_name'] : '') ?>" placeholder="Last Name">
        <label for="last_name">Last Name</label>
        <div id="lastnameFeedback" class="valid-feedback">
            <span>Invalid last name</span>
        </div>
        <input type="hidden" class="invalid_text" value="Invalid last name">
    </div>

    <?php $phone_code   = (isset($user['mobile_country_code'])) ? $user['mobile_country_code'] : '' ?>
    <?php $country      = get_countries_by_phonecode($phone_code) ?>
    <?php $country_code = ($country) ? $country['name'] . ' (' . $country['phonecode'] . ')' : '' ?>

    <div id="websiteDiv" class="input-group mb-2">
        <span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-phone"></i> </b> </span>
        <div class="form-floating form-floating-group flex-grow-1">
            <input id="country_code_input" name="country_code" list="country_code" class="special_form form-control shadow-none" placeholder="Country code" value="<?= (isset($country_code)) ? $country_code : '' ?>">
            <datalist id="country_code">
                <option data-value="" data-id="" id="default_country_code"></option>
            </datalist>
            <label for="country_code_input">Country code</label>
        </div>
        <div class="form-floating form-floating-group flex-grow-1">
            <input type="tel" class="special_form form-control shadow-none" id="contact_number" name="contact_number" autocomplete="tel" value="<?= ((isset($user)) ? $user['user_contact'] : '') ?>" placeholder="Mobile number" style="border-radius: 0 12px 12px 0;">
            <label for="contact_number">Mobile number</label>
        </div>
        <div id="contactFeedback" class="valid-feedback">
            Invalid mobile number
        </div>
        <input type="hidden" class="invalid_text" value="Invalid mobile number">
        <input type="hidden" id="country_code_check" value="">
    </div>

    <label for="" class="px-2 text-secondary">Date of birth</label>
    <div class="input-group mb-2">

        <span class="input-group-text"> <i class="fas fa-calendar-day"></i> </span>
        <?php $date_days = range(1, 31, 1) ?>
        <select class="form-control shadow-none" name="dob" id="account_dob">
            <?php foreach ($date_days as $value) : ?>
                <option value="<?= $value ?>" <?= ((isset($user['birth_date']) && (int) date('d', strtotime($user['birth_date'])) == $value) ? 'selected' : ((!isset($user['birth_date']) && empty($user['birth_date']) && $value == (int)date('d')) ? 'selected' : '')) ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>

        <select class="form-control shadow-none" name="mob" id="account_mob">
            <?php foreach ($date_months as $key => $month) : ?>
                <option value="<?= $key ?>" <?= ((isset($user['birth_date']) && (int) date('m', strtotime($user['birth_date'])) == $key) ? 'selected' : ((!isset($user['birth_date']) && empty($user['birth_date']) && $key == (int)date("m")) ? 'selected' : '')) ?>><?= $month ?></option>
            <?php endforeach; ?>
        </select>

        <?php $date_days = range(date("Y"), 1900, -1) ?>
        <select class="form-control shadow-none" name="yob" id="account_yob">
            <?php foreach ($date_days as $value) : ?>
                <option value="<?= $value ?>" <?= ((isset($user['birth_date']) && (int) date('Y', strtotime($user['birth_date'])) == $value) ? 'selected' : ((!isset($user['birth_date']) && empty($user['birth_date']) && $value == date("Y")) ? 'selected' : '')) ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-row mb-3 px-2">
        <div class="col-12" id="gender">
            <label for="gender" class="text-secondary">Gender</label> <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderM" value="M" <?= ((isset($user['gender']) && $user['gender'] == "M") ? "checked" : '') ?>>
                <label class="form-check-label" for="genderM">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="genderF" value="F" <?= ((isset($user['gender']) && $user['gender'] == "F") ? "checked" : '') ?>>
                <label class="form-check-label" for="genderF">Female</label>
            </div>

        </div>
    </div>
    <?php $city_country = (isset($user['country']) && isset($user['location'])) ? $user['location'] . '/' . $user['country'] : '' ?>
    <div class="form-floating mb-3">
        <input id="country_city_input" name="country_city" list="country_city" class="form-control shadow-none col-12" placeholder="Location (City/Country)" value="<?= $city_country ?>">
        <datalist id="country_city">
            <option data-value="" data-id="" id="default_city_country"></option>
        </datalist>
        <label for="email">Location (City/Country)</label>
    </div>
</fieldset>

<div id="complete_account_message" class="message mb-3"></div>

<?php if ($page == 'login') : ?>
    <div class="form-group mt-3 mb-1">
        <div class="w-100 p-0 m-0">
            <button type="button" class="btn btn-danger shadow-none isLoggedBtn border-radius-lg" id="pills-username-tab" onclick="changeURL('username', 'mtab'); nav_activate('pills-tab-username', 'username', 'active','signup_tab');" data-toggle="pill" href="#pills-username" role="tab" aria-controls="pills-username" aria-selected="true">
                <i class="fa-solid fa-circle-arrow-left me-2"></i>
                <span class="font-weight-bolder"> Back </span>
            </button>
            <button class="btn btn-dark shadow-none isLoggedBtn border-radius-lg" type="button" id="complete_account" disabled>
                <span class="font-weight-bolder"> Create Account </span>
            </button>

        </div>
    </div>
<?php endif; ?>