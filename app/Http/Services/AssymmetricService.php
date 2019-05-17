<?php

namespace App\Http\Services;

use phpseclib\Crypt\RSA;

class AssymmetricService
{
    public function chipherAssimetric($text, $user)
    {
        $rsa = new RSA();
        $rsa->loadKey(\file_get_contents(storage_path('keys').'/'.$user.'/'.$user.'.pub'));
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $ciphertext = $rsa->encrypt($text);

        return base64_encode($ciphertext);
    }

    public function dechipherSimetric($text, $user)
    {
        $rsa = new RSA();
        $rsa->loadKey(\file_get_contents(storage_path('keys').'/'.$user.'/'.$user.'.key'));
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);

        return $rsa->decrypt(\base64_decode($text));
    }
}
