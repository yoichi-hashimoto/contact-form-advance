@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css')}}">
@endsection

@section('header-content')
<div class="login__item">
<a href="/login" >
    <button class="login__button">login</button>
</a>
</div>
@endsection

@section('content')
<div class="register__section">
<p class="register__title">Register</p>
    <form action="{{ route('register') }}" class="register__form" method="post">
            @csrf
            <div class="register__group">
            <label>お名前</label>
            <input type="text" name="name" class="register__input" placeholder="例:山田　太郎" value="{{ old('name') }}">
            </div>
            @error('name')
            <div class="register__error">{{ $message }}</div>
            @enderror
            <div class="register__group">
            <label>メールアドレス</label>
            <input type="text" name="email" class="register__input" placeholder="例:test@example.com" value="{{ old('email') }}">
            </div>
            @error('email')
            <div class="register__error">{{ $message }}</div>
            @enderror
            <div class="register__group">
            <label>パスワード</label>
            <input type="text" name="password" class="register__input" placeholder="例:coachtech1106">
            </div>
            @error('password')
            <div class="register__error">{{ $message }}</div>
            @enderror
        <div class="register__actions">
            <button type="submit" value="submit" class="register__submit--button">登録</button>
        </div>
    </form>
</div>


@endsection