"use strict"; // Tabs navigation

var total = document.querySelectorAll('.nav-pills');
total.forEach(function (item, i) {
  //   var moving_div = document.createElement('div');
  //   var first_li = item.querySelector('li:first-child .nav-link');
  //   var tab = first_li.cloneNode();
  //   tab.innerHTML = "-";
  //   moving_div.classList.add('moving-tab', 'position-absolute', 'nav-link');
  //   moving_div.appendChild(tab);
  //   item.appendChild(moving_div);
  //   var list_length = item.getElementsByTagName("li").length;
  //   moving_div.style.padding = '0px';
  //   moving_div.style.width = item.querySelector('li:nth-child(1)').offsetWidth + 'px';
  //   moving_div.style.transform = 'translate3d(0px, 0px, 0px)';
  //   moving_div.style.transition = '.5s ease';
  item.onmouseover = function (event) {
    var target = getEventTarget(event);
    var li = target.closest('li'); // get reference

    if (li) {
      var nodes = Array.from(li.closest('ul').children); // get array

      var index = nodes.indexOf(li) + 1;

      item.querySelector('li:nth-child(' + index + ') .nav-link').onclick = function () {
        var tab_name = $(this).attr('data-name');
        var tab_variable = $(this).attr('get-variable');
        var tab_variable = tab_variable.length > 0 ? tab_variable : '';

        if (tab_name.length > 0) {
          change_bg();
          changeURL(tab_name, tab_variable); 
          
          // change tab_inpu on search form
          if ($('#tab_input').length > 0) {
            $('#tab_input').val(tab_name);
          }
        }
        
        // moving_div = item.querySelector('.moving-tab');
        // var sum = 0; // if (item.classList.contains('flex-column')) {
        //   for (var j = 1; j <= nodes.indexOf(li); j++) {
        //     sum += item.querySelector('li:nth-child(' + j + ')').offsetHeight;
        //   }
        //   moving_div.style.transform = 'translate3d(0px,' + sum + 'px, 0px)';
        //   moving_div.style.height = item.querySelector('li:nth-child(' + j + ')').offsetHeight;
        // } else {
        //   for (var j = 1; j <= nodes.indexOf(li); j++) {
        //     sum += item.querySelector('li:nth-child(' + j + ')').offsetWidth;
        //   }
        //   moving_div.style.transform = 'translate3d(' + sum + 'px, 0px, 0px)';
        //   moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
        // }

      };
    }
  };
}); 

// Tabs navigation resize
// window.addEventListener('resize', function (event) {
//   total.forEach(function (item, i) {
//     // item.querySelector('.moving-tab').remove();
//     var moving_div = document.createElement('div');
//     var tab = item.querySelector(".nav-link.active").cloneNode();
//     tab.innerHTML = "-"; // moving_div.classList.add('moving-tab', 'position-absolute', 'nav-link');
//     moving_div.appendChild(tab);
//     item.appendChild(moving_div);
//     moving_div.style.padding = '0px';
//     moving_div.style.transition = '.5s ease';
//     var li = item.querySelector(".nav-link.active").parentElement;
//     if (li) {
//       var nodes = Array.from(li.closest('ul').children); // get array
//       var index = nodes.indexOf(li) + 1;
//       var sum = 0;
//       if (item.classList.contains('flex-column')) {
//         for (var j = 1; j <= nodes.indexOf(li); j++) {
//           sum += item.querySelector('li:nth-child(' + j + ')').offsetHeight;
//         }
//         moving_div.style.transform = 'translate3d(0px,' + sum + 'px, 0px)';
//         moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
//         moving_div.style.height = item.querySelector('li:nth-child(' + j + ')').offsetHeight;
//       } else {
//         for (var j = 1; j <= nodes.indexOf(li); j++) {
//           sum += item.querySelector('li:nth-child(' + j + ')').offsetWidth;
//         }
//         moving_div.style.transform = 'translate3d(' + sum + 'px, 0px, 0px)';
//         moving_div.style.width = item.querySelector('li:nth-child(' + index + ')').offsetWidth + 'px';
//       }
//     }
//   });
//   if (window.innerWidth < 991) {
//     total.forEach(function (item, i) {
//       if (!item.classList.contains('flex-column')) {
//         item.classList.add('flex-column', 'on-resize');
//       }
//     });
//   } else {
//     total.forEach(function (item, i) {
//       if (item.classList.contains('on-resize')) {
//         item.classList.remove('flex-column', 'on-resize');
//       }
//     });
//   }
// });

function getEventTarget(e) {
  e = e || window.event;
  return e.target || e.srcElement;
} 

// End tabs navigation
// helper funcions
function change_bg() {
  var tab_ul_id = arguments.length > 0 && arguments[0] !== undefined && arguments[0] != '' ? arguments[0] : 'pills-tab';
  $('#' + tab_ul_id + ' > li').removeClass('article_active');
  $('#' + tab_ul_id + ' > li > a.active').parent().addClass('article_active');
}

$('#searchInp').keyup(function(e){
  console.log("hello");
  var search_val = e.target.value;
  var data = {'form_type': 'search_client', 'user': search_val};

  if (search_val.length > 1){
    postCheck('search_res', data, 0);
  }
});