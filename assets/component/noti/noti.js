var C9_NOTI_TIMEOUT_0 = null;

var C9_NOTI_TIMEOUT_1 = null;

var C9_NOTI = function (title) {
  clearTimeout(C9_NOTI_TIMEOUT_0);
  clearTimeout(C9_NOTI_TIMEOUT_1);
  jQuery('.c9-noti').remove();

  jQuery('body').append(`<div class="c9-noti">${title}</div>`);

  C9_NOTI_TIMEOUT_0 = setTimeout(function() {
    jQuery('.c9-noti').addClass('c9-noti-out');
    C9_NOTI_TIMEOUT_1 = setTimeout(function() {
      jQuery('.c9-noti').remove();

    }, 450);
  }, 3000);
};
