<?php

function code9_api_security_anti_brute_force_update()
{
  

  
  update_option('code9_security_anti_brute_force', $_POST['security_anti_brute_force']);
  
  wp_send_json([
    "result" => true
  ]);

  
}


add_action('wp_ajax_security_anti_brute_force_update', 'code9_api_security_anti_brute_force_update');

?>