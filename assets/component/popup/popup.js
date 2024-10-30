var C9_POPUP_CLOSE = function() {
  document.getElementById('c9_component_popup').classList.add('c9-hidden');
  document.getElementById('c9_component_popup_background').classList.add('c9-hidden');
};

var C9_POPUP = function(title, description, layout) {

  jQuery('#c9_component_popup_close_button').removeClass('c9-hidden');

  jQuery('#c9_component_popup_title').html(title);
  jQuery('#c9_component_popup_description').html(description);

  jQuery('#c9_component_popup').removeClass("c9-hidden");

  if(layout === 'background') {
    jQuery('#c9_component_popup_close_button').addClass('c9-hidden');
    jQuery('#c9_component_popup_background').removeClass("c9-hidden");

    jQuery('#c9_component_popup_background').unbind('click').bind('click', function() {
      jQuery('#c9_component_popup').addClass("c9-hidden");
      jQuery('#c9_component_popup_background').addClass("c9-hidden");
    });
  }

  if(layout === 'backgroundfixed') {
    jQuery('#c9_component_popup_background').removeClass("c9-hidden");

    jQuery('#c9_component_popup_background').unbind('click');
  }
};

var C9_POPUP_INSTALL = function() {
  if(jQuery('#c9_component_popup').length === 0) {
    jQuery('body').append(`<div id="c9_component_popup" class="c9-hidden">
    <div id="c9_component_popup_container">
      <button id="c9_component_popup_close_button" onclick="C9_POPUP_CLOSE()">
      <span class="dashicons dashicons-no-alt"></span>
      </button>
      <div id="c9_component_popup_title">Title</div>
      <div id="c9_component_popup_description">Description</div>
    </div>
  </div>
  <div id="c9_component_popup_background" class="c9-hidden"></div>`)
  }

};


C9_POPUP_INSTALL();