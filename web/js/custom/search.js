"use strict";

$(function () {
  $('#global_search_id').keyup(function () {
    $('#global_search').html(''); // $('#srch_res_here').show();

    var srch_val = $(this).val();
    var srch_data = $('#search_form').serialize();

    if (srch_val != '' && srch_val != null && srch_val.length >= 2) {
      postCheck('global_search', srch_data, 8, true);
    }
  }); // search

  $('input[name="search"]').change(function () {
    var src_val = $('#global_search_id').val();
    var inp_val = $(this).val();
    var cat_val = $('#global_search option').filter(function () {
      return this.value == inp_val;
    }).data('value');
    /* if value doesn't match an option, cat_val will be undefined*/

    window.location.href = './search?qry=' + cat_val + '&search=' + src_val;
  });
});