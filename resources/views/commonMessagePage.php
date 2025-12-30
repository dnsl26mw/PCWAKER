<?php

// 共通メッセージ画面

$userController = new UserController;

?>

<h2>
    <?php echo Util::escape($_SESSION['message']) ?>
</h2>
<a href="/">メイン画面へ</a>