var C9_POPUP_DRAGSTART = function (e) {
  e.stopPropagation();

  C9_POPUP_ACTIVE(jQuery(e.target));
  
  jQuery(e.target).addClass("c9-popup-draging");
    var dragImage = document.createElement("div");
    dragImage.classList.add("c9-drag-ghost");
    document.body.appendChild(dragImage);

    try {
      e.originalEvent.dataTransfer.setDragImage(dragImage, 0, 0);
    } catch (e) {
      console.error(e);
    }

    jQuery(e.target).attr({
      'data-offset-left' : jQuery(e.target).offset().left - e.clientX - jQuery(window).scrollLeft(),
      'data-offset-top' : jQuery(e.target).offset().top - e.clientY - jQuery(window).scrollTop()
    });
};

var C9_POPUP_DRAGING = function (e) {
  if (e.clientX > 0 && e.clientY > 0)
    jQuery(e.target).css({
      top: e.clientY + +jQuery(e.target).attr('data-offset-top') + "px",
      left: e.clientX + +jQuery(e.target).attr('data-offset-left') + "px",
    });
};

var C9_POPUP_DRAGEND = function (e) {
  jQuery(e.target).attr("draggable", "false");

  jQuery(e.target).removeClass("c9-popup-draging");

  jQuery(".c9-drag-ghost").remove();
};

var C9_POPUP_ACTIVE = function(dom) {
  jQuery(".c9-popup-drag-active").removeClass("c9-popup-drag-active");

  dom.addClass('c9-popup-drag-active');
};


var C9_POPUP_DRAG = function (o) {

  if(o.close == null) o.close = true;

  if (jQuery(`#${o.id}`).length === 0) {
    jQuery("body").append(
      jQuery("<div>")
        .attr({
          id: o.id,
          class: "c9-popup-drag " + (o.class || ''),
          draggable: "false",
          'data-offset-left' : "0",
          'data-offset-top' : "0"
        })
        .on('dragstart', C9_POPUP_DRAGSTART)
        .on('drag', C9_POPUP_DRAGING)
        .on('dragend', C9_POPUP_DRAGEND)
        .html([
          jQuery("<div>").attr({
            class: "c9-popup-header",
          })
          .html([
            (o.title || ''),
            o.close && jQuery('<i>').attr({
              class: 'dashicons dashicons-no-alt c9-float-right c9-link'
            }).on('click', function() {
              if(typeof o.close_callback === 'function') o.close_callback();
              else jQuery(`#${o.id}`).addClass('c9-hidden');
            })
          ])
          .on('mousedown', function() {
            C9_POPUP_ACTIVE(jQuery(`#${o.id}`));
            jQuery(`#${o.id}`).attr('draggable', 'true');
          })
          .on('mouseup', function() {
            jQuery(`#${o.id}`).attr('draggable', 'false');
          }),
          jQuery("<div>")
            .attr({
              class: "c9-popup-body",
            })
            .html(o.body),
        ])
    );
  }

  
  
};
