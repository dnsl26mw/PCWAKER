<?php
// デバイス一覧画面

// デバイス一覧情報
$deviceListInfo = $data[RequestKey::DEVICE_LIST_INFO] ?? [];

// デバイス選択リスト
$selectDevices = $data[RequestKey::SELECTED_DEVICES] ?? [];

// CSRFトークン
$token = $data[RequestKey::TOKEN] ?? '';

// エラーメッセージ
$errorMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<h2 class="page-title"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<?php if(!empty($deviceListInfo)): ?>
    <?php if (!empty($errorMsg)): ?>
        <p class="error-msg">
            <?php echo Util::escape($errorMsg) ?>
        </p>
    <?php endif; ?>
    <form action="/device/wake" method="POST">
        <div class="devicetablediv">
            <table>
                <thead>
                    <tr>
                        <th>選択</th>
                        <th>デバイスID</th>
                        <th>デバイス名</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deviceListInfo as $device): ?>
                        <tr>
                            <td>
                                <input type="checkbox" 
                                class="selectcheckboxes" 
                                name="selectdevices[]" 
                                value="<?php echo Util::escape($device[RequestKey::DEVICE_ID]) ?>"
                                <?php echo in_array($device[RequestKey::DEVICE_ID], $selectDevices, true) ? 'checked' : ''?>
                            </td>
                            <td>
                                <a href="/deviceinfo?device_id=<?php echo urlencode(Util::escape($device[RequestKey::DEVICE_ID])) ?>">
                                    <?php echo Util::escape($device[RequestKey::DEVICE_ID]) ?>
                                </a>
                            </td>
                            <td>
                                <a href="/deviceinfo?device_id=<?php echo urlencode(Util::escape($device[RequestKey::DEVICE_ID])) ?>">
                                    <?php echo Util::escape($device[RequestKey::DEVICE_NAME]) ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="submit" name="wakeBtn" id="wakebutton" disabled>起動</button><br>
        <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    </form>
<?php else: ?>
    <p>登録されているデバイスはありません。</p>
<?php endif; ?>

<div class="action-area">
    <a href="/registdevice">デバイス情報の登録はこちら</a><br>
    <a href="/">トップに戻る</a>
</div>

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