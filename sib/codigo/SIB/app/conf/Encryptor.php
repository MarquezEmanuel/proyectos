<?php

class Encryptor {

    private $iv;

    function __construct() {
        $this->iv = NULL;
    }

     function my_encrypt($data, $key) {
        $encryption_key = base64_decode($key);
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $this->iv);
        return base64_encode($encrypted . '::' . $this->iv);
    }

     function my_decrypt($data, $key) {
        $encryption_key = base64_decode($key);
        list($encrypted_data, $this->iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $this->iv);
    }

}
