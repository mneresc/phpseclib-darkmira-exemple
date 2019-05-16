<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\KeyService;

class KeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $code = highlight_string('<?php use phpseclib\Crypt\RSA;
        $rsa = new RSA();
        $rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_PKCS8);
        $rsa->setPublicKeyFormat(RSA::PUBLIC_FORMAT_PKCS8);
        $rsa->setMGFHash("sha512");
        $keysCertificadoGerado = $rsa->createKey(2048);
        //$keysCertificadoGerado["privatekey"=>"---chave privada----", "publickey"=>"---chave publica---"]');

        return  view('key.index')->with('code', $code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = [
            'email' => 'required|email',
        ];

        request()->validate($validate);

        $keyGen = new KeyService();
        $userCerts = $keyGen->genCertByEmail($request->all()['email']);

        $zipFileName = 'certs.zip';
        $zip = new \ZipArchive();
        if ($zip->open($userCerts['path'].'.zip', \ZipArchive::CREATE) === true) {
            // Add File in ZipArchive
            $options = array('remove_all_path' => true);
            $zip->addGlob($userCerts['path'].'/*.{key,pub}', GLOB_BRACE, $options);
            $zip->close();
        }
        // Set Header
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath = $userCerts['path'].'.zip';
        // Create Download Response
        if (file_exists($filetopath)) {
            return  response()->download($filetopath, $zipFileName, $headers);
        }

        $request->session()->flash('alert-success', 'Key generated with success.');
    }
}
