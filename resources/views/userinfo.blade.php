@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    <table>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $data['email'] }}</td>
        </tr>
        <tr>
            <th>ユーザー名</th>
            <td>{{ $data['name'] }}</td>
        </tr>
    </table>

    <div class="action-area">
        <a href="{{ route('userinfo.update')}}">ユーザー情報の更新および削除はこちら</a><br>
        <a href="{{ route('top')}}">トップへ戻る</a>
    </div>

@endsection