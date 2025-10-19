@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<p class="contact__title">contact</p>
<div class="contact__form">
<form action="/confirm" method="post" class="form">
@csrf
    <div class="form__grid">
    <label class="form-label">お名前※</label>
    <div class="form__control">
        <div class="form__name">
        <div>
        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="例 ）山田" class="name__input-box">
        @error('last_name')
        <div class="form__error">{{ $message }}</div>
        @enderror
        </div>
        <div>
        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="例）太郎" class="name__input-box">

        @error('first_name')
        <div class="form__error">{{ $message }}</div>
        @enderror
        </div>
        </div>
    </div>
    <label class="form-label">性別※</label>
        <div class="form__control">
        <div class="gender-options">
        <label><input type="radio" name="gender" value="男性" @checked(old('gender') == '男性') class="gender-select">男性</label>
        <label><input type="radio" name="gender" value="女性" @checked(old('gender') == '女性') class="gender-select">女性</label>
        <label><input type="radio" name="gender" value="その他" @checked(old('gender') == 'その他') class="gender-select">その他</label>
        </div>
        @error('gender')
        <div class="form__error">{{ $message }}</div>
        @enderror
    </div>
    <label class="form-label" for="email">メールアドレス※</label>
    <div class="form__control">
        <input type="text" name="email" value="{{ old('email') }}" placeholder="test@example.com" class="input-box" >
    @error('email')
        <div class="form__error">{{ $message }}</div>
    @enderror
    </div>
    <label class="form-label" for="tel">電話番号※</label>
    <div class="form__control">
        <div class="phone-group">
        <input type="text" name="tel1" value="{{ old('tel1') }}" class="input-box" placeholder="080" maxlength="4" pattern="\d{2,4}" >
        @error('tel1')
        <div class="form__error">{{ $message }}</div>
        @enderror
         - <input type="text" name="tel2" value="{{ old('tel2') }}" class="input-box" placeholder="1234" maxlength="4" pattern="\d{2,4}" >
         @error('tel2')
        <div class="form__error">{{ $message }}</div>
        @enderror
        - <input type="text" name="tel3" value="{{ old('tel3') }}" class="input-box" placeholder="5678" maxlength="4" pattern="\d{2,4}" >
        @error('tel3')
        <div class="form__error">{{ $message }}</div>
        @enderror
        </div>
    </div>
    <label class="form-label" for="address">住所※</label>
        <div class="form__control">
        <input type="text" name="address" value="{{ old('address') }}" placeholder="例 東京都渋谷区千駄ヶ谷1-2-3" class="input-box" >
        @error('address')
        <div class="form__error">{{ $message }}</div>
        @enderror
        </div>
    <label class="form-label" for="building">建物名※</label>
        <div class="form__control">
        <input type="text" name="building" value="{{ old('building') }}" placeholder="例）ビル名" class="input-box" >
        @error('building')
        <div class="form__error">{{ $message }}</div>
        @enderror
    </div>
    <label class="form-label" for="category">お問い合わせの種類※</label>
        <div class="form__control">
        <select name="category_id" id="category_id" class="input-box" >
            <option value="">選択してください</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id') == $category)> {{ $category->content }}</option>
            @endforeach
        </select>
        @error('category_id')
        <div class="form__error">{{ $message }}</div>
        @enderror
    </div>
    <label class="form-label" for="detail">お問い合わせ内容※</label>
        <div class="form__control">
        <textarea name="detail" id="detail" class="contact__text" placeholder="お問い合わせ内容をご記載ください" >{{ old('detail') }}</textarea>
        @error('detail')
        <div class="form__error">{{ $message }}</div>
        @enderror
        </div>
    <div class="form-actions">
        <button type="submit" value="確認画面" class="confirm__submit--button" >確認画面</button>
    </div>
    </div>
</form>
</div>
@endsection