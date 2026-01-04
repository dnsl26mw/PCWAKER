<?php
// ユーザ登録画面

// ユーザ登録失敗メッセージ
$registFailMsg = $data['registFailMsg'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

?>

<form action="" method="POST">
    <h2>ユーザー登録</h2>
    <p>
        <?php 
            if($registFailMsg != ''){
                echo $registFailMsg;
            }
        ?>
    </p>
    <input type="text" name="userId" id="logininputbox" placeholder="ユーザーID"><br>
    <input type="password" name="userPw" id="logininputbox" placeholder="パスワード"><br>
    <input type="text" name="userName" id="logininputbox" placeholder="ユーザー名"><br>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="loginBtn" id="loginBtn">登録</button><br>
    <a href="/">ログイン画面に戻る</a>
</form>