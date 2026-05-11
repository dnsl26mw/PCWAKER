<?php
// ユーザ登録画面

// ユーザID
$userID = $data[RequestKey::USER_ID] ?? '';

// ユーザ名
$userName = $data[RequestKey::USER_NAME] ?? '';

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
    <input type="text" value = "<?php echo Util::escape($userID) ?>" name=<?php echo RequestKey::USER_ID ?> placeholder="ユーザーID"><br>
    <input type="password" name=<?php echo RequestKey::PASSWORD ?> placeholder="パスワード"><br>
    <input type="text" value = "<?php echo Util::escape($userName) ?>" name=<?php echo RequestKey::USER_NAME ?> placeholder="ユーザー名"><br>
    <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    <button class="submit-button" type="submit" name="userRegistBtn" id="userRegistBtn">登録</button><br>
</form>
<div class="action-area">
    <a href="<?php echo Util::createAppUrl('/') ?>">ログイン画面に戻る</a>    
</div>