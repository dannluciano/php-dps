<?php

namespace AES;

class AES {

    const VERSION = "aes-256-cbc";

    private $encryption_key;

    public function __construct($key) {
        if (!function_exists('openssl_random_pseudo_bytes') && !function_exists('mcrypt_create_iv')) {
            throw new \Exception('No backend library found');
        }

        $key = self::base64url_decode($key);

        if (strlen($key) != 32) throw new \Exception('Incorrect key');

        $this->encryption_key = $key;
    }

    public function encrypt($message) {
        $iv = $this->getIV();

        // PKCS7 padding
        $pad = 32 - (strlen($message) % 32);
        $message .= str_repeat(chr($pad), $pad);

        if (function_exists('openssl_encrypt')) {
            $ciphertext = openssl_encrypt($message, 'aes-256-cbc', $this->encryption_key, OPENSSL_ZERO_PADDING, $iv);
        } elseif (function_exists('mcrypt_encrypt')) {
            $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->encryption_key, $message, 'cbc', $iv);
        }

        return self::VERSION . '$' . $iv . '$' . $ciphertext;
    }

    public function decrypt($token) {
        $strs       = split("\\$", $token);
        $iv = $strs[1];
        $ciphertext = $strs[2];

        if (function_exists('openssl_decrypt')) {
            $message = openssl_decrypt($ciphertext, 'aes-256-cbc', $this->encryption_key, OPENSSL_ZERO_PADDING, $iv);
        } elseif (function_exists('mcrypt_decrypt')) {
            $message = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->encryption_key, $ciphertext, 'cbc', $iv);
        }

        $pad = ord($message[strlen($message) - 1]);
        if (substr_count(substr($message, -$pad), chr($pad)) != $pad) return null;

        return substr($message, 0, -$pad);
    }

    /**
     * Generates an initialisation vector for AES encryption
     *
     * @return string a bytestream containing an initialisation
     * vector
     */
    protected function getIV() {
        if (function_exists('random_bytes')) {
            return random_bytes(16);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            return openssl_random_pseudo_bytes(16);
        } elseif (function_exists('mcrypt_create_iv')) {
            return mcrypt_create_iv(16);
        }
    }

    /**
     * Generates a random key for use in Fernet tokens
     *
     * @return string a base64url encoded key
     */
    static public function generateKey() {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $key = openssl_random_pseudo_bytes(32);
        } elseif (function_exists('mcrypt_create_iv')) {
            $key = mcrypt_create_iv(32);
        } else {
            throw new \Exception('No backend library found');
        }
        return self::base64url_encode($key);
    }
    /**
     * Encodes data encoded with Base 64 Encoding with URL and Filename Safe Alphabet.
     *
     * @param string $data the data to encode
     * @param bool $pad whether padding characters should be included
     * @return string the encoded data
     * @link http://tools.ietf.org/html/rfc4648#section-5
     */
    static public function base64url_encode($data, $pad = true) {
        $encoded = strtr(base64_encode($data), '+/', '-_');
        if (!$pad) $encoded = trim($encoded, '=');
        return $encoded;
    }

    /**
     * Decodes data encoded with Base 64 Encoding with URL and Filename Safe Alphabet.
     *
     * @param string $data the encoded data
     * @return string|bool the original data or FALSE on failure. The returned data may be binary.
     * @link http://tools.ietf.org/html/rfc4648#section-5
     */
    static public function base64url_decode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
?>
