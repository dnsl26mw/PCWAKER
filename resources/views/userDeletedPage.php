<?php
// ユーザ情報削除後画面

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // ログアウト処理の呼び出し
    $autController = new AuthController();
    $loginFailMsg = $autController->logoutController();
    exit;
}
?>

<p>
    ユーザー削除が完了しました。3秒後にログイン画面にリダイレクトします。
</p>
<form action="" method="POST" id="autoLogoutform">
    <button type="submit" name="logoutBtn" id="logoutBtn">画面が切り替わらない場合はこちら</button>
</form>

<script>
    // 3秒後にログイン画面にリダイレクト
    setTimeout(function() {
        document.getElementById('autoLogoutform').submit();
    }, 3000);
</script>