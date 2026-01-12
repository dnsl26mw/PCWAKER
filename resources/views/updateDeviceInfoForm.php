<?php
// デバイス情報更新画面

// デバイスID
$deviceID = $data['device_id'] ?? '';

// デバイス名
$deviceName = $data['device_name'] ?? '';

// MACアドレス
$macAddress = $data['macaddress'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

// 更新失敗メッセージ
$updateFailMsg = $data['updateFailMsg'] ?? '';

?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle); ?></h2>
<p>
    <?php echo Util::escape($updateFailMsg ?? '') ?>
</p>
<form action="" method="POST">
    <table>
        <tr>
            <th>デバイスID</th>
            <td><?php echo Util::escape($deviceID) ?></td>
        </tr>
        <tr>
            <th>デバイス名</th>
            <td><input type="text" value = "<?php echo Util::escape($deviceName) ?>" name="device_name" placeholder="デバイス名"><br></td>
        </tr>
        <tr>
            <th>MACアドレス</th>
            <td><input type="text" value = "<?php echo Util::escape($macAddress) ?>" name="macaddress" placeholder="MACアドレス"><br></td>
        <tr>
    </table>
    <input type="hidden" name="device_id" value = "<?php echo $deviceID; ?>"/>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="updateBtn" id="updateBtn">デバイス情報更新</button>
</form>
<a href="/deviceinfo/delete?device_id=<?php echo urlencode(Util::escape($deviceID)) ?>"><button>デバイス情報削除</button></a><br>
<a href="/deviceinfo?device_id=<?php echo Util::escape($deviceID) ?>">デバイス情報画面に戻る</a>