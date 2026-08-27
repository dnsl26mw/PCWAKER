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
        <input type="text" value="{{ old('device_id') }}" name="device_id" placeholder="デバイスID"><br>
        <input type="text" value="{{ old('device_name') }}" name="device_name" placeholder="デバイス名"><br>
        <input type="text" value="{{ old('macaddress') }}" name="macaddress" placeholder="MACアドレス"><br>
        <button class="submit-button" type="submit" name="userRegistBtn" id="userRegistBtn">登録</button><br>
    </form>
    
    <div class="action-area">
        <a href="{{ route('devicelist') }}">デバイス一覧画面へ戻る</a><br>   
    </div>

@endsection
