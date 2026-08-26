@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    <table>
        <tr>
            <th>デバイスID</th>
            <td>{{ $data['device_id'] }}</td>
        </tr>
        <tr>
            <th>デバイス名</th>
            <td>{{ $data['name'] }}</td>
        </tr>
        <tr>
            <th>MACアドレス</th>
            <td>{{ $data['macaddress'] }}</td>
        </tr>
    </table>

    <div class="action-area">
        <a href="{{ route('deviceinfo.update')}}">デバイス情報の更新および削除はこちら</a><br>
        <a href="{{ route('devicelist')}}">デバイス一覧画面へ戻る</a>
    </div>

@endsection