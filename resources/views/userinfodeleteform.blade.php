@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @if(session('message'))
        <div class="error-msg">
            {{ session('message') }}
        </div>
    @endif

    <p>
        <a href={{ route('userinfo') }}>{{ $data['user_name'] }}</a>さん、ユーザ情報を削除します。<br>
        よろしいですか？
    </p>
    
    <form action="" method="post">
        @csrf
        <button type="submit">削除</button>
    </form>

    <div class="action-area">
        <a href="{{ route('top')}}">トップへ戻る
    </div>

@endsection