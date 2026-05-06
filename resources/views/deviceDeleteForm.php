<?php
// デバイス情報削除画面

// デバイスID
$deviceID = $data[RequestKey::DEVICE_ID] ?? '';

// CSRFトークン
$token = $_SESSION[RequestKey::TOKEN] ?? '';

// エラーメッセージ
$errorMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<h2 class="page-title"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<?php if (!empty($errorMsg)): ?>
    <p class="error-msg">
        <?php echo Util::escape($errorMsg) ?>
    </p>
<?php endif; ?>
<p>
    デバイスIDが
    <a href="/deviceinfo?device_id=<?php echo urlencode(Util::escape($deviceID)) ?>">
    <?php echo Util::escape($deviceID ?? '') ?></a>のデバイス情報を削除します。よろしいですか？
</p>
<form action="" method="POST">
    <input type="hidden" name=<?php echo RequestKey::DEVICE_ID ?> value = "<?php echo $deviceID; ?>"/>
    <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    <button type="submit" name="deleteBtn" id="deleteBtn">削除</button><br>
</form>
<a href="/deviceinfo?device_id=<?php echo Util::escape($deviceID) ?>">デバイス情報画面に戻る</a>