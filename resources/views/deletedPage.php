<?php
// ユーザ情報削除後画面

require_once __DIR__ . '/../../app/Http/Controllers/AuthController.php';

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // ログアウト処理の呼び出し
    $autController = new AuthController();
    $loginFailMsg = $autController->logoutController();
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
        <h2>
            ユーザー情報削除が完了しました。
        </h2>
        <form action="" method="POST">
            <button type="submit" name="logoutBtn" id="logoutBtn">ログイン画面へ戻る</button>
        </form>
        <footer>
        </footer>
    </body>
</html>