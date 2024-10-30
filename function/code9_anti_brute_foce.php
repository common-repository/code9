<?php

if(get_option('code9_security_anti_brute_force', '0') === '1') {

  function code9_anti_brute_force_unblock( $user_login, $user ) {
  
    delete_option('code9_anti_brute_force_capha[]' . $user->data->user_login . '[]' . $_SERVER['REMOTE_ADDR'] . '[]capcha1');
    delete_option('code9_anti_brute_force_capha[]' . $user->data->user_login . '[]' . $_SERVER['REMOTE_ADDR'] . '[]capcha2');
    delete_option('code9_anti_brute_force[]' . $user->data->user_login . '[]' . $_SERVER['REMOTE_ADDR'] . '[]attemp');
    
    //Debug empty user
    delete_option('code9_anti_brute_force[][]' . $_SERVER['REMOTE_ADDR'] . '[]attemp');
  }

  add_action('wp_login', 'code9_anti_brute_force_unblock', 10, 2);


  function code9_anti_brute_force($admin, $user, $pass) {

    $NOW['attemp_name'] =  'code9_anti_brute_force[]' . $user . '[]' . $_SERVER['REMOTE_ADDR'] . '[]attemp';
  
    $NOW['attemp_amount'] = get_option($NOW['attemp_name'], 0);
    
    $NOW['attemp_amount']++;
  
    update_option($NOW['attemp_name'], $NOW['attemp_amount']);
  
    if($NOW['attemp_amount'] > 2) {
      $NOW['capcha1_name'] = 'code9_anti_brute_force_capha[]' . $user . '[]' . $_SERVER['REMOTE_ADDR'] . '[]capcha1';
      $NOW['capcha2_name'] = 'code9_anti_brute_force_capha[]' . $user . '[]' . $_SERVER['REMOTE_ADDR'] . '[]capcha2';
  
      $NOW['caphca1'] = get_option($NOW['capcha1_name'], false);
      $NOW['caphca2'] = get_option($NOW['capcha2_name'], false);
      
  
      if(
        isset($_POST['code9-anti-brute-force-capcha1']) === true &&
        isset($_POST['code9-anti-brute-force-capcha2']) === true && 
        $_POST['code9-anti-brute-force-capcha1'] === $NOW['caphca1'] && 
        $_POST['code9-anti-brute-force-capcha2'] === $NOW['caphca2']
      ) {
        
  
        delete_option($NOW['capcha1_name']);
        delete_option($NOW['capcha2_name']);
        delete_option($NOW['attemp_name']);

        //Debug empty user
        delete_option('code9_anti_brute_force[][]' . $_SERVER['REMOTE_ADDR'] . '[]attemp');
  
        return $admin;
      } else {
        
  
        $NOW['caphca1'] = rand ( 1 , 999 );
        $NOW['caphca2'] = rand ( 1 , 999 );
  
        
        update_option($NOW['capcha1_name'], $NOW['caphca1']);
        update_option($NOW['capcha2_name'], $NOW['caphca2']);
  
        $NOW['color_plate'] = [
          ["#000000", "#F5B301"], ["#FF66FF", "#8EACD0"], ["#B3000C", "#00B32C"], ["#800080", "#FFFF00"],
        ];
  
        $NOW['color'] = $NOW['color_plate'][rand(0,3)];
        
        wp_die('<style type="text/css">
        html {
          background: #353941;
        }
  
        body {
          width: 70%;
          max-width: 400px;
          background-color: #26282B;
          background: linear-gradient(135deg, rgba(43,47,54,1) 0%, rgba(29,35,39,1) 100%);
          border-color: #26282B;
          box-shadow: 2px 2px 8px -3px #1d2327;
          border-radius: 4px;
          color: #CECECE;
          padding: 0;
        }
  
        div.wp-die-message {
          margin: 0 !important;
        }
  
        input {
          padding: 10px 15px;
          font-size: 18px;
          text-align: center;
          letter-spacing: 5px;
          -webkit-appearance: none;
          -moz-appearance: none;
          appearance: none;
          background: #26282B;
          display: block;
          width: calc(100% - 30px);
          border: 1px solid #393E46;
          border-radius: 4px;
          color: #F1F2F3;
        }
  
        input:focus, input:active {
          outline: 2px solid #393E46;
  
        }
  
        h2 {
          margin-bottom: 0;
          text-transform: uppercase;
        }
  
        .c9-text-center {
          text-align: center;
        }
  
        .c9-text-right {
          text-align: right;
        }
  
        .c9-flex {
          display: flex;
        }
  
        .c9-flex-grow-1 {
          flex-grow: 1;
        }
  
        .c9-vertical-align-middle > * {
          vertical-align: middle;
        }
  
        
        .c9-margin-top {
          margin-top: 25px;
        }
  
        .c9-padding {
          padding: 25px;
        }
  
  
        .c9-button-default {
          display: inline-block;
          border: 1px solid #888888;
          border-radius: 2px;
          padding: 2px 10px;
          font-size: 11px;
          text-transform: uppercase;
          cursor: pointer;
          transition: all .3s linear;
        }
  
        .c9-button-default:hover {
          color: #f0f0f1 !important;
          border: 1px solid #f0f0f1;
        }
  
        .c9-button-default:hover > svg {
          fill: #f0f0f1;
  
        }
        
        .c9-text-red {
          color: #b32d2e;
        }
  
        #c9-button-retry {
          margin-top: 20px;
          height: 50px;
          line-height: 50px;
          display: block;
          -webkit-appearance: none;
          -moz-appearance: none;
          appearance: none;
          width: 100%;
          border: 0;
          background: #2271b1;
          border-radius: 4px;
          text-transform: uppercase;
          font-size: 18px;
          font-weight: bold;
          color: #FFFFFF;
          cursor: pointer;
          transition: all .3s linear;
          font-weight: bold;
        }
  
        #c9-button-retry:hover {
          background: #071C21;
          color: #2271b1;
        }
  
        #c9-button-retry:focus, #c9-button-retry:active {
          background: #353941;
          color: #72aee6;
        }
        </style>
        <form method="POST">
          <div class="c9-padding c9-text-center">
            <h2>' . __('You have been block', 'c9') . '</h2>
            <p>Input numbers below to unlock</p>
            <div id="c9-canvas-container"></div>
            <input type="text" name="code9-anti-brute-force-capcha1" class="c9-margin-top" placeholder="' . __('Numbers upper line', 'c9') . '" />
            <input type="text" name="code9-anti-brute-force-capcha2"" class="c9-margin-top" placeholder="' . __('Numbers lower line', 'c9') . '" />
            <input type="hidden" name="log" value="' . $user . '" />
            ' . (isset($_POST['code9-anti-brute-force-capcha1']) === true ? '<div class="c9-text-red c9-margin-top">' . __('Incorrect numbers','c9') . '</div>' : "" ) . '
            </div>
            <button id="c9-button-retry" type="submit">' . __('Submit') . '</button>
        </form>
        
        <script type="text/javascript">
        (function(){
          var _random_type = ["fillText", "strokeText"];
          var _random_size = ["2em sans-serif", "5em Verdana"];
  
          var _cvd = document.createElement("canvas");
  
          _cvd.width = "200";
          _cvd.height = "200";
          
          document.getElementById("c9-canvas-container").appendChild(_cvd);
  
          _cv = _cvd.getContext("2d");
  
          _cv.fillStyle = "' . $NOW['color'][1] . '";
          _cv.fillRect(0, 0, _cvd.width, _cvd.height);
  
          _cv.font = _random_size[Math.round(Math.random())];
          _cv.textAlign = "center";
          _cv.fillStyle = "' . $NOW['color'][0] . '";
          _cv.strokeStyle = "' . $NOW['color'][0] . '";
          _cv[_random_type[Math.round(Math.random())]]("'. $NOW['caphca1'] .  '", _cvd.width/2, 80);
  
          _cv.font = _random_size[Math.round(Math.random())];
          _cv.fillStyle = "' . $NOW['color'][0] . '";
          _cv.strokeStyle = "' . $NOW['color'][0] . '";
          _cv[_random_type[Math.round(Math.random())]]("' . $NOW['caphca2'] .  '", _cvd.width/2, 150);
  
  
        })();
  
        </script>', __("You have been block", "c9") . " - Code9", [
          "response"=> 403
        ]);
  
        
  
        
        $pass = 'Code9 Block Password';
  
        return null;
      }
  
  
  
  
    }
  
  
    unset($NOW);
  
    return $admin;
  }
  
  add_filter( 'authenticate', 'code9_anti_brute_force', 1, 3 );
}


?>