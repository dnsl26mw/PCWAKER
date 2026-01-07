<?php
// デバイス情報削除画面

// デバイスID
$deviceID = $data['device_id'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

?>

<h2>デバイス情報削除</h2>
<p>
    デバイスIDが<?php echo Util::escape($deviceID ?? '') ?>のデバイス情報を削除します。よろしいですか？
</p>
<form action="" method="POST">
    <input type="hidden" name="device_id" value = "<?php echo $deviceID; ?>"/>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="deleteBtn" id="deleteBtn">削除</button><br>
</form>
<a href="/deviceinfo?device_id=<?php echo Util::escape($deviceID) ?>">デバイス情報画面に戻る</a>