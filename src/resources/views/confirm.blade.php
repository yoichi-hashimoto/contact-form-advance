@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/confirm.css')}}">
@endsection

@section('content')
<p class="confirm__title">Confirm</p>
<div class="confirm__content">
    <form action="/contacts/store" method="post">
        @csrf
        <table class="confirm__table">
            <tr>
                <th class="confirm__item">お名前
                <td>{{ $fullName }}</td>
            </th>
        </tr>
        <tr>
            <th class="confirm__item">性別</th>
            <td>{{ $validated['gender'] }}</td>
        </tr>
        <tr>
            <th class="confirm__item">メールアドレス</th>
             <td>{{ $validated['email'] }}</td>
        </tr>
        <tr>
            <th class="confirm__item">電話番号</th>
             <td>{{ $fullTel }}</td>
        </tr><tr>
            <th class="confirm__item">住所</th>
             <td>{{ $validated['address'] }}</td>
        </tr><tr>
            <th class="confirm__item">建物名</th>
             <td>{{ $validated['building'] ?? '未入力' }}</td>
        </tr><tr>
            <th class="confirm__item">お問い合わせの種類</th>
             <td>{{ $categoryLabel }}</td>
        </tr><tr>
            <th class="confirm__item">お問い合わせ内容</th>
             <td>{{ $validated['detail'] }}</td>
        </tr>
    </table>

    @foreach($validated as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    
    <div class="confirm__submit">
        <button name="action" value="submit" class="confirm__submit--send" type="submit">送信</button>
        <button name="action" value="rewrite" class="confirm__submit--rewrite" type="submit">修正</button>
    </div>
    </form>
</div>
@endsection