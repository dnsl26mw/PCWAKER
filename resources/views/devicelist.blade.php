@extends('layouts.app')

@section('title', $pagetitle)

@section('content')

    <h2 class="page-title">{{ $pagetitle }}</h2>

    @if(session('message'))
        {{ session('message') }}
    @endif

    @if($data['devices']->isNotEmpty())
        <form action="{{ route('devicelist.wake') }}" method="post">
            @csrf
            <table>
                <tr>
                    <th class="select-column">選択</th>
                    <th class="device-id-column">デバイスID</th>
                    <th class="device-name-column">デバイス名</th>
                </tr>
                @foreach($data['devices'] as $row)
                    <tr>
                        <td class="select-column"><input type="checkbox" class="selectcheckboxes" name="selectdevices[]" value="{{ $row['device_id'] }}"></td>
                        <td class="device-id-column"><a href="{{ route('deviceinfo', [$row['device_id']])}}">{{ $row['device_id'] }}</a></td>
                        <td class="device-name-column"><a href="{{ route('deviceinfo', [$row['device_id']])}}">{{ $row['name'] }}</a></td>
                    </tr>
                @endforeach
            </table>
            <button class="submit-button" type="submit" name="wakeBtn" id="wakebutton" disabled>起動</button><br>
        </form>
    @else
        <p>デバイス情報が登録されていません。</p>
    @endif

    <div class="action-area">
        <a href="{{ route('deviceinfo.regist') }}">デバイス情報の登録はこちら</a><br>
        <a href="{{ route('top')}}">トップへ戻る</a>
    </div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function(){
    
    // 選択チェックボックス
    const selectCheckBoxes = document.querySelectorAll('.selectcheckboxes');

    // 起動ボタン
    const wakeButton = document.getElementById('wakebutton');

    // 起動ボタンの有効化制御
    function switchingEnableWakeButton(){

        // 1つ以上チェックされていたら有効化
        const anyChecked = Array.from(selectCheckBoxes).some(cb => cb.checked);
        wakeButton.disabled = !anyChecked;
    }

    // 読み込み時に起動ボタン有効化制御を呼び出す
    switchingEnableWakeButton();

    // 選択チェックボックス選択イベント
    selectCheckBoxes.forEach(cb => {
        cb.addEventListener('change', switchingEnableWakeButton);
    });
});
</script>