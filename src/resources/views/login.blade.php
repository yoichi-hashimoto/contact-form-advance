@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css')}}">
@endsection

@section('header-content')
<div class="register__item">
<a href="/register" >
    <button class="register__button">register</button>
</a>
</div>
@endsection

@section('content')
<div class="login__section">
<p class="login__title">Login</p>
    <form action="{{ route('login') }}" class="login__form" method="post">
            @csrf
            <div class="login__group">
            <label>メールアドレス</label>
            <input type="text" class="login__input" placeholder="例:test@example.com" value="{{ old('email') }}" name="email" >
            </div>
            @error('email')
            <div class="login__error">{{ $message }}</div>
            @enderror
            <div class="login__group">
            <label>パスワード</label>
            <input type="text" class="login__input" placeholder="例:coachtech1106" name="password" >
            </div>
            @error('password')
            <div class="login__error">{{ $message }}</div>
            @enderror
        <div class="login__actions">
            <button type="submit" name="remember" class="login__submit--button">ログイン</button>
        </div>
        </div>
        @error('email')
        <div class="login__error">{{ $message }}</div>
        @enderror
    </form>
</div>


@endsection