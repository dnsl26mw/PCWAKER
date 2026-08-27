@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @error('message')
        <div class="error-message">
            {{ $message }}
        </div>
    @enderror

    @if(session('message'))
        {{ session('message') }}
    @endif

    <form action="" method="post">
        @csrf
        <table>
            <tr>
                <th>デバイスID</th>
                <td>{{ $data['device_id'] }}</td>
            </tr>
            <tr>
                <th>デバイス名</th>
                <td><input type="text" name="device_name" value="{{ $data['name'] }}"></td>
            </tr>
            <tr>
                <th>MACアドレス</th>
                <td>
                    <input type="text" name="macaddress" value="{{ $data['macaddress'] }}">
                </td>
            </tr>
        </table>
        <button type="submit">デバイス情報更新</button>
    </form>

    <div class="action-area">
        <a href="{{ route('deviceinfo', ['device_id' => $data['device_id']]) }}">デバイス情報画面へ戻る</a><br>
        <a href="{{ route('deviceinfo.delete', ['device_id' => $data['device_id']]) }}">デバイス情報の削除はこちら</a><br>
    </div>

@endsection