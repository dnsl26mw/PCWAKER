<?php
// ユーザ情報削除画面

require_once __DIR__ . '/../../app/Http/Controllers/UserController.php';
require_once __DIR__ . '/../../app/Service/util.php';

// トークン
$token = '';

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // ユーザ情報削除処理の呼び出し
    $userController = new UserController();
    if(!$userController->deleteController([
            'userID' => $_SESSION['user_id'],
            'token' => $_POST['token'],
        ])
    ){
        $token = Util::createToken();
    }
}
// POST送信以外
else{
    $token = Util::createToken();
}
?>

<p>
    <?php echo Util::escape($_SESSION['user_name']) ?>さん、ユーザー情報を削除します。よろしいですか？
</p>
<form action="" method="POST">
<input type="hidden" name="token" value = "<?php echo $token; ?>"/>
<button type="submit" name="deleteBtn" id="deleteBtn">削除</button>
</form>