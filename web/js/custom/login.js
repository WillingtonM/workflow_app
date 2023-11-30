// "use strict"; 
// Post functions **************************************************************

function passResetPost() {
  var err_attr_id = 'user_login_message';
  var data = {
    'form_type': 'passreset_confirm',
    'login_form': false,
    'reset_code': $('#reset_code').val(),
    'username': $('#login_username').val(),
    'password': $('#login_password').val(),
    'userkey': $('#userkey').val(),
    'user_type': $('#user_type').val(),
    'merchant': $('#merchant').val(),
    'user': $('#user').val()
  };

  
  postCheck(err_attr_id, data, 0);
}

function passResetEmail(email) {
  var err = '';

  if (email != '') {
    if (validate_email(email)) {
      data = {
        'form_type': 'passreset',
        'email': email
      };
      postCheck('login_message', data, 0);
    } else {
      err = "Invalid email, please enter valid email";
    }
  } else {
    err = "Email is blank, please provide valid email";
  }

  if (err != '') {
    $('#login_message').html(alert_msg(err));
  } else {// $('.message').html('');
  }
} // General login functions *****************************************************


function passReset() {
  var msg = "Provide your account email";
  $('#user_login_message').html('');

  if ($('#emailDiv').hasClass('hidden')) {
    $('#emailDiv').removeClass('hidden');
    $('#usernameDiv').toggle();
    $('#rememberDiv').toggle();
    $('#passwordDiv').toggle();
    $('#resetText').text('Cancel password reset').addClass('p-2 text-danger').removeClass('text-dark');
    $('#login_btn span').text('Request password reset');
    $('#passresetInpt').val(true);
  } else {
    $('#emailDiv').addClass('hidden');
    $('#usernameDiv').toggle();
    $('#rememberDiv').toggle();
    $('#passwordDiv').toggle();
    $('#resetText').text('Forgot your username or password ?').removeClass('p-2 text-danger').addClass('text-dark');
    $('#login_btn span').text('Login');
    $('#passresetInpt').val(false);
  }

  $('.reset_pass_text').toggle();
} // on enter bind
// OTP auth inputs

function next_input_focus(first, last) {
  if (first.value.length) {
    document.getElementById(last).focus();
  }
}

$('.loginForm').bind('keypress', function (e) {
  if (e.which == 13) {
    e.preventDefault;
    var tab_exists = '.tab-content>.tab-pane.active .loginForm';

    if ($(tab_exists).length > 0) {
      $(tab_exists + ' .isLoggedBtn').trigger('click');
    } else {
      $('.isLoggedBtn').trigger('click');
    }
  }
}); // create account tabs

$('.progress_ball').on('click', function () {
  var curr_li = $(this).prop('id');
  $('.step').removeClass('active');
  $('.progress_text').removeClass('text-dark');
  $('#' + curr_li + ' span').addClass('active');
  $('#' + curr_li + ' h6').addClass('text-dark');
}); // username cookie

var user_cookie = getCookie('username') == null ? '' : getCookie('username'); // console.log(user_cookie); 
// get user city location
// $.cookie('user_locale', null);

var locale_cookie = getCookie('user_locale') == null ? '' : getCookie('user_locale'); // create account ************************************

var user_locale_code = getCookie('user_locale_code') == null ? '' : getCookie('user_locale_code'); // create account ************************************

$(function () {
  if (current_page.length > 0 && $('#country_code').length > 0) {
    if (user_locale_code == null || user_locale_code == '') {
      $.get('http://ipinfo.io?token=0c3f695c621376', function (e) {
        var user_location = e;
        var current_country = user_location.country;
        var code_data = {
          'form_type': 'country_phone_code',
          'country': current_country
        };
        postCheck('null', code_data, 0);
        var phone_code = $('#country_code_check').val();
        var code_country = country_name_codes[current_country] + ' (' + phone_code + ')';
        var user_locale_code = {
          "code": phone_code,
          "country": current_country
        };
        user_locale_code = JSON.stringify(user_locale_code);
        setCookie('user_locale_code', user_locale_code);

        if ($('#country_code').length > 0 && phone_code != '' && current_country != '' && $('#country_code_input').val() == '') {
          $('#country_code > option').html(code_country);
          $('#country_code > option').attr('data-value', user_locale_code);
          $('#country_code_input').attr('value', code_country);
        }
      }, "jsonp");
    } else {
      var locale_data = is_json_string(user_locale_code) ? JSON.parse(user_locale_code) : user_locale_code;
      var current_country = locale_data.country;
      var phone_code = locale_data.code;
      var code_country = country_name_codes[current_country] + ' (' + phone_code + ')';

      if ($('#country_code').length > 0 && phone_code != undefined && current_country != undefined && $('#country_code_input').val() == '') {
        $('#country_code > option').html(code_country);
        $('#country_code > option').attr('data-value', user_locale_code);
        $('#country_code_input').attr('value', code_country);
      }
    }
  }
}); // live location search

$('#country_code_input').keyup(function (e) {
  var value = e.target.value;
  var data = {
    "country_code": value,
    "current_locale": user_locale_code,
    "form_type": "coutry_code_search"
  };

  if (value.length > 1) {
    postCheck('country_code', data, 0);
  }
}); 

// email live check
$('#create_email').keyup(function (e) {
  var value = e.target.value;
  var valid_email = validate_email(value) ? true : false;
  var pw_element = $('#create_password');
  var feedback_el = $('#emailFeedback');
  var pass_len = pw_element.val().length;

  if (valid_email) {
    $(this).removeClass('is-invalid');
    feedback_el.removeClass('invalid-feedback').addClass('valid-feedback');
  } else {
    $(this).addClass('is-invalid');
    feedback_el.removeClass('valid-feedback').addClass('invalid-feedback');
  }

  if ($('#create_account_field input').hasClass('is-invalid') || pass_len == 0) {
    $('#create_account').attr('disabled', true);
  } else if (pw_element.val().length > 7 && $('#passwordFeedback').hasClass('valid-feedback')) {
    $('#create_account').attr('disabled', false);
  }
}); // password live check

// $('#create_password').keyup(function (e) {
//   var value = e.target.value;
//   var valid_password = validate_password(value);
//   var em_element = $('#create_email');
//   var feedback_el = $('#passwordFeedback');
//   var email_len = em_element.val().length;

//   if (valid_password == '') {
//     $(this).removeClass('is-invalid');
//     feedback_el.removeClass('invalid-feedback').addClass('valid-feedback');
//     feedback_el.html('Invalid password');
//     feedback_el.hide();
//   } else {
//     $(this).addClass('is-invalid');
//     feedback_el.removeClass('valid-feedback').addClass('invalid-feedback');
//     feedback_el.html(valid_password);
//     feedback_el.show();
//   } 
  
//   // for user creation

//   if ($('#create_account_field input').hasClass('is-invalid') || email_len == 0) {
//     $('#create_account').attr('disabled', true);
//   } else if (em_element.val().length > 6 && $('#emailFeedback').hasClass('valid-feedback')) {
//     $('#create_account').attr('disabled', false);
//   } // for business creation


//   if ($('#accountFieldset input').hasClass('is-invalid') || email_len == 0) {
//     $('#business_account').attr('disabled', true);
//   } else if (em_element.val().length > 6 && $('#emailFeedback').hasClass('valid-feedback')) {
//     $('#business_account').attr('disabled', false);
//   }
// }); 

// account creation form submission

$('#create_account').on('click', function () {
  var email     = $('#create_email').val();
  var name      = $('#create_name').val();
  var last_name = $('#create_last_name').val();
  var contact   = $('#create_contact').val();
  var company   = $('#company').val();
  var msg_attr  = 'create_account_message';
  data = {
    'email': email,
    'name': name,
    'last_name': last_name,
    'contact': contact,
    'company': company,
    'form_type': 'sign_up'
  };
  $('#' + msg_attr).html('');
  postCheck(msg_attr, data, 0);
});

$('#user_create').on("input", function () {
  var user_create = parseInt($(this).val());

  if (user_create == 1) {
    live_field_update('user_email_confirm', 'email_confirmation_check', 11);
  }
}); // username live check

$('#create_username').keyup(function (e) {
  var value = e.target.value;
  var valid_username = validate_username(value);
  var feedback_el = $('#usernameFeedback');

  if (valid_username == '') {
    $(this).removeClass('is-invalid');
    feedback_el.removeClass('invalid-feedback').addClass('valid-feedback');
    feedback_el.hide();
  } else {
    $(this).addClass('is-invalid');
    feedback_el.removeClass('valid-feedback').addClass('invalid-feedback');
    feedback_el.html(valid_username);
    feedback_el.show();
  }

  if ($('#create_username_field input').hasClass('is-invalid')) {
    $('#create_username_btn').attr('disabled', true);
  } else {
    $('#create_username_btn').attr('disabled', false);
  }
}); // profile account input checks

$('#profile_name, #name, #last_name').keyup(function (e) {
  var value = e.target.value;
  var valid_text = validate_text(value);
  var feedback_lb = $(this).next();
  var feedback_el = feedback_lb.next(); // const feedback_id = feedback_el.prop('id');

  var feedback_tx = $(this).siblings('.invalid_text').val();
  var check_vals = $("#create_details_field input[type='text']").filter(function () {
    return $.trim($(this).val()).length == 0;
  }).length === 0;

  if (valid_text == '') {
    $(this).removeClass('is-invalid');
    feedback_el.removeClass('invalid-feedback').addClass('valid-feedback');
    feedback_el.html(feedback_tx);
    feedback_el.hide();
  } else {
    $(this).addClass('is-invalid');
    feedback_el.removeClass('valid-feedback').addClass('invalid-feedback');
    feedback_el.html(valid_text);
    feedback_el.show();
  }

  var has_invalid = $('#profile_name, #name, #last_name').hasClass('is-invalid');

  if (has_invalid) {
    $('#complete_account').attr('disabled', true);
  } else if (check_vals) {
    $('#complete_account').attr('disabled', false);
  }
}); // create username 

$('#create_username_btn').on('click', function () {
  var username = $('#create_username').val();
  var msg_attr = 'create_username_message';
  data = {
    'username_confirm': true,
    'username': username,
    'form_type': 'create_username'
  };
  $('#' + msg_attr).html('');
  postCheck(msg_attr, data, 0);
}); // complete account creation 

$('#complete_account').on('click', function () {
  var profile_name = $('#profile_name').val();
  var name = $('#name').val();
  var last_name = $('#last_name').val();
  var account_dob = $('#account_dob').val();
  var account_mob = $('#account_mob').val();
  var account_yob = $('#account_yob').val();
  var gender = $('#gender input[name="gender"]:checked').val();
  var city_locale = $('#country_city_input').val();
  var msg_attr = 'complete_account_message';
  data = {
    'profile_name': profile_name,
    'name': name,
    'last_name': last_name,
    'dob': account_dob,
    'mob': account_mob,
    'yob': account_yob,
    'gender': gender,
    "city_country": city_locale,
    'form_type': 'create_user_account'
  };
  $('#' + msg_attr).html('');
  postCheck(msg_attr, data, 0);
}); // user login *********************************************************************
// username live check

$('#login_username, #login_email').keyup(function (e) {
  var value = e.target.value;
  var valid_text = validate_empty_text(value);
  var feedback_lb = $(this).next();
  var feedback_el = feedback_lb.next(); // const feedback_id = feedback_el.prop('id');

  var feedback_tx = $(this).siblings('.invalid_text').val();

  if (valid_text == '') {
    $(this).removeClass('is-invalid');
    feedback_el.removeClass('invalid-feedback').addClass('valid-feedback');
    feedback_el.html(feedback_tx);
    feedback_el.hide();
  } else {
    $(this).addClass('is-invalid');
    feedback_el.removeClass('valid-feedback').addClass('invalid-feedback');
    feedback_el.html(valid_text);
    feedback_el.show();
  }
});

$('#login_btn').on('click', function () {
  var login_type = $(this).attr('login_type');
  var user_name = $('#login_username').val();
  var user_pass = $('#login_password').val();
  var user_email = $('#login_email').val();
  var passreset = $('#passresetInpt').val() == 'true' || $('#passresetInpt').val() == true ? true : false;
  var form_type = passreset ? 'passreset' : 'login_form';
  var err_attr_id = 'user_login_message';
  var form_data = passreset ? {
    'email': user_email
  } : {
    'login_username': user_name
  };
  data = {
    'form_type': form_type,
    'login_username': user_name,
    'login_password': user_pass
  };
  data = Object.assign(data, form_data);

  if ($('#passresetConfirm').length != undefined && $('#passresetConfirm').length != 0) {
    passResetPost();
  } else {
    postCheck(err_attr_id, data, 0);
  }
}); // set username cookie

$('#user_remember').on("input", function () {
  var remember_val = $(this).val();

  if ($('#remember_me').is(":checked") && remember_val != '') {
    setCookie('username', remember_val);
  }
}); // User password reset ***********************************************************
// password validation

$('#login_password').keyup(function (e) {
  if ($('#passwordDiv').hasClass('has-validation')) {
    var value = e.target.value;
    var valid_password = validate_password(value);
    var feedback_el = $('#loginPasswordFeedback');

    if (valid_password == '') {
      $(this).removeClass('is-invalid');
      feedback_el.removeClass('invalid-feedback').addClass('valid-feedback');
      feedback_el.html('Invalid password');
      feedback_el.hide();
      $('#login_btn').attr('disabled', false);
    } else {
      $(this).addClass('is-invalid');
      feedback_el.removeClass('valid-feedback').addClass('invalid-feedback');
      feedback_el.html(valid_password);
      feedback_el.show();
      $('#login_btn').attr('disabled', true);
    }
  }
}); // password reset ****************************************************************

$(function () {
  if (parseInt($('#passresetInpt').val()) == 1) {
    passReset();
  }
}); // email confirmations check

var user_email_confirm = $('#user_email_confirm').length > 0 ? parseInt($('#user_email_confirm').val()) : '';
var email_confirm = $('#email_confirm').length > 0 ? $('#email_confirm').val() : '';
var field_id = 'message';
var form_type = 'check_email_confirmed';
var input_val = true;
var form_url = 10;
var constant_timer = 15;
var update_sett = 1;

if (email_confirm == 'unconfirmed' || user_email_confirm === 0) {
  var constant_update_settings = function constant_update_settings() {
    setTimeout(constant_update_settings, 1000);

    if (constant_timer === 3) {
      constant_timer = 16;

      if (user_email_confirm === 0) {
        form_url = 11;
        field_id = 'create_account_message';
        form_type = 'user_email_confirmation';
      }

      data = {
        'email_confirm': input_val,
        'form_type': form_type
      };
      // postCheck(field_id, data, form_url);
      // clearTimeout(constant_update_settings);
    }

    constant_timer--;
  };

  if (update_sett == 1) {
    constant_update_settings();
  }
}

$('#pills-tab-alt a[role="tab"]').click(function (e) {
  var tab = $(this);
  var btn_id = tab.attr('id');
  var e_prnt = tab.parent();
  console.log(e_prnt);
  console.log(tab);
  var elem_target = "#pills-tab-alt";

  if (!e_prnt.hasClass('article_active')) {
    var elem = tab.attr(elem_target); // $(elem_target).children().removeClass('article_active');

    window.setTimeout(function () {
      $("#pills-tab-alt>.article_nav").removeClass('article_active');
      $('#pills-tab-alt a[role="tab"]').removeClass('active');
      $(e_prnt).addClass('article_active');
      $(tab).addClass('active'); // change_bg('pills-tab-alt')
    }, 1);
  }
}); 

// ************************ functions