<?php
// ユーザ情報更新画面

require_once __DIR__ . '/../../app/Http/Controllers/UserController.php';
require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../app/Service/Util.php';

// 更新時メッセージ
$updatePasswordMsg = '';

// トークン
$token = '';

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // 現在のパスワードを照合
    $authController = new AuthController();
    $updatePasswordMsg = $authController->onlyPasswordCheckController([
        'userID' => $_SESSION['user_id'],
        'oldPassword' => $_POST['oldPassword'],
        'newPassword' => $_POST['newPassword'],
        'token' => $_POST['token']
    ]);

    // 現在のパスワードが正しい場合、パスワード更新処理の呼び出し
    if(empty($updatePasswordMsg)){
        $userController = new UserController();
        $updatePasswordMsg = $userController->updatePasswordController([
            'userID' => $_SESSION['user_id'],
            'newPassword' => $_POST['newPassword'],
            'token' => $_POST['token']
        ]);
    }

    $token = Util::createToken();
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
    <body>
        <header>
            <h1><a href="/">PCWAKER</a></h1>
        </header>
        <p>ようこそ、<?php echo Util::escape($_SESSION['user_name']) ?>さん</p>
        <form action="" method="POST">
            <p>
                <?php
                    if($updatePasswordMsg != ''){
                        echo $updatePasswordMsg;
                    }
                ?>
            </p>
            <input type="password" name="oldPassword" id="logininputbox" placeholder="現在のパスワード"><br>
            <input type="password" name="newPassword" id="logininputbox" placeholder="新しいパスワード"><br>
            <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
            <button type="submit" name="updateBtn" id="updateBtn">更新</button>
        </form>
        <a href="/menu">メニュー画面へ戻る</a>
        <footer>
        </footer>
    </body>
</html>