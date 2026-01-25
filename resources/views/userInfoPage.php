<?php
// ユーザ情報確認画面

// ユーザID
$user_id = $data['user_id'] ?? '';

// ユーザ名
$user_name = $data['user_name'] ?? '';

?>

<h2 id="loginLabel"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<table>
    <tr>
        <th>ユーザーID</th>
        <td><?php echo Util::escape($data['user_id']) ?></td>
    </tr>
    <tr>
        <th>ユーザー名</th>
        <td><?php echo Util::escape($data['user_name']) ?></td>
    </tr>
</table>
<a href="/userinfo/update">ユーザー情報の更新および削除はこちら</a><br>
<a href="/">トップに戻る</a>