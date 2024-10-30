<?php

function code9_api_security_2_step_update()
{
  

  
  update_option('code9_security_2_step', $_POST['security_2_step']);
  
  wp_send_json([
    "result" => true
  ]);

  
}


add_action('wp_ajax_security_2_step_update', 'code9_api_security_2_step_update');

?>