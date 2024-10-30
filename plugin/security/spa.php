<?php

function code9_spa_security()
{

  
 
  ob_start();
  include('spa/security.php');
  $NOW['html'] = ob_get_clean();

  ob_start();
  include('spa/security.js');
  $NOW['js'] = ob_get_clean();
  
  wp_send_json([
    "result" => true,
    "html" =>  $NOW['html'],
    "js" =>  $NOW['js'],
  ]);

  

  unset($NOW);  
}


add_action('wp_ajax_spa_security', 'code9_spa_security');

?>