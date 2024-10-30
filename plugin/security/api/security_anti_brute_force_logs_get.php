<?php

function code9_api_security_anti_brute_force_logs_get()
{
  global $wpdb;

  wp_send_json([
    "result" => true,
    "data" => $wpdb->get_results( "SELECT * FROM $wpdb->options WHERE option_name LIKE '%code9_anti_brute_force[]%' AND option_value > '2' ORDER BY option_id DESC" )
  ]);
}



add_action('wp_ajax_security_anti_brute_force_logs_get', 'code9_api_security_anti_brute_force_logs_get');


?>