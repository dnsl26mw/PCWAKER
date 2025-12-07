<?php
// トップページ

require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../app/Service/util.php';

// CSRFトークン
$token = $data['token'] ?? '';
?>

<ul>
    <li><a href="/devicelist"><button>デバイス一覧</button></a></li>
    <li><a href="/userinfo"><button>ユーザー情報</button></a></li>
</ul>
<form action="" method="POST">
    <button type="submit" name="logoutBtn" id="logoutBtn">ログアウト</button>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
</form>