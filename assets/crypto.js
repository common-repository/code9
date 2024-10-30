var C9_CRYPTO = {
  encode: function (data) {
    try {

      return encodeURIComponent(CryptoJS.AES.encrypt(JSON.stringify(data), CryptoJS.enc.Hex.parse(C9_COOKIE.get("code9_api_public_key")), {
        iv: CryptoJS.enc.Hex.parse(C9_COOKIE.get("code9_api_public_iv")),
      }).toString());
    } catch (e) {
      console.error("Error crypto encode");
      console.error(e);
      return data;
    }
  },
  decode: function (data) {
    try {
      return JSON.parse(
        CryptoJS.AES.decrypt(data, key).toString(CryptoJS.enc.Utf8)
      );
    } catch (e) {
      console.error("Error crypto decode");
      return data;
    }
  },
};
