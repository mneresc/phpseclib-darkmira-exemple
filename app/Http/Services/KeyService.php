<?php

namespace App\Http\Services;

use phpseclib\Crypt\RSA;

class KeyService
{
    protected $certsPath;

    /**
     * Criptografia constructor.
     *
     * @param array $config configuracao da aplicacao baseada no crypt.php.dist
     */
    public function __construct()
    {
        $this->certsPath = realpath(__DIR__.'/../../../storage/keys');
    }

    public function genCertByEmail($email): array
    {
        return $this->gerarCertificado($email);
    }

    /**
     * @param string $email
     *
     * @return array
     */
    private function gerarCertificado($email)
    {
        if (!is_writable($this->certsPath)) {
            throw new \BadFunctionCallException("The path {$this->certsPath} isn't writeable", 500);
        }
        /**
         *  Crio uma chave com o formato PKS8.
         */
        $rsa = new RSA();
        $rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_PKCS1);
        $rsa->setPublicKeyFormat(RSA::PRIVATE_FORMAT_PKCS1);
        $rsa->setMGFHash('sha512');
        $keysCertificadoGerado = $rsa->createKey(2048);

        $username = explode('@', $email)[0];
        $pastaUsuario = str_replace('.', '_', $username);
        $path = "{$this->certsPath}/{$pastaUsuario}";

        $keys = [
            'publicKey' => "$path/{$username}.pub",
            'privateKey' => "$path/{$username}.key",
            'path' => $path,
        ];

        //criando arquivos de chave publieca e privada
        if (!$this->isFileExists($keys['path'])) {
            mkdir($keys['path'], 0755, true);
        }

        //chave privada
        $privKey = '';
        if (!$this->isFileExists($keys['privateKey'])) {
            openssl_pkey_export_to_file($keysCertificadoGerado['privatekey'], $keys['privateKey']);
        } else {
            $privKey = file_get_contents($keys['privateKey']);
        }

        //cria chave public
        if (!$this->isFileExists($keys['publicKey'])) {
            $this->writeFile($keys['publicKey'], $keysCertificadoGerado['publickey']);
        }

        return $keys;
    }

    /**
     * @param string $caminhoArquivo
     *
     * @return bool
     */
    public function isFileExists(string $caminhoArquivo)
    {
        if (file_exists($caminhoArquivo)) {
            return true;
        }

        return false;
    }

    /**
     * Lista as pastas dos usuarios que possuem chaves.
     *
     * @return array
     */
    public function listUserPaths(): array
    {
        $path = storage_path('keys');
        if (\is_dir($path)) {
            $directory = glob($path.'/*', GLOB_ONLYDIR);
            $usersPaths = [];
            foreach ($directory as $userPath) {
                $pathSlices = explode('/', $userPath);
                $usersPaths[] = end($pathSlices);
            }
        }

        return $usersPaths;
    }

    /**
     * escreve no arquivo selecionado o conteudo.
     *
     * @param $caminho
     * @param $conteudo
     */
    private function writeFile($path, $content)
    {
        $fp = fopen($path, 'wb');
        fwrite($fp, $content);
        fclose($fp);
        \chmod($path, 0755);
    }
}
