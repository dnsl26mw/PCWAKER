@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @error('message')
        <div class="error-msg">
            {{ $message }}
        </div>
    @enderror

    @if(session('message'))
        <div class="error-msg">
            {{ session('message') }}
        </div>
    @endif

    <form action="" method="POST">
        @csrf
        <input type="text" value = "{{ old('email') }}" name="email" placeholder="メールアドレス"><br>
        <input type="password" name="password" placeholder="パスワード"><br>
        <button class="submit-button" type="submit" name="loginBtn">ログイン</button><br> 
    </form>
    
    <div class="action-area">
        <a href="{{ route('userinfo.regist') }}">ユーザー登録はこちら</a>
    </div>

@endsection
