<?php
// ユーザ情報削除画面

// ユーザID
$userID = $data[RequestKey::USER_ID] ?? '';

// CSRFトークン
$token = $data[RequestKey::TOKEN] ?? '';

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
    ユーザーIDが<a href="/userinfo"><?php echo Util::escape($userID ?? '') ?></a>のユーザー情報を削除します。よろしいですか？
</p>
<form action="" method="POST">
    <input type="hidden" name=<?php echo RequestKey::TOKEN?> value = "<?php echo $token; ?>"/>
    <button type="submit" name="deleteBtn" id="deleteBtn">削除</button><br>
</form>
<a href="/userinfo">ユーザー情報画面に戻る</a>