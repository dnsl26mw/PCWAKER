<?php
// デバイス情報削除画面

// デバイスID
$deviceID = $data['device_id'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

// 削除失敗メッセージ
$deleteFailMsg = $data['deleteFailMsg'] ?? '';

?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<p>
    <?php echo Util::escape($deleteFailMsg ?? '') ?>
</p>
<p>
    デバイスIDが
    <a href="/deviceinfo?device_id=<?php echo urlencode(Util::escape($deviceID)) ?>">
    <?php echo Util::escape($deviceID ?? '') ?></a>のデバイス情報を削除します。よろしいですか？
</p>
<form action="" method="POST">
    <input type="hidden" name="device_id" value = "<?php echo $deviceID; ?>"/>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="deleteBtn" id="deleteBtn">削除</button><br>
</form>
<a href="/deviceinfo?device_id=<?php echo Util::escape($deviceID) ?>">デバイス情報画面に戻る</a>