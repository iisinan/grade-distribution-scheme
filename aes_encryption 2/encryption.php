<?php
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/phpseclib/Autoloader.php");

use phpseclib\Crypt\AES;

class local_grade_encryption_aes_encryption {
    public static function encrypt_grade($grade, $key) {
        $aes = new AES();
        $aes->setKey($key);
        $encrypted_grade = $aes->encrypt($grade);
        return base64_encode($encrypted_grade);
    }

    public static function decrypt_grade($encrypted_grade, $key) {
        $aes = new AES();
        $aes->setKey($key);
        $decrypted_grade = $aes->decrypt(base64_decode($encrypted_grade));
        return $decrypted_grade;
    }
}
