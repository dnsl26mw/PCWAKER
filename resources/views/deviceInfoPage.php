<?php
// デバイス情報確認画面

// デバイスID
$deviceID = $data[RequestKey::DEVICE_ID] ?? '';

// デバイス名
$deviceName = $data[RequestKey::DEVICE_NAME] ?? '';

// MACアドレス
$macAddress = $data[RequestKey::MACADDRESS] ?? '';

// エラーメッセージ
$errorMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<h2 class="page-title"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<?php if (!empty($errorMsg)): ?>
    <p class="error-msg">
        <?php echo Util::escape($errorMsg) ?>
    </p>
<?php endif; ?>
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