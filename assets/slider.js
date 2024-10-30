var C9_SLIDER = {
  find_index_active: function(_dom_body) {
    var _index = 0;
    var _index_found = false;
    var _scroll_left = _dom_body.scrollLeft();
    _dom_body.find('>*').each(function(index) {
      var _offset = jQuery(this).offset();

      if(_offset != null) {
        if(_scroll_left <= (_dom_body.scrollLeft() + jQuery(this).offset().left) && _index_found === false) {
          _index_found = true;
          _index = index;

          return false;
        }
      }
      
    });

    return _index;
  },
  next_slide_trigger: function() {

  },
  render: function() {
    jQuery(`[data-mode="slider"]:not(.c9-slider-installed)`).each(function() {
      var _dom = jQuery(this);
      var _dom_mouseover = false;

      _dom.on('mouseover', function() {
        _dom_mouseover = true;
      }).on('mouseout', function() {
        _dom_mouseover = false;
      });

      if(_dom.attr('data-slider-body')) {

        var _dom_body = _dom.find(_dom.attr('data-slider-body'));

        if(_dom_body.length > 0) {
          if(_dom.attr('data-slider-active') && _dom_body.find(`>*:eq(${_dom.attr('data-slider-active')})`).offset()) {
            _dom_body.scrollLeft(_dom_body.scrollLeft() + _dom_body.find(`>*:eq(${_dom.attr('data-slider-active')})`).offset().left);
          }

          
          if(_dom.attr('data-slider-next-button')) {
            var _dom_next_button = _dom.find(_dom.attr('data-slider-next-button'));

            if(_dom_next_button.length > 0) {

              if(_dom.attr('data-slider-auto-play') === '1') {
                setInterval(function() {
                  if(_dom.attr('data-slider-hover-pause') === '1' && _dom_mouseover === true) return false;
                  
                  _dom_next_button.mouseup();
                }, _dom.attr('data-slider-time') || 4000)
              }
              
              _dom_next_button.unbind('mouseup').bind('mouseup', function() {

                var _next_item_index = C9_SLIDER.find_index_active(_dom_body) + +(_dom.attr('data-slider-step') || 1);

                var _offset = _dom_body.find(`>*:eq(${_next_item_index})`).offset();

                if(_offset != null) {
                  _dom_body.scrollLeft(_dom_body.scrollLeft() + _offset.left);
                }
              });
            }
          }

          if(_dom.attr('data-slider-prev-button')) {
            var _dom_prev_button = _dom.find(_dom.attr('data-slider-prev-button'));
     
            if(_dom_prev_button.length > 0) {
              
              _dom_prev_button.unbind('mouseup').bind('mouseup', function() {
                var _prev_item_index = C9_SLIDER.find_index_active(_dom_body) - +(_dom.attr('data-slider-step') || 1);

                if(_prev_item_index < 0) _prev_item_index = 0;

                var _offset = _dom_body.find(`>*:eq(${_prev_item_index})`).offset();

                if(_offset != null) {

                  _dom_body.scrollLeft(_dom_body.scrollLeft() + _offset.left);

                }
              });
            }
          }
        }
      }

      _dom.addClass('c9-slider-installed');
    })
  }
};