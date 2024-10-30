var C9_DOM_LOADING = function (dom, inner_html) {
    if(inner_html == null) {
        var _i_html = dom.innerHTML;

        dom.innerHTML = '<span class="c9-loading"></span>';
        
        return _i_html

    } else {
        dom.innerHTML = inner_html;

        return;
    }
};