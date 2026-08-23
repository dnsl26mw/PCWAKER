<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
    </head>
    <body>
        <header>
            <h1><a href="{{ route('top') }}">PCWAKER</a></h1>
            @auth
            こんにちは、<a href={{ route('userinfo') }}>{{ Auth::user()->name }}</a>さん
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
            @endauth
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
        </footer>
    </body>
</html>