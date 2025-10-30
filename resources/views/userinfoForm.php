<?php
// ユーザ情報更新画面

require_once __DIR__ . '/../../app/Http/Controllers/UserController.php';
require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../app/Service/Util.php';

// 更新時メッセージ
$updateMsg = '';

// トークン
$token = '';

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // ユーザ情報更新処理の呼び出し
    $userController = new UserController();
    $updateMsg = $userController->updateController([
        'userName' => $_POST['userName'],
        'userID' => $_SESSION['user_id'],
        'token' => $_POST['token']
    ]);

    // 更新失敗時
    if(!empty($registFailMsg)){
        $token = Util::createToken();
    }

    $token = Util::createToken();
}
// POST送信以外
else{
    $token = Util::createToken();
}

// ユーザ情報確認用
$userController = new UserController();
$dbRow = $userController->getUserInfoController(['userID' => $_SESSION['user_id']]);
$userID = $dbRow['user_id'];
$user_name = $dbRow['user_name'];
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
        <p>
            <?php
                if($updateMsg != ''){
                    echo $updateMsg;
                }
            ?>
        </p>
        <form action="" method="POST">
            <input type="text" value = "<?php echo $userID ?>" name="userId" id="logininputbox" placeholder="ユーザーID" readonly disabled><br>
            <input type="text" value = "<?php echo $user_name ?>" name="userName" id="logininputbox" placeholder="ユーザー名"><br>
            <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
            <button type="submit" name="updateBtn" id="updateBtn">更新</button>
        </form>
        <a href="/updatepassword">パスワードの更新はこちら</a><br>
        <a href="/menu">メニュー画面へ戻る</a>
        <footer>
        </footer>
    </body>
</html>