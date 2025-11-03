<?php
// ユーザ情報更新画面

require_once __DIR__ . '/../../app/Http/Controllers/UserController.php';
require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../app/Service/Util.php';

// 更新時メッセージ
$updateMsg = '';

// トークン
$token =  "";

// POST送信された場合
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // ユーザ情報更新処理の呼び出し
    $userController = new UserController();
    $updateMsg = $userController->updateController([
        'userName' => $_POST['userName'],
        'userID' => $_SESSION['user_id'],
        'token' => $_POST['token']
    ]);

    // 更新失敗時
    if(!empty($registFailMsg)){
        $token = Util::createToken();
    }

    
}
// POST送信以外
else{
    $token = Util::createToken();
}

// ユーザ情報確認用
$userController = new UserController();
$dbRow = $userController->getUserInfoController(['userID' => $_SESSION['user_id']]);
$userID = $dbRow['user_id'];
$user_name = $dbRow['user_name'];
?>

<p>ようこそ、<?php echo Util::escape($_SESSION['user_name']) ?>さん</p>
<p>
    <?php
        if($updateMsg != ''){
            echo $updateMsg;
        }
    ?>
</p>
<form action="" method="POST">
    <table>
        <tr>
            <th>ユーザーID</th>
            <td><?php echo Util::escape($userID) ?></td>
        </tr>
        <tr>
            <th>ユーザー名</th>
            <td><input type="text" value = "<?php echo $user_name ?>" name="userName" id="logininputbox" placeholder="ユーザー名"><br></td>
        </tr>
        <tr>
            <th>
                パスワード
            </th>
            <td>
                <input type="radio" name="updatepasswordradio" value="notupdatepassword" id="notupdatepasswordradio" checked>更新しない</input>
                <input type="radio" name="updatepasswordradio" value="updatepassword" id="updatepasswordradio">更新する</input>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <input type="password" name="passwords" id="oldpasstextbox" placeholder="現在のパスワード"><br>
                <input type="password" name="passwords" id="newpasstextbox" placeholder="新しいパスワード"><br>
            </td>
        <tr>
    </table>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
    <button type="submit" name="updateBtn" id="updateBtn">ユーザー情報更新</button>
</form>
<a href="/deleteuser"><button>ユーザー情報削除</button></a>

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

    // パスワード入力ボックスの有効化制御
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

    // 読み込み時にパスワード入力ボックスの有効化制御を呼び出す
    switchingEnablePasswordFields();

    // 更新しないラジオボタン選択イベント
    notUpdatePassRadio.addEventListener('change', switchingEnablePasswordFields);

    // 更新するラジオボタン選択イベント
    updatePassRadio.addEventListener('change', switchingEnablePasswordFields);
});
</script>