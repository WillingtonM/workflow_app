"use strict";

$(function ($) {
  $('#img_cspture').on('click', function (e) {
    e.preventDefault();
    $('#post_image')[0].click();
  });
  $('#post_image').on('change', function (e) {
    if ($('#post_image').val()) {
      $('.fa-camera.fa-3x').css('color', '#03556b');
      file_data = new FormData();
      file_data.append('post_image', $("#post_image")[0].files[0]);
      file_data = $("#post_image")[0].files[0];
      console.log(file_data);
      postFile('account_message', 'post_image', file_data, 10, 'img_cspture');
    } else {
      $('#img_cspture').css('color', '');
    }
  });
});
$(".hour_select").on('input', function () {
  var val = this.value;
  var day = this.id;
  var dta = $('#' + day).attr('data');

  if (val == '24-hours') {
    $('.enddt_' + dta).hide();
  } else {
    $('.enddt_' + dta).show();
  }
});
$('.trade_hours').on('change', function () {
  var hid = this.id;
  var hval = this.value;

  if ($('#' + hid + ':checked').length > 0) {
    $('#hlabel_' + hval).text('Open');
  } else {
    $('#hlabel_' + hval).text('Closed');
  }
});
$('.delivery_methods').on('change', function () {
  var hid = this.id;
  var hval = this.value;

  if ($('#' + hid + ':checked').length > 0) {
    $('#dlabel_' + hval).text('Active');
  } else {
    $('#dlabel_' + hval).text('Disabled');
  }
}); // mobile authentication

$(".limit_text").keyup(function () {
  var maxChars = 6;

  if ($(this).val().length > maxChars) {
    $(this).val($(this).val().substr(0, maxChars));
  }
}); // email confirmation

var email_confirm = $('#email_confirm').length > 0 ? $('#email_confirm').val() : '';
var constant_timer = 15;
var update_sett = 1;

if (email_confirm == 'unconfirmed') {
  var constant_update_settings = function constant_update_settings() {
    setTimeout(constant_update_settings, 1000);

    if (constant_timer === 3) {
      constant_timer = 16;
      var data = {
        'email_confirm': true,
        'form_type': 'check_email_confirmed'
      };
      postCheck('message', data, 10);
      clearTimeout(constant_update_settings);
    }

    constant_timer--;
  };

  if (update_sett == 1) {
    constant_update_settings();
  }
} // settings
// subscription_popup


$('#subscription_popup').on('change', function () {
  var hid = this.id;
  var val = $('#' + hid + ':checked').length > 0 ? 1 : 0;
  var label = val ? 'Enabled' : 'Disabled';
  $('#ubscription_popup_label').text(label);
  data = {
    'form_type': 'subscription_popup',
    'form_value': val
  };
  postCheck('null', data);
}); // subscription_active

$('#subscription_active').on('change', function () {
  var hid = this.id;
  var val = $('#' + hid + ':checked').length > 0 ? 1 : 0;
  var label = val ? 'Enabled' : 'Disabled';
  $('#subscription_active_label').text(label);
  data = {
    'form_type': 'subscription_active',
    'form_value': val
  };
  postCheck('null', data);
}); // article email type

$('.article_email_type').on('change', function () {
  var hid = this.id;
  var hval = this.value; // if ($('#' + hid + ':checked').length > 0) {
  //   $('#label_' + hval).text('Long article');
  // } else {
  //   $('#label_' + hval).text('Short article');
  // }

  data = {
    'form_type': 'article_email_type',
    'form_value': hval
  };
  postCheck('null', data);
});