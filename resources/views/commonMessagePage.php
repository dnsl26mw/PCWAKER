<?php

// ユーザ登録、ユーザ情報更新、ユーザ情報削除後メッセージ画面

require_once __DIR__ . '/../../app/Http/Controllers/UserController.php';
require_once __DIR__ . '/../../app/Service/util.php';

$userController = new UserController;

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
            <h1><a href="MainForm.php">PCWAKER</a></h1>
        </header>
        <h2>
            <?php echo Util::escape($_SESSION['message']) ?>
        </h2>
        <a href="/">メイン画面へ</a>
        <footer>
        </footer>
    </body>
</html>