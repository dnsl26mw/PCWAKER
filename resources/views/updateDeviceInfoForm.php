<?php
// デバイス情報更新画面

// デバイスID
$deviceID = $data[RequestKey::DEVICE_ID] ?? '';

// デバイス名
$deviceName = $data[RequestKey::DEVICE_NAME] ?? '';

// MACアドレス
$macAddress = $data[RequestKey::MACADDRESS] ?? '';

// CSRFトークン
$token = $data[RequestKey::TOKEN] ?? '';

// 更新失敗メッセージ
$updateFailMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<?php if (!empty($updateFailMsg)): ?>
    <p class="error-msg">
        <?php echo Util::escape($updateFailMsg) ?>
    </p>
<?php endif; ?>
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
    <input type="hidden" name=<?php echo RequestKey::DEVICE_ID ?> value = "<?php echo $deviceID; ?>"/>
    <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    <button type="submit" name="updateBtn" id="updateBtn">デバイス情報更新</button>
</form>
<a href="/deviceinfo/delete?device_id=<?php echo urlencode(Util::escape($deviceID)) ?>"><button>デバイス情報削除</button></a><br>
<a href="/deviceinfo?device_id=<?php echo Util::escape($deviceID) ?>">デバイス情報画面に戻る</a>