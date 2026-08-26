@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @if(isset($data['message']))
        {{ $data['message'] }}
    @endif

    @if($data['devices']->isNotEmpty())
        @foreach($data['devices'] as $row)
            <ul>
                <li><a href="{{ route('deviceinfo', [$row['device_id']])}}">{{ $row['name'] }}</a></li>
            </ul>
        @endforeach
    @endif

    <div class="action-area">
        <a href="{{ route('deviceinfo.regist') }}">デバイス情報の登録はこちら</a><br>
        <a href="{{ route('top')}}">トップへ戻る</a>
    </div>

@endsection