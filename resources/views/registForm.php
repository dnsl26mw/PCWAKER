<?php
// ユーザー登録画面

require_once __DIR__ . '/../../app/Http/Controllers/UserController.php';
require_once __DIR__ . '/../../app/Service/Util.php';

// ユーザ登録失敗時のメッセージ
$registFailMsg = '';

// トークン
$token = '';

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // ユーザ登録処理の呼び出し
    $userController = new UserController();
    $registFailMsg = $userController->registController([
        'userID' => $_POST['userId'],
        'password' => $_POST['userPw'],
        'userName' => $_POST['userName'],
        'token' => $_POST['token']
    ]);

    // 登録失敗時
    if(!empty($registFailMsg)){
        $token = Util::createToken();
    }
}
// POST送信以外
else{
    $token = Util::createToken();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PCWAKER</title>
    </head>
    <body class="antialiased">
        <header>
            <h1><a href="/">PCWAKER</a></h1>
        </header>
        <form action="" method="POST">
            <h2 id="loginLabel">ユーザー登録</h2>
            <p>
                <?php 
                    if($registFailMsg != ''){
                        echo $registFailMsg;
                    }
                ?>
            </p>
            <input type="text" name="userId" id="logininputbox" placeholder="ユーザーID"><br>
            <input type="password" name="userPw" id="logininputbox" placeholder="パスワード"><br>
            <input type="text" name="userName" id="logininputbox" placeholder="ユーザー名"><br>
            <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
            <button type="submit" name="loginBtn" id="loginBtn">登録</button><br>
            <a href="/">ログイン画面に戻る</a>
        </form>
        <footer>
        </footer>
    </body>
</html>