<?php
// ログイン画面

// ユーザID
$user_id = $data[RequestKey::USER_ID] ?? '';

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
    <input type="text" value = "<?php echo Util::escape($user_id) ?>" name=<?php echo RequestKey::USER_ID ?> placeholder="ユーザーID"><br>
    <input type="password" name=<?php echo RequestKey::PASSWORD ?> placeholder="パスワード"><br>
    <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    <button class="submit-button" type="submit" name="loginBtn">ログイン</button><br> 
</form>
<div class="action-area">
    <a href="<?php echo Util::createAppUrl('/registuser') ?>">ユーザー登録はこちら</a>        
</div>