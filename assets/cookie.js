var C9_COOKIE = {
  get: function (name) {
    name = name + "=";
    var _ca = decodeURIComponent(document.cookie).split(";");
    for (var i = _ca.length; i-- > 0; ) {
      while (_ca[i][0] === " ") {
        _ca[i] = _ca[i].substring(1);
      }

      if (_ca[i].indexOf(name) === 0) {
        return _ca[i].substring(name.length, _ca[i].length);
      }
    }
    return "";
  },
  set: function (cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";";
  },
};
