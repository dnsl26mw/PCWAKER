<?php
// ユーザ情報更新画面

require_once __DIR__ . '/../../app/Http/Controllers/UserController.php';
require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../app/Service/Util.php';

// ユーザ取得
$userController = new UserController();
$dbRow = $userController->getUserInfoController(['userID' => $_SESSION['user_id']]);
$userID = $dbRow['user_id'];
$user_name = $dbRow['user_name'];

// トークン
$token = Util::createToken();

?>

<p>ようこそ、<?php echo Util::escape($_SESSION['user_name']) ?>さん</p>
<table>
    <tr>
        <th>ユーザーID</th>
        <td><?php echo Util::escape($userID) ?></td>
    </tr>
    <tr>
        <th>ユーザー名</th>
        <td><?php echo Util::escape($user_name) ?></td>
    </tr>
</table>
<form action="/updateuserinfo" method="POST">
    <input type="hidden" name="token" values = "<?php echo $token; ?>"/>
    <button type="submit" name="updateButton">ユーザー情報更新はこちら</button>
</form>