<?php

namespace App\Http\Services;

use phpseclib\Crypt\AES;

class SymmetricService
{
    public function chipherSimetric($text, $user)
    {
        /**
         * Init object with a cipher type.
         */
        $cipher = new AES(AES::MODE_CBC);
        //AES 256
        $cipher->setKeyLength(256);
        $cipher->setKey(sha1(\file_get_contents(storage_path('keys').'/'.$user.'/'.$user.'.key')));

        return base64_encode($cipher->encrypt($text));
    }

    public function dechipherSimetric($text, $user)
    {
        /**
         * Init object with a cipher type.
         */
        $cipher = new AES(AES::MODE_CBC);
        $cipher->setKeyLength(256);
        $cipher->setKey(sha1(\file_get_contents(storage_path('keys').'/'.$user.'/'.$user.'.key')));

        return $cipher->decrypt(\base64_decode($text));
    }

    /**
     * Cifra um texto com AES_CBC chave SHA_256.
     *
     * @param $texto texto decifrado
     * @param $chave
     */
    public function cifrarTexto($texto, $chave)
    {
        $cipher = $this->getAesConfig($chave);

        return base64_encode($cipher->encrypt(base64_encode($texto)));
    }

    /**
     * Decifra  um texto com AES_CBC chave SHA_256.
     *
     * @param $texto texto encrytado
     * @param $chave
     */
    public function decifrarTexto($texto, $chave)
    {
        $cipher = $this->getAesConfig($chave);

        return base64_decode($cipher->decrypt(base64_decode($texto)));
    }

    /**
     * Configura o objeto de cifacao.
     *
     * @param $chave
     *
     * @return AES
     */
    public function getAesConfig($chave)
    {
    }
}
