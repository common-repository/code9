<?php

function code9_encrypt($plaintext, $key, $iv ) {

	return openssl_encrypt($plaintext, 'AES-128-CBC', hex2bin($key), 0, hex2bin($iv));
}

function code9_decrypt($ciphertext, $key, $iv) {
  $decrypted = trim(openssl_decrypt($ciphertext, 'AES-128-CBC', hex2bin($key), 0, hex2bin($iv))); 

  return json_decode($decrypted);
}



?>