<?php
// デバイス登録画面

// デバイスID
$device_id = $data[RequestKey::DEVICE_ID] ?? '';

// デバイス名
$device_name = $data[RequestKey::DEVICE_NAME] ?? '';

// MACアドレス
$macaddress = $data[RequestKey::MACADDRESS] ?? '';

// CSRFトークン
$token = $data[RequestKey::TOKEN] ?? '';

// デバイス登録失敗メッセージ
$registFailMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<form action="" method="POST">
    <h2 id="loginLabel"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
    <p>
        <?php echo Util::escape($registFailMsg ?? '') ?>
    </p>
    <input type="text" value = "<?php echo Util::escape($device_id) ?>" name="device_id" placeholder="デバイスID"><br>
    <input type="text" value = "<?php echo Util::escape($device_name) ?>" name="device_name" placeholder="デバイス名"><br>
    <input type="text" value = "<?php echo Util::escape($macaddress) ?>" name="macaddress" placeholder="MACアドレス"><br>
    <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    <button type="submit" name="registBtn">登録</button><br>
    <a href="/devicelist">デバイス一覧画面に戻る</a>
</form>