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
                <td>
                    <input type="text" name="device_name" value="{{ old('device_name', '__DEFAULT__') !== '__DEFAULT__' ? old('device_name') : $data['device_name'] }}">
                </td>
            </tr>
            <tr>
                <th>MACアドレス</th>
                <td>
                    <input type="text" name="macaddress" value="{{ old('macaddress', '__DEFAULT__') !== '__DEFAULT__' ? old('macaddress') : $data['macaddress'] }}">
                </td>
            </tr>
        </table>
        <button type="submit">デバイス情報更新</button>
    </form>

    <div class="action-area">
        <a class="delete-link"  href="{{ route('deviceinfo.delete', ['device_id' => $data['device_id']]) }}">デバイス情報の削除はこちら</a><br>
        <a href="{{ route('deviceinfo', ['device_id' => $data['device_id']]) }}">デバイス情報画面へ戻る</a>
    </div>

@endsection