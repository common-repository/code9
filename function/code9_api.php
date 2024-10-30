<?php

  
if(isset($_COOKIE['code9_api_public_key']) !== true) {
  setcookie('code9_api_public_key', bin2hex(openssl_random_pseudo_bytes(16)), 0, "/", "", false, false);
}

if(isset($_COOKIE['code9_api_public_iv']) !== true) {
  setcookie('code9_api_public_iv', bin2hex(openssl_random_pseudo_bytes(16)), 0, "/", "", false, false);
}

function code9_api() {
  if(isset($_REQUEST['c9_data_encrypt']) === true) {
    $data = code9_decrypt($_REQUEST['c9_data_encrypt'], $_COOKIE['code9_api_public_key'], $_COOKIE['code9_api_public_iv']);

    if($data) {
      foreach($data as $key=>$value) {
        $_POST[$key] = $value;
        $_REQUEST[$key] = $value;
      }
    }
  }
  
  return;
}

add_action('admin_init', 'code9_api');
?>