<?php
// トップページ

// CSRFトークン
$token = $data['token'] ?? '';

// ログアウト失敗メッセージ
$logoutFailMsg = $data['logoutFailMsg'] ?? '';
?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<p>
    <?php echo Util::escape($logoutFailMsg ?? '') ?>
</p>
<ul>
    <li><a href="/devicelist"><button>デバイス一覧</button></a></li>
    <li><a href="/userinfo"><button>ユーザー情報</button></a></li>
</ul>
<form action="" method="POST">
    <button type="submit" name="logoutBtn" id="logoutBtn">ログアウト</button>
    <input type="hidden" name="token" value = "<?php echo $token; ?>"/>
</form>