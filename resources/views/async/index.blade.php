@extends('layouts.default')
@section('title')
   Assymmetric
@stop
@section('content')

<div class="col-6">
        <h4 class="jumbotron-heading">Encrypt</h4>
        <form class="col-12" method="POST" action="{{route('assymmetric.encrypt')}}">
            @csrf
            <div class="form-group">
                    <select class="form-control" id="userEncrypt" name="userEncrypt">
                        <option value="">Select user</option>
                        @foreach ($usersPaths as $path)
                    <option value="{{ $path }}"> {{ $path }} </option>
                        @endforeach
                    </select>
                  </div>
          <div class="form-group">
          <input type="text" class="form-control" id="plaintext" aria-describedby="plaintext" placeholder="Enter plain text" name="plaintext" value="{{ old('text') }}">
          @if ($errors->has('plaintext'))
                <span class="help-block text-danger">
                            <strong>{{ $errors->first('plaintext') }}</strong>
                        </span>
                @endif
          </div>
           <div class="form-group">
                <input type="result" class="form-control" id="result" aria-describedby="result" placeholder="Result" name="result" value="{{ $result }}" readonly>
            </div>

          <button type="submit" class="btn btn-primary">Encrypt</button>
        </form>
</div>

<div class="col-6">
        <h4 class="jumbotron-heading">Decrypt</h4>

        <form class="col-12" method="POST" action="{{ route('assymmetric.decrypt') }}">
                @csrf
                <div class="form-group">
                        <select class="form-control" id="userDecrypt" name="userDecrypt">
                            <option value=""> Select user</option>
                            @foreach ($usersPaths as $path)
                        <option value="{{ $path }}"> {{ $path }} </option>
                            @endforeach
                        </select>
                      </div>
          <div class="form-group">
          <input type="text" class="form-control" id="ciphertext" aria-describedby="ciphertext" placeholder="Enter chiper text" name="ciphertext" value="{{ old('text') }}">
          </div>
           <div class="form-group">
                <input type="result" class="form-control" id="resultcipher" aria-describedby="resultcipher" placeholder="Result" name="resultcipher" value="{{ $resultChipher }}" readonly>
            </div>

          <button type="submit" class="btn btn-primary">Decrypt</button>
        </form>
</div>

@stop

@section('code')
@php

highlight_string('
<?php
/**
* Encrypt
*/
$cipher = new AES(AES::MODE_CBC);
$cipher->setKeyLength(256);
$cipher->setIV(Random::string($cipher->getBlockLength() >> 3));
$cipher->setKey(/path/to/keys/file.key);
return base64_encode($cipher->encrypt($text));


/**
* Dencrypt
*/
$cipher = new AES(AES::MODE_CBC);
$cipher->setKeyLength(256);
$cipher->setIV(Random::string($cipher->getBlockLength() >> 3));
$cipher->setKey(/path/to/keys/file.key);
return base64_encode($cipher->encrypt($text));')

@endphp
@stop
