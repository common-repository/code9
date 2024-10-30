<?php

function code9_api_security_2_step_key_iv_reset()
{
  code9_security_public_unset();
  
  update_option('code9_security_key', bin2hex(openssl_random_pseudo_bytes(16)));

  update_option('code9_security_iv', bin2hex(openssl_random_pseudo_bytes(16)));
  
  wp_send_json([
    "result" => true
  ]);
}


add_action('wp_ajax_security_2_step_key_iv_reset', 'code9_api_security_2_step_key_iv_reset');

?>