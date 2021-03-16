<?php

namespace App\Encryption;

class WSdecrypt
{

    public static function WSdecrypt($encrypted, $key, $iv)
    {
        try {

            $c = base64_decode($encrypted);
            $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
            $iv2 = substr($c, 0, $ivlen);
            if ($iv2 != $iv) {
                return "Sign error";
            } else {
                $hmac = substr($c, $ivlen, $sha2len = 32);
                $ciphertext_raw = substr($c, $ivlen + $sha2len);
                $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
                $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
                if (hash_equals($hmac, $calcmac)) //PHP 5.6+ timing attack safe comparison
                {
                    return base64_decode($original_plaintext);
                } else {
                    return "Sign error";
                }
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return "Sign error";
        }
    }

    function WSdecrypt2($encrypted, $key, $iv)
    {
        try {

            $c = base64_decode($encrypted);
            $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
            $iv2 = substr($c, 0, $ivlen);

            if ($iv2 != $iv) {
                return "Sign error";
            } else {

                $hmac = substr($c, $ivlen, $sha2len = 32);

                $ciphertext_raw = substr($c, $ivlen + $sha2len);

                $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, NULL, $iv);

                $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);

                // echo "<script>console.log('" . $calcmac . "' );</script>";
                if (hash_equals($hmac, $calcmac)) {
                    return base64_decode($original_plaintext);
                } else {
                    return "Sign error";
                }
            }
        } catch (\Exception $e) {
            return "Sign error";
        }

        // Sign error : your secretKey or productKey is invalid
    }
}
