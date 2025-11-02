<?php
// メニュー画面

require_once __DIR__ . '/../../app/Service/util.php';

?>

<p>ようこそ、<?php echo Util::escape($_SESSION['user_name']) ?>さん</p>
<form action="" method="POST">
    <ul>
        <li><a href="/userinfo">ユーザー情報の確認・更新</a></li>
        <li><a href="/deleteuser">ユーザー情報削除</a></li>
        </ul>
</form>