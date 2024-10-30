<?php

function code9_api_security_2_step_get()
{
  wp_send_json([
    "result" => true,
    "data" => get_option('code9_security_2_step', '0')
  ]);
}



add_action('wp_ajax_security_2_step_get', 'code9_api_security_2_step_get');


?>