var C9_CONFIRM = function (body, callback) {

  C9_POPUP_DRAG({
    id: 'c9-confirm',
    body: jQuery('<div>').html([
      `<div>${body}</div>`,
      jQuery('<div>')
      .attr({
        class: 'c9-text-right'
      })
      .html([
        jQuery('<button>').html(__('Cancel')).on('click', function() {
          jQuery('#c9-confirm').remove();
        }),
        jQuery('<button>').html(__('Confirm')).on('click', function() {
          callback();
          jQuery('#c9-confirm').remove();
        }),
      ])

    ])
  });

  
  
};
