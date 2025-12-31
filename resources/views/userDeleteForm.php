<?php
// ユーザ情報削除画面

// CSRFトークン
$token = $data['token'] ?? '';

?>

<p>
    ユーザー情報を削除します。よろしいですか？
</p>
<form action="" method="POST">
<input type="hidden" name="token" value = "<?php echo $token; ?>"/>
<button type="submit" name="deleteBtn" id="deleteBtn">削除</button>
</form>