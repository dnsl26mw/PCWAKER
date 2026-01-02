<?php
// デバイス登録画面

// デバイス登録失敗メッセージ
$registFailMsg = $data['registFailMsg'] ?? '';

// CSRFトークン
$token = $data['token'] ?? '';

?>

<form action="" method="POST">
    <h2 id="loginLabel">デバイス登録</h2>
    <p>
        <?php 
            if($registFailMsg != ''){
                echo $registFailMsg;
            }
        ?>
    </p>
    <input type="text" name="deviceId" placeholder="デバイスID"><br>
    <input type="text" name="deviceName" placeholder="デバイス名"><br>
    <input type="text" name="macAddress" placeholder="MACアドレス"><br>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="registBtn">登録</button><br>
    <a href="/devicelist">デバイス一覧に戻る</a>
</form>