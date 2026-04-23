<?php
// ユーザ登録画面

// ユーザID
$userID = $data[RequestKey::USER_ID] ?? '';

// ユーザ名
$useName = $data[RequestKey::USER_NAME] ?? '';

// CSRFトークン
$token = $data[RequestKey::TOKEN] ?? '';

// ユーザ登録失敗メッセージ
$registFailMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<form action="" method="POST">
    <h2 id="loginLabel"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
    <p>
        <?php 
            if($registFailMsg != ''){
                echo $registFailMsg;
            }
        ?>
    </p>
    <input type="text" value = "<?php echo Util::escape($userID) ?>" name=<?php echo RequestKey::USER_ID ?> placeholder="ユーザーID"><br>
    <input type="password" name=<?php echo RequestKey::PASSWORD ?> placeholder="パスワード"><br>
    <input type="text" value = "<?php echo Util::escape($useName) ?>" name=<?php echo RequestKey::USER_NAME ?> placeholder="ユーザー名"><br>
    <input type="hidden" name=<?php echo RequestKey::TOKEN ?> value = "<?php echo $token; ?>"/>
    <button type="submit" name="userRegistBtn" id="userRegistBtn">登録</button><br>
    <a href="/">ログイン画面に戻る</a>
</form>