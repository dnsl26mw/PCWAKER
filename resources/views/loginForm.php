<?php
// ログイン画面

require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../app/Service/Util.php';

// ログイン失敗メッセージ
$loginFailMsg = $data['loginFailMsg'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

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
    <input type="text" name="userId" id="logininputbox" placeholder="ユーザーID"><br>
    <input type="password" name="userPw" id="logininputbox" placeholder="パスワード"><br>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="loginBtn" id="loginBtn">ログイン</button><br>
    <a href="/regist">ユーザー登録はこちら</a>
</form>