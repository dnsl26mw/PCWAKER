<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/style.css">
        <title>PCWAKER - @yield('title')</title>
    </head>
    <body>
        <header>
            <h1><a href="{{ route('top') }}">PCWAKER</a></h1>
            @auth
            <div class="header-right">
                <span class="user-info">
                    こんにちは、<a href={{ route('userinfo') }}>{{ Auth::user()->name }}</a>さん
                </span>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="logout-button" type="submit" name="logoutBtn" class="logoutBtn">ログアウト</button>
                </form>
            </div>
            @endauth
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            <small>
                Copyright© 2026 MasayukiHoshikawa All rights reserved.
            </small>
        </footer>
    </body>
</html>