<?php

function code9_api_security_2_step_blockingtime_update()
{
  

  
  update_option('code9_security_2_step_blockingtime', $_POST['timeout']);
  
  wp_send_json([
    "result" => true,
    "response_text" => __("Save")
  ]);

  
}


add_action('wp_ajax_security_2_step_blockingtime_update', 'code9_api_security_2_step_blockingtime_update');

?>