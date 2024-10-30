<?php

function code9_api_security_anti_brute_force_blocked_remove()
{
  

  delete_option($_POST['id']);
  
  wp_send_json([
    "result" => true
  ]);

  
}


add_action('wp_ajax_security_anti_brute_force_blocked_remove', 'code9_api_security_anti_brute_force_blocked_remove');

?>