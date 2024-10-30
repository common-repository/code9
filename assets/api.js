var C9_API = async function (route, data) {

  if(!data) data = {};
  
  
  return await new Promise(async function (resolve, reject) {
    var request = new XMLHttpRequest();

    request.open("POST", ajaxurl, true);

    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");

    request.onreadystatechange = async function () {
      if (request.readyState === 4) {
        try {
          if (request.status === 200) {

            resolve(JSON.parse(request.responseText));
          } else {
            console.log(request);
            throw new Error(request);
          }
        } catch (e) {
          console.error(e);
          reject(e);
        }
      }
    };

    request.send(`action=${encodeURIComponent(route)}&c9_data_encrypt=${C9_CRYPTO.encode(data)}`);
  });
  
};
