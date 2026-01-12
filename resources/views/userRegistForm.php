<?php
// ユーザ登録画面

// ユーザID
$userID = $data['user_id'] ?? '';

// ユーザ名
$useName = $data['user_name'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

// ユーザ登録失敗メッセージ
$registFailMsg = $data['registFailMsg'] ?? '';

?>

<form action="" method="POST">
    <h2 id="loginLabel"><?php echo Util::escape($pageTitle); ?></h2>
    <p>
        <?php 
            if($registFailMsg != ''){
                echo $registFailMsg;
            }
        ?>
    </p>
    <input type="text" value = "<?php echo Util::escape($userID) ?>" name="user_id" placeholder="ユーザーID"><br>
    <input type="password" name="userPw" placeholder="パスワード"><br>
    <input type="text" value = "<?php echo Util::escape($useName) ?>" name="user_name" placeholder="ユーザー名"><br>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="loginBtn" id="loginBtn">登録</button><br>
    <a href="/">ログイン画面に戻る</a>
</form>