<?php
// ユーザ情報確認画面

// ユーザID
$user_id = $data[RequestKey::USER_ID] ?? '';

// ユーザ名
$user_name = $data[RequestKey::USER_NAME] ?? '';

?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<table>
    <tr>
        <th>ユーザーID</th>
        <td><?php echo Util::escape($data[RequestKey::USER_ID]) ?></td>
    </tr>
    <tr>
        <th>ユーザー名</th>
        <td><?php echo Util::escape($data[RequestKey::USER_NAME]) ?></td>
    </tr>
</table>
<a href="/userinfo/update">ユーザー情報の更新および削除はこちら</a><br>
<a href="/">トップに戻る</a>