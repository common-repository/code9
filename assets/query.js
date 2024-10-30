var C9_QUERY = function(data) {
  if(!data) data = decodeURI(window.location.search);
  
    return data
    .replace("?", "")
    .split("&")
    .map(function(p) { return p.split("="); })
    .reduce(function(values, r) {
      values[r[0]] = r[1];
      return values;
    }, {});
};