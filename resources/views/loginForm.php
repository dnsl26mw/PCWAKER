<?php
// ログイン画面

require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../app/Service/Util.php';

// ログイン失敗時のメッセージ
$loginFailMsg = '';

// トークン
$token = '';

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // ログイン処理の呼び出し
    $authController = new AuthController();
    $loginFailMsg = $authController->loginController([
        'userID' => $_POST['userId'],
        'password' => $_POST['userPw'],
        'token' => $_POST['token']
    ]);

    // ログイン失敗時
    if(!empty($loginFailMsg)){
        $token = Util::createToken();
    }
}
// POST送信以外
else{
    $token = Util::createToken();
}
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