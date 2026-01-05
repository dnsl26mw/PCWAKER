<?php
// デバイス登録画面

// デバイス登録失敗メッセージ
$registFailMsg = $data['registFailMsg'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

// デバイスID
$deviceID = $data['deviceID'] ?? '';

// デバイス名
$deviceName = $data['deviceName'] ?? '';

// MACアドレス
$macAddress = $data['macAddress'] ?? '';

?>

<form action="" method="POST">
    <h2>デバイス登録</h2>
    <p>
        <?php 
            if($registFailMsg != ''){
                echo $registFailMsg;
            }
        ?>
    </p>
    <input type="text" value = "<?php echo Util::escape($deviceID) ?>" name="deviceId" placeholder="デバイスID"><br>
    <input type="text" value = "<?php echo Util::escape($deviceName) ?>" name="deviceName" placeholder="デバイス名"><br>
    <input type="text" value = "<?php echo Util::escape($macAddress) ?>" name="macAddress" placeholder="MACアドレス"><br>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="registBtn">登録</button><br>
    <a href="/devicelist">デバイス一覧画面に戻る</a>
</form>