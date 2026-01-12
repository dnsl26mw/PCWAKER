<?php
// ユーザ情報削除画面

// ユーザID
$userID = $data['user_id'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

// 削除失敗メッセージ
$deleteFailMsg = $data['deleteFailMsg'] ?? '';

?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle); ?></h2>
<p>
    <?php echo Util::escape($deleteFailMsg ?? '') ?>
</p>
<p>
    ユーザーIDが<a href="/userinfo"><?php echo Util::escape($userID ?? '') ?></a>のユーザー情報を削除します。よろしいですか？
</p>
<form action="" method="POST">
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="deleteBtn" id="deleteBtn">削除</button><br>
</form>
<a href="/userinfo">ユーザー情報画面に戻る</a>