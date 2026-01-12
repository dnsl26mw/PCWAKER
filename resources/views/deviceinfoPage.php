<?php
// デバイス情報確認画面

// デバイスID
$deviceID = $data['device_id'] ?? '';

// デバイス名
$deviceName = $data['device_name'] ?? '';

// MACアドレス
$macAddress = $data['macaddress'] ?? '';

?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle); ?></h2>
<table>
    <tr>
        <th>デバイスID</th>
        <td><?php echo Util::escape($deviceID) ?></td>
    </tr>
    <tr>
        <th>デバイス名</th>
        <td><?php echo Util::escape($deviceName) ?></td>
    </tr>
    <tr>
        <th>MACアドレス</th>
        <td><?php echo Util::escape($macAddress) ?></td>
    </tr>
</table>
<a href="/deviceinfo/update?device_id=<?php echo urlencode(Util::escape($deviceID)) ?>">デバイス情報の更新および削除はこちら</a><br>
<a href="/devicelist">デバイス一覧画面に戻る</a>