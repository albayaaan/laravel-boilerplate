@extends('auth.layouts.auth')

@section('body_class','login')

@section('content')
<div class="">
    {!! $QR_Image !!}
</div>
<div class="">
    <a href="/"><button class="btn-primary">Complete Registration</button></a>
</div>
@endsection