<?php
// ユーザ情報削除画面

// CSRFトークン
$token = $data['token'] ?? '';

?>

<h2>ユーザー情報削除</h2>
<p>
    ユーザー情報を削除します。よろしいですか？
</p>
<form action="" method="POST">
<input type="hidden" name="token" value = "<?php echo $token; ?>"/>
<button type="submit" name="deleteBtn" id="deleteBtn">削除</button><br>
<a href="/userinfo">ユーザー情報画面に戻る</a>
</form>