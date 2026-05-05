<?php
// ログイン画面

// ユーザID
$user_id = $data[RequestKey::USER_ID] ?? '';

// CSRFトークン
$token = $data[RequestKey::TOKEN] ?? '';

// ログイン失敗メッセージ
$loginFailMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<form action="" method="POST">
    <h2 id="loginLabel"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
    <?php if (!empty($loginFailMsg)): ?>
        <p class="error-msg">
            <?php echo Util::escape($loginFailMsg) ?>
        </p>
    <?php endif; ?>
    <input type="text" value = "<?php echo Util::escape($user_id) ?>" name=<?php echo RequestKey::USER_ID ?> placeholder="ユーザーID"><br>
    <input type="password" name=<?php echo RequestKey::PASSWORD ?> placeholder="パスワード"><br>
    <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    <button type="submit" name="loginBtn">ログイン</button><br>
    <a href="/registuser">ユーザー登録はこちら</a>
</form>