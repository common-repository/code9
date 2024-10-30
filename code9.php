<?php
/*
Plugin Name: Code9
Plugin URI: https://wordpress.org/plugins/code9/
Description: Utility tool for wordpress. 2-step verificatoin code user login.
Version:     1.0.13
Author:      Code9Fair
Author URI: https://paypal.me/code9fair/
License:     GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  c9

Copyright 2021 Code9Fair (email : cod9fair@gmail.com)
Code9 is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Code9 is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Code9
*/

add_action('init', function() {
  $NOW = array();
  
  $GLOBALS['CODE9_PLUGIN_DIR'] = plugin_dir_path( __FILE__ );
  $GLOBALS['CODE9_PLUGIN_URL'] = plugin_dir_url( __FILE__ );
  
  include($GLOBALS['CODE9_PLUGIN_DIR'] . 'function/code9_anti_brute_foce.php');

  if(wp_get_current_user()->ID !== 0) {
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'page/dashboard.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'function/code9_menu_page_register.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'function/code9_api.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'function/code9_crypto.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'function/code9_security.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'plugin/security/spa.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'plugin/security/api/security_2_step_key_iv_reset.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'plugin/security/api/security_2_step_update.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'plugin/security/api/security_2_step_blockingtime_update.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'plugin/security/api/security_anti_brute_force_update.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'plugin/security/api/security_anti_brute_force_blocked_remove.php');
    include($GLOBALS['CODE9_PLUGIN_DIR'] . 'plugin/security/api/security_anti_brute_force_logs_get.php');
  }

  unset($NOW);
});

?>