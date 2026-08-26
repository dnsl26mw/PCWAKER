@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @if(isset($data['message']))
        {{ $data['message'] }}
    @endif

    <p>
        <a href={{ route('userinfo') }}>{{ $data['name'] }}</a>さん、ユーザ情報を削除します。<br>
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