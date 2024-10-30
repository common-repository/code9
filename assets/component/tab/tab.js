var C9_TAB = function(tab, body, option) {

  if(!option) option = {}

  if(!option.index_tab) option.index_tab = 0;

  return jQuery('<div>')
  .attr({
    class: 'c9-tab'
  })
  .html([
    jQuery('<div>').html(tab.map(function(t, k){ 
      return jQuery('<button>')
      .attr({
        class: k === option.index_tab ? 'c9-tab-active' : ''
      })
      .html(t)
      .on('click', function() {

        jQuery(this).closest(".c9-tab").find(`.c9-tab-body > div`).addClass('c9-hidden');
        jQuery(this).closest(".c9-tab").find(`.c9-tab-body > div:eq(${k})`).removeClass('c9-hidden');

        jQuery(this).closest(".c9-tab").find('.c9-tab-active').removeClass('c9-tab-active');

        jQuery(this).addClass('c9-tab-active');

        if(typeof option.tab_click_callback === 'function') {
          option.tab_click_callback(k);
        }
      })
    }))
    ,
    jQuery('<div>')
    .attr({
      class: 'c9-tab-body'
    })
    .html(body.map(function(b, bk){ 
      return jQuery('<div>').attr({class: bk === option.index_tab ? '' : 'c9-hidden'}).html(b);
    }))
  ])
};