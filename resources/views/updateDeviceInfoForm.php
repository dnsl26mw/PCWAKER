<?php
// デバイス情報更新画面

// デバイス情報
$deviceInfo = $data['userInfo'] ?? [];

// 更新失敗メッセージ
$updateFailMsg = $data['updateMsg'] ?? '';

// トークン
$token = $data['token'] ?? '';

// デバイスID
$deviceID = $userInfo['user_id'] ?? '';

// デバイス名
$device_name = $userInfo['user_name'] ?? '';

// MACアドレス
$macaddress = $userInfo['user_name'] ?? '';

?>

<h2>デバイス情報更新</h2>
<p><?= Util::escape($error ?? '') ?></p>
<form action="" method="POST">
    <table>
        <tr>
            <th>デバイスID</th>
            <td><?php echo Util::escape($deviceID) ?></td>
        </tr>
        <tr>
            <th>デバイス名</th>
            <td><input type="text" value = "<?php echo Util::escape($device_name) ?>" name="deviceName" placeholder="デバイス名"><br></td>
        </tr>
        <tr>
            <th>MACアドレス</th>
            <td><input type="text" value = "<?php echo Util::escape($device_name) ?>" name="deviceName" placeholder="MACアドレス"><br></td>
        <tr>
    </table>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="updateBtn" id="updateBtn">デバイス情報更新</button>
</form>
<a href="/deletedeviceinfo"><button>デバイス情報削除</button></a>