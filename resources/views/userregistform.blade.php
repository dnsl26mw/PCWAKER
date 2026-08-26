@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @if(isset($data['message']))
        {{ $data['message'] }}
    @endif

    <form action="" method="POST">
        @csrf
        <input type="text" value="{{$data['email']}}" name="email" placeholder="メールアドレス"><br>
        <input type="password" name="password" placeholder="パスワード"><br>
        <input type="text" value = "{{$data['user_name']}}" name="user_name" placeholder="ユーザー名"><br>
        <button class="submit-button" type="submit" name="userRegistBtn" id="userRegistBtn">登録</button><br>
    </form>
    
    <div class="action-area">
        <a href="{{ route('login') }}">ログイン画面へ戻る</a><br>   
    </div>

@endsection
