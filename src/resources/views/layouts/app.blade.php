<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}" />
    <link rel="stylesheet" href="{{asset('css/app.css')}}" />
    @yield('css')
</head>
@livewireStyles
<body>
    <header class="header">
        <a class="header__logo" href="/">FashionablyLate</a>
        @yield('header-content')
    </header>
    <main>
        @yield('content')
    </main>
</body>
@livewireScripts
</html>