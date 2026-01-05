<?php
// ユーザ登録画面

// ユーザ登録失敗メッセージ
$registFailMsg = $data['registFailMsg'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

// ユーザID
$userID = $data['userID'] ?? '';

// ユーザ名
$useName = $data['userName'] ?? '';

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
    <input type="text" value = "<?php echo Util::escape($userID) ?>" name="userId" placeholder="ユーザーID"><br>
    <input type="password" name="userPw" placeholder="パスワード"><br>
    <input type="text" value = "<?php echo Util::escape($useName) ?>" name="userName" placeholder="ユーザー名"><br>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="loginBtn" id="loginBtn">登録</button><br>
    <a href="/">ログイン画面に戻る</a>
</form>