<?php

namespace App\Encryption;

class WSencrypt {
    
    public static function wsencrypt($data,$key,$iv){
        
        $plaintext = base64_encode(json_encode($data));
        $cipher="AES-128-CBC";
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode($iv.$hmac.$ciphertext_raw );
        return $ciphertext;
        
	}

    public static function wsencrypt2($data, $secretKey, $productKey)
    {
        $plaintext = base64_encode(json_encode($data));
        $cipher = "AES-256-CBC";
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $secretKey, NULL, $productKey);
    
        $hmac = hash_hmac('sha256', $ciphertext_raw, $secretKey, true);
    
        $ciphertext = base64_encode($productKey . $hmac . $ciphertext_raw);
    
        return $ciphertext;
    }
}

