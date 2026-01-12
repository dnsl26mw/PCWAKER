<?php
// ユーザ情報更新画面

// ユーザID
$userID = $data['user_id'] ?? '';

// ユーザ名
$userName = $data['user_name'] ?? '';

// パスワード更新ラジオボタンの選択
$isUpdatePassword = $_POST['updatepass'] ?? 'notupdatepassword';

// CSRFトークン
$token = $data['token'] ?? '';

// 更新失敗メッセージ
$updateFailMsg = $data['updateFailMsg'] ?? '';

?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle); ?></h2>
<p>
    <?= Util::escape($updateFailMsg ?? '') ?>
</p>
<form action="" method="POST">
    <table>
        <tr>
            <th>ユーザーID</th>
            <td><?php echo Util::escape($userID) ?></td>
        </tr>
        <tr>
            <th>ユーザー名</th>
            <td><input type="text" value = "<?php echo Util::escape($userName) ?>" name="user_name" id="logininputbox" placeholder="ユーザー名"><br></td>
        </tr>
        <tr>
            <th>
                パスワード
            </th>
            <td>
                <input type="radio" name="updatepass" value="notupdatepassword" id="notupdatepasswordradio" <?php echo ($isUpdatePassword === 'notupdatepassword') ? 'checked' : ''; ?>>更新しない</input>
                <input type="radio" name="updatepass" value="updatepassword" id="updatepasswordradio" <?php echo ($isUpdatePassword === 'updatepassword') ? 'checked' : ''; ?>>更新する</input>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <input type="password" name="oldpass" id="oldpasstextbox" placeholder="現在のパスワード"><br>
                <input type="password" name="newpass" id="newpasstextbox" placeholder="新しいパスワード"><br>
            </td>
        <tr>
    </table>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="updateBtn" id="updateBtn">ユーザー情報更新</button>
</form>
<a href="/deleteuser"><button>ユーザー情報削除</button></a><br>
<a href="/userinfo">ユーザー情報画面に戻る</a>

<script>
document.addEventListener('DOMContentLoaded', function(){

    // 更新しないラジオボタン
    const notUpdatePassRadio = document.getElementById('notupdatepasswordradio');

    // 更新するラジオボタン
    const updatePassRadio = document.getElementById('updatepasswordradio');

    // 現在のパスワード入力ボックス
    const oldPassText = document.getElementById('oldpasstextbox');

    // 新しいパスワード入力ボックス
    const newPassText = document.getElementById('newpasstextbox');

    // パスワード入力ボックス有効化制御
    function switchingEnablePasswordFields(){
        const disable = notUpdatePassRadio.checked;
        if(disable){
            oldPassText.disabled = true;
            newPassText.disabled = true;
            oldPassText.value = '';
            newPassText.value = '';
        }
        else{
            oldPassText.disabled = false;
            newPassText.disabled = false;
        }
    }

    // 読み込み時にパスワード入力ボックス有効化制御を呼び出す
    switchingEnablePasswordFields();

    // 更新しないラジオボタン選択イベント
    notUpdatePassRadio.addEventListener('change', switchingEnablePasswordFields);

    // 更新するラジオボタン選択イベント
    updatePassRadio.addEventListener('change', switchingEnablePasswordFields);
});
</script>