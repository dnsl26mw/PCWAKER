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

// エラーメッセージ
$errorMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<form action="" method="POST">
    <h2 class="page-title"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
    <?php if (!empty($errorMsg)): ?>
        <p class="error-msg">
            <?php echo Util::escape($errorMsg) ?>
        </p>
    <?php endif; ?>
    <input type="text" value = "<?php echo Util::escape($device_id) ?>" name="device_id" placeholder="デバイスID"><br>
    <input type="text" value = "<?php echo Util::escape($device_name) ?>" name="device_name" placeholder="デバイス名"><br>
    <input type="text" value = "<?php echo Util::escape($macaddress) ?>" name="macaddress" placeholder="MACアドレス(XX-XX-XX-XX-XX-XX)"><br>
    <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    <button class="submit-button" type="submit" name="registBtn">登録</button><br>
</form>
<div class="action-area">
    <a href="<?php echo Util::createAppUrl('/devicelist') ?>">デバイス一覧画面に戻る</a>
</div>