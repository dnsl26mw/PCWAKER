<?php
// デバイス登録画面

// デバイスID
$device_id = $data['device_id'] ?? '';

// デバイス名
$device_name = $data['device_name'] ?? '';

// MACアドレス
$macaddress = $data['macaddress'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

// デバイス登録失敗メッセージ
$registFailMsg = $data['registFailMsg'] ?? '';

?>

<form action="" method="POST">
    <h2>デバイス登録</h2>
    <p>
        <?php echo Util::escape($registFailMsg ?? '') ?>
    </p>
    <input type="text" value = "<?php echo Util::escape($device_id) ?>" name="device_id" placeholder="デバイスID"><br>
    <input type="text" value = "<?php echo Util::escape($device_name) ?>" name="device_name" placeholder="デバイス名"><br>
    <input type="text" value = "<?php echo Util::escape($macaddress) ?>" name="macaddress" placeholder="MACアドレス"><br>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="registBtn">登録</button><br>
    <a href="/devicelist">デバイス一覧画面に戻る</a>
</form>