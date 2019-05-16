@extends('layouts.default')
@section('title')
   Generate Key
@stop
@section('content')

<h1 class="jumbotron-heading">@yield('title')</h1>
<form class="col-12" method="POST" action="{{route('key.store')}}">
    @csrf
  <div class="form-group">
  <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Enter email" name="email" value="{{ old('email') }}">
  </div>
  <button type="submit" class="btn btn-primary">Gerar Chaves</button>
</form>
<div class="syntaxhighlighter" style="back-groud">
    {{ $code }}
</div>
@stop
