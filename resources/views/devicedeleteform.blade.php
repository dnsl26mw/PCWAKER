@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @if(isset($data['message']))
        {{ $data['message'] }}
    @endif

    <p>
        デバイスIDが<a href={{ route('deviceinfo', ['device_id' => $data['device_id']]) }}>{{ $data['device_id'] }}</a>のデバイス情報を削除します。
        よろしいですか？
    </p>
    
    <form action="" method="post">
        @csrf
        <button type="submit">削除</button>
    </form>

    <div class="action-area">
        <a href="{{ route('deviceinfo', ['device_id' => $data['device_id']]) }}">デバイス情報画面へ戻る</a>
    </div>

@endsection