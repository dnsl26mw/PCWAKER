<?php
// トップページ

require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../app/Service/util.php';

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // ログアウト処理の呼び出し
    $autController = new AuthController();
    $autController->logoutController();
}
?>

<p>ようこそ、<?php echo Util::escape($_SESSION['user_name']) ?>さん</p>
<ul>
    <li><a><button>デバイス一覧</button></a></li>
    <li><a href="/userinfo"><button>ユーザー情報</button></a></li>
</ul>
<form action="" method="POST">
<button type="submit" name="logoutBtn" id="logoutBtn">ログアウト</button>
</form>