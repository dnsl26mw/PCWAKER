<?php
// ログイン画面

// ログイン失敗メッセージ
$loginFailMsg = $data['loginFailMsg'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

// ユーザID
$user_id = $data['user_id'] ?? '';

?>

<form action="" method="POST">
    <h2 id="loginLabel">ログイン</h2>
    <p>
        <?php
            if($loginFailMsg != ''){
                echo $loginFailMsg;
            }
        ?>
    </p>
    <input type="text" value = "<?php echo Util::escape($user_id) ?>" name="user_id" placeholder="ユーザーID"><br>
    <input type="password" name="userPw" placeholder="パスワード"><br>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="loginBtn">ログイン</button><br>
    <a href="/registuser">ユーザー登録はこちら</a>
</form>