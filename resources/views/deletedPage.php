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

<p>
    ユーザー情報削除が完了しました。
</p>
<form action="" method="POST">
    <button type="submit" name="logoutBtn" id="logoutBtn">ログイン画面へ戻る</button>
</form>