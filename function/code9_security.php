<?php

if (get_option('code9_security_key', false) === false) {
    update_option('code9_security_key', bin2hex(openssl_random_pseudo_bytes(16)));
}

if (get_option('code9_security_iv', false) === false) {
    update_option('code9_security_iv', bin2hex(openssl_random_pseudo_bytes(16)));
}

function code9_security_encrypt($plaintext, $key, $iv)
{
    if (!$key) {
        $key = hex2bin(get_option('code9_security_key', false));
    }

    if (!$iv) {
        $iv = hex2bin(get_option('code9_security_iv', false));
    }

    return openssl_encrypt($plaintext, 'AES-256-CBC', $key, 0, $iv);
}

function code9_security_decrypt($ciphertext, $key, $iv)
{
    if (!$key) {
        $key = hex2bin(get_option('code9_security_key', false));
    }

    if (!$iv) {
        $iv = hex2bin(get_option('code9_security_iv', false));
    }

    return trim(openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv));
}

if (isset($_COOKIE['code9_security_public']) !== true) {
    setcookie('code9_security_public', code9_security_encrypt(json_encode([
        "host_name" => $_SERVER["SERVER_NAME"],
        // "remote_ip" => $_SERVER["REMOTE_ADDR"],
        "request_time" => $_SERVER["REQUEST_TIME"],
    ]), false, false), 0, "/", "", false, false);
}

function code9_security_public_unset()
{
    unset($_COOKIE['code9_security_public']);
    setcookie('code9_security_public', '', time() - 3600, '/');
}

if (get_option('code9_security_2_step', '0') === '1') {

    function code9_security_2_step_middleware($admin_id)
    {
        if ($admin_id) {

          $c9_error_css = '<style type="text/css">
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
  
          h1, h2 {
            margin-bottom: 0;
            text-transform: uppercase;
            color: #F1F2F3;
            text-align: center;
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
  
          .c9-link-reset {
            color: inherit;
            text-decoration: inherit;
          }
  
          .c9-link-reset:hover {
            color: inherit;
          }
  
          .c9-text-meta {
            color: #888888;
          }
  
          .c9-text-red {
            color: #b32d2e;
          }
  
          .c9-margin-top {
            margin-top: 25px;
          }
  
          .c9-padding {
            padding: 25px;
          }
  
          #c9-security-logo-wrapper {
            margin: auto;
            display: inline-block;
            width: 100px;
            height: 100px;
            background-color: #393E46;
            border-radius: 50px;
            text-align: center;
            line-height: 100px;
            font-size: 70px;
            outline: 2px dashed #393E46;
            outline-offset: 5px;
            margin-bottom: 10px;
            margin-top: 30px;
          }
  
          #c9-security-logo {
            display: inline-block;
            width: 60px;
            height: 60px;
            fill: #CECECE;
          }
  
          #c9-2-step-1-button, .c9-button {
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
            text-align: center;
            text-decoration: none;
          }
  
          #c9-2-step-1-button:hover, .c9-button:hover {
            background: #071C21;
            color: #2271b1;
          }
  
          #c9-2-step-1-button:focus, #c9-2-step-1-button:active, .c9-button:focus, .c9-button:active {
            background: #353941;
            color: #72aee6;
          }
        </style>';

            session_start();

            try {
                if (isset($_COOKIE['code9_security_public']) !== true) {

                    throw new Exception('Wrong cookie');
                } else {
                    $data_decrypt = json_decode(code9_security_decrypt($_COOKIE['code9_security_public'], false, false));

                    if (!$data_decrypt) {
                        code9_security_public_unset();

                        throw new Exception('Wrong crypto decrypt');
                    } else {

                        if (isset($data_decrypt->host_name) !== true || $data_decrypt->host_name !== $_SERVER['SERVER_NAME']) {
                            code9_security_public_unset();

                            throw new Exception('Wrong server name');
                        } 
                        /*
                        else if (isset($data_decrypt->remote_ip) !== true || $data_decrypt->remote_ip !== $_SERVER['REMOTE_ADDR']) {
                            code9_security_public_unset();

                            throw new Exception('Wrong security ip');
                        } 
                        */
                        else {
                            if (isset($_SESSION['code9_security_auth_' . $admin_id]) !== true || $_SESSION['code9_security_auth_' . $admin_id] !== $_COOKIE['code9_security_public']) {
                                throw new Exception('2step-code9');
                            } else {
                                return;
                            }
                        }

                    }
                }
            } catch (Exception $error) {

                if ($error->getMessage() === '2step-code9') {

                    if (isset($_SESSION['code9_security_auth_' . $admin_id . '_block_time']) === true && $_SESSION['code9_security_auth_' . $admin_id . '_block_time'] !== null  && $_SESSION['code9_security_auth_' . $admin_id . '_block_time'] > time()) {

                        wp_die($c9_error_css . '<div class="c9-padding"><h1>' . __('Account locked!', 'c9') . '</h1><p class="c9-text-center"><span id="c9-countdown-container">Wait</span> until account unlock.</p><script type="text/javascript">
                    (function(){
                      var _time = ' . ($_SESSION['code9_security_auth_' . $admin_id . '_block_time'] - time()) . ';
                      var _interval = setInterval(function() {
                        _time = _time - 1;
                        document.getElementById("c9-countdown-container").innerText =  _time + " seconds";

                        if(_time <= 0) {
                          clearInterval(_interval);
                          window.location.reload();
                        }
                      }, 1000);
                    })();

                    </script><p class="c9-text-right"><a href="' . wp_logout_url('') . '">' . __('Sign out', 'c9') . '</a></p></div>', __("Account has been block", "c9") . " - Code9");

                    }

                    if (isset($_POST['c9-sucure-salts']) === true && isset($_POST['c9-sucure-iv']) === true) {
                        $data_post = json_decode(base64_decode(code9_security_decrypt(base64_decode($_POST['c9-sucure-salts']), false, hex2bin(base64_decode($_POST['c9-sucure-iv'])))));

                        try {
                            if (!$data_post) {
                                throw new Exception('Error can not decrypt salts');
                            } else {
                                if (isset($data_post->type) !== true) {
                                    throw new Exception('Wrong format');
                                } else if ($data_post->admin_id != $admin_id) {
                                    throw new Exception('Wrong login');
                                } else if ($data_post->host_name !== $_SERVER["SERVER_NAME"] /*|| $data_post->remote_ip !== $_SERVER["REMOTE_ADDR"]*/ || $data_post->request_uri !== $_SERVER["REQUEST_URI"]) {
                                    throw new Exception('Wrong host name');
                                } else if (time() - $data_post->request_time > 300) {
                                    throw new Exception('Time out');
                                } else {
                                    if ($data_post->type === 'register') {
                                        update_option('code9_security_auth_' . $admin_id, password_hash($_POST['c9-code'], PASSWORD_DEFAULT));

                                        $_SESSION['code9_security_auth_' . $admin_id] = $_COOKIE['code9_security_public'];
                                    } else if ($data_post->type === 'login') {
                                        if (password_verify($_POST['c9-code'], get_option('code9_security_auth_' . $admin_id)) === true) {
                                            $_SESSION['code9_security_auth_' . $admin_id] = $_COOKIE['code9_security_public'];

                                            $_SESSION['code9_security_auth_' . $admin_id . '_attemp'] = null;
                                            $_SESSION['code9_security_auth_' . $admin_id . '_block_time'] = null;
                                        } else {
                                            if (isset($_SESSION['code9_security_auth_' . $admin_id . '_attemp']) !== true || $_SESSION['code9_security_auth_' . $admin_id . '_attemp'] === null) {
                                                $_SESSION['code9_security_auth_' . $admin_id . '_attemp'] = 0;
                                            }

                                            $_SESSION['code9_security_auth_' . $admin_id . '_attemp']++;

                                            if ($_SESSION['code9_security_auth_' . $admin_id . '_attemp'] > 3) {
                                                $_SESSION['code9_security_auth_' . $admin_id . '_block_time'] = time() + intval(get_option('code9_security_2_step_blockingtime', '180'));

                                                throw new Exception('Your account has been temporarily locked');
                                            } else {
                                                throw new Exception('Wrong 2-step verification code');
                                            }

                                        }
                                        ;
                                    } else {
                                        throw new Exception('Wrong type');
                                    }

                                }
                            }
                        } catch (Exception $error) {

                            wp_die($c9_error_css . "<div class=\"c9-padding\"><h1>{$error->getMessage()}</h1><p><a class=\"c9-button\" href=\".\">" . __("Try again", 'c9') . "</a></p></div>", $error->getMessage() . " - Code9");
                        }

                        return;
                    }

                    ob_start();
                    echo $c9_error_css;
                    ?>
      
        
      <form method="post" autocomplete="off">
        <div class="c9-padding">
        <div class="c9-flex">
          <div class="c9-flex-grow-1">
            <a href="<?php echo wp_logout_url(''); ?>" class="c9-vertical-align-middle c9-button-default c9-link-reset">
              <svg xmlns="http://www.w3.org/2000/svg" height="11px" viewBox="0 0 24 24" width="11px" fill="#CECECE"><path d="M0 0h24v24H0z" fill="none"/><path d="M11.67 3.87L9.9 2.1 0 12l9.9 9.9 1.77-1.77L3.54 12z"/></svg>
              <span><?php echo __('Sign out'); ?></span>
            </a>
          </div>
          <div class="c9-flex-grow-1 c9-vertical-align-middle c9-text-right">
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#CECECE"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            <span><?php echo get_the_author_meta('nickname', $admin_id); ?></span>
          </div>
        </div>
        <div class="c9-text-center">
          <div id="c9-security-logo-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="c9-security-logo"><path d="M0 0h24v24H0z" fill="none"/><path d="M12.65 10C11.83 7.67 9.61 6 7 6c-3.31 0-6 2.69-6 6s2.69 6 6 6c2.61 0 4.83-1.67 5.65-4H17v4h4v-4h2v-4H12.65zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
          </div>
        </div>
  <?php

                    $iv = openssl_random_pseudo_bytes(16);

                    $salts_array = [
                        "host_name" => $_SERVER["SERVER_NAME"],
                        // "remote_ip" => $_SERVER["REMOTE_ADDR"],
                        "request_time" => $_SERVER["REQUEST_TIME"],
                        "request_uri" => $_SERVER["REQUEST_URI"],
                        "admin_id" => $admin_id,
                    ];

                    if (get_option('code9_security_auth_' . $admin_id, false) === false) {
                        $salts_array["type"] = "register";
                        ?>
    <h2 class="c9-text-center"><?php echo __(' 2 step first time', 'c9'); ?></h2>
    <div class="c9-text-center c9-text-meta"><?php echo __('Setup 2 step verification for next sign in', 'c9'); ?></div>
    <script type="text/javascript">
    window.addEventListener('load', function() {
      var _code = null;

      document.getElementsByTagName('form')[0].addEventListener('submit', function(event) {
        document.getElementById('c9-2-step-error-container').innerHTML = '';

        var _dom = document.getElementsByName('c9-code')[0];

        try {
          if(_dom.value.length < 6) {
            throw new Error("<?php echo __('Code must be at least 6 characters', 'c9'); ?>")
          } else if(_code === null) {
            _code = _dom.value;
            _dom.value = '';
            _dom.setAttribute('placeholder', 'CONFIRM CODE');

            document.getElementById('c9-2-step-1-button').innerText = "<?php echo __('Finish'); ?>";

            event.preventDefault();
          } else if(_code !== _dom.value) {
            throw new Error("<?php echo __('Code does not match', 'c9'); ?>");
          } else {
            document.getElementsByTagName('form')[0].submit();
          }

        } catch(error) {
          event.preventDefault();
          document.getElementById('c9-2-step-error-container').innerHTML = `<div class="c9-padding c9-text-center c9-text-red">${error.message}</div>`;
        }

        return;
      })
    });
    </script>
  <?php
} else {
                        $salts_array["type"] = "login";
                        ?>
  <h2 class="c9-text-center"><?php echo __(' 2 step code', 'c9'); ?></h2>
  <?php
}
                    ?>
  <input type="password" name="c9-code" placeholder="CODE" class="c9-margin-top" autocomplete="off" tabindex="1" />
  <div id="c9-2-step-error-container"></div>
  <button type="submit" id="c9-2-step-1-button"><?php echo __('Confirm', 'c9'); ?></button>
  </div>
  <input type="hidden" name="c9-sucure-salts" value="<?php echo base64_encode(code9_security_encrypt(base64_encode(json_encode($salts_array)), false, $iv)); ?>" />
  <input type="hidden" name="c9-sucure-iv" value="<?php echo base64_encode(bin2hex($iv)); ?>" />
  </form>

  <?php
$content = ob_get_contents();

                    ob_end_clean();

                    wp_die($content, __('2 step verification', 'c9') . ' - Code9', [
                        "response" => 200,
                    ]);
                } else {
                    wp_die( $c9_error_css . "<div class=\"c9-padding\"><h1>{$error->getMessage()}</h1><p class=\"c9-text-center\">" . __("Maybe you are forced to logout. Reload page to continue.") . "</p><a class=\"c9-button\" href=\".\">" . __("Reload page", 'c9') . "</a></div>");
                }

            }

        }

        return;
    }

    add_action('auth_redirect', 'code9_security_2_step_middleware');

    function code9_security_2_step_logout()
    {
        session_start();

        $_SESSION['code9_security_auth_' . get_current_user_id()] = 'SIGNOUT';

    }

    add_action('clear_auth_cookie', 'code9_security_2_step_logout');

    function code9_security_2_step_code_edit()
    {
        ?>
      <table class="form-table" role="presentation">
      <tbody>
        <tr class="user-pass1-wrap">
          <th><label>2 Step Code</label></th>
          <td>
            <button type="button" class="button hide-if-no-js" aria-expanded="false" id="c9-2-step-code-set-button"><?php echo __('Set New 2 Step Code', 'c9'); ?></button>
            <div id="c9-2-step-code-container" class="hide-if-js">
              <input type="password" name="c9-2-step-code" class="regular-text" style="margin-bottom: 5px;">
              <button type="button" class="button hide-if-no-js" aria-expanded="false" id="c9-2-step-code-close-button"><?php echo __('Cancel', 'c9'); ?></button>
              <div id="c9-2-step-code-error-container"></div>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <script type="text/javascript">
      (function() {
        document.getElementById('c9-2-step-code-set-button').addEventListener('click', function(event) {
          event.target.style.display = 'none';
          document.getElementById('c9-2-step-code-container').style.display = "block";
        });

        document.getElementById('c9-2-step-code-close-button').addEventListener('click', function(event) {
          document.getElementById('c9-2-step-code-set-button').removeAttribute("style");
          document.getElementById('c9-2-step-code-container').removeAttribute("style");
          document.getElementsByName('c9-2-step-code')[0].value = "";

          document.getElementById("c9-2-step-code-error-container").innerHTML = "";
        });

        document.getElementById('your-profile').addEventListener('submit', function(event) {
          document.getElementById("c9-2-step-code-error-container").innerHTML = "";
          var _input = document.getElementsByName('c9-2-step-code');

          if(_input[0].value !== '' && _input[0].value.length < 6) {
            event.preventDefault();
            document.getElementById("c9-2-step-code-error-container").innerHTML = "<p style=\"color: #b32d2e;\"><?php echo __('Code must be at least 6 characters', 'c9'); ?></p>";
          };

          return;
        });
      })();
      </script>
        <?php
}

    add_action('edit_user_profile', 'code9_security_2_step_code_edit');
    add_action('show_user_profile', 'code9_security_2_step_code_edit');

    function code9_security_2_step_code_edit_update()
    {
        if (isset($_POST['c9-2-step-code']) === true && strlen($_POST['c9-2-step-code']) >= 6) {
            update_option('code9_security_auth_' . $_POST['user_id'], password_hash($_POST['c9-2-step-code'], PASSWORD_DEFAULT));
        }
    }

    add_action('personal_options_update', 'code9_security_2_step_code_edit_update');
    add_action('edit_user_profile_update', 'code9_security_2_step_code_edit_update');
}

