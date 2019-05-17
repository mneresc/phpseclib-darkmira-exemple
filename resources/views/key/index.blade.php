@extends('layouts.default')
@section('title')
   Generate Key
@stop
@section('content')

<div class="col-12">
        <form class="col-12" method="POST" action="{{route('key.store')}}">
            @csrf
          <div class="form-group">
          <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Enter email" name="email" value="{{ old('email') }}">
          </div>
          <button type="submit" class="btn btn-primary">Gerar Chaves</button>
        </form>
</div>
@stop

@section('code')
@php

highlight_string('
<?php use phpseclib\Crypt\RSA;
$rsa = new RSA();
$rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_PKCS8);
$rsa->setPublicKeyFormat(RSA::PUBLIC_FORMAT_PKCS8);
$rsa->setMGFHash("sha512");
$keysCertificadoGerado = $rsa->createKey(2048);
//$keysCertificadoGerado[
//"privatekey"=>"---chave privada----",
// "publickey"=>"---chave publica---"
//]')

@endphp
@stop
