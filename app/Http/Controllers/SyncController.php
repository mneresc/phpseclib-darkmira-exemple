<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\KeyService;
use App\Http\Services\SymmetricService;

class SyncController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyService = new KeyService();
        $usersPaths = $keyService->listUserPaths();

        return  view('sync.index')->with(['result' => '',  'resultChipher' => $resultChipher = '', 'usersPaths' => $usersPaths]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function encrypt(Request $request)
    {
        $dados = request()->all();
        $validate = [
            'userEncrypt' => 'required',
            'plaintext' => 'required',
            'userEncrypt' => 'required',
        ];

        request()->validate($validate);
        $sync = new SymmetricService();

        /**
         * feed the variable (this application is just a test).
         */
        $result = $sync->chipherSimetric($dados['plaintext'], $dados['userEncrypt']);
        $keyService = new KeyService();
        $usersPaths = $keyService->listUserPaths();

        return  view('sync.index')->with(['result' => '',  'result' => $result, 'resultChipher' => $resultChipher = '', 'usersPaths' => $usersPaths]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function decrypt(Request $request)
    {
        $dados = request()->all();
        $validate = [
            'userDecrypt' => 'required',
            'ciphertext' => 'required',
        ];

        request()->validate($validate);
        $sync = new SymmetricService();
        $resultChipher = $sync->dechipherSimetric($dados['ciphertext'], $dados['userDecrypt']);
        /*
         * feed the variable (this application is just a test).
         */

        $keyService = new KeyService();
        $usersPaths = $keyService->listUserPaths();
        if (!$resultChipher) {
            $request->session()->flash('alert-danger', 'Could not decrypt for user '.$dados['userDecrypt']);
        }

        return  view('sync.index')->with(['result' => '',  'result' => $result = '', 'resultChipher' => $resultChipher, 'usersPaths' => $usersPaths]);
    }
}
