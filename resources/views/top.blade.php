@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @if(isset($data['message']))
        {{ $data['message'] }}
    @endif

<div class="menu-button-container">
    <ul class="menu-button-list">
        <li><a href="{{ route('userinfo') }}"><button>ユーザー情報</button></a></li>
    </ul>
</div>

@endsection