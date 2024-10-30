var C9_FORM_OBJ = function(dom) {
  return dom.serializeArray().reduce(function(obj,data){  obj[data.name] = data.value; return obj;}, {});
};