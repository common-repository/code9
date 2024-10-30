var C9_SPA = {
  get: async function() {
    document.getElementById('c9-main').innerHTML = '<span class="c9-loading"></span>';


    var _query_spa = C9_QUERY().spa || 'security';

    var _r = await C9_API(`spa_${_query_spa}`, {});
    

    if(_r.result === true) {
      if(_r.html === undefined) _r.html = '';

      jQuery('#c9-css-spa').html(_r.css || '');
      

    } else {
      _r.html = "Error internal server";
    }
    
    jQuery('#c9-main').html(_r.html);

    jQuery('#c9-javascript-spa').replaceWith(`<script type="text/javascript" id="c9-javascript-spa">${_r.js}</script>`);

    jQuery('#c9-side-middle a').removeAttr('data-link-active');

    jQuery(`#c9-side-middle a[data-link="${C9_QUERY().spa || 'template'}"]`).attr('data-link-active', '');
    
  },
  go: async function(url) {
    window.history.pushState({}, '', url);

    C9_SPA.get();
    
  },
  href: function() {

    jQuery('#c9-wrap a[href]:not([target])').each(function() {
      jQuery(this).unbind('click').bind('click',async function(e) {
        e.preventDefault();

        C9_SPA.go(jQuery(this).attr('href'));
      })
    });

  },
  render: function() {
    C9_SPA.get();
    
    window.onpopstate = function(event) {
      C9_SPA.get();
    };

    C9_SPA.href();

    if(jQuery('#c9-css-spa').length === 0) {
        jQuery('#c9-css-local').after('<style id="c9-css-spa"></style>');
    }

    if(jQuery('#c9-javascript-spa').length === 0) {
      jQuery('body').append('<script type="text/javascript" id="c9-javascript-spa"></script>');
    }
  }
};


(function() {

  window.addEventListener('load', async function() {
    C9_SPA.render();
  });
  
})();