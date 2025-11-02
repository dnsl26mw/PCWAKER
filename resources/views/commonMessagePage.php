<?php

// 共通メッセージ画面

require_once __DIR__ . '/../../app/Http/Controllers/UserController.php';
require_once __DIR__ . '/../../app/Service/util.php';

$userController = new UserController;

?>

<h2>
    <?php echo Util::escape($_SESSION['message']) ?>
</h2>
<a href="/">メイン画面へ</a>