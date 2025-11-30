<?php
// ユーザ情報確認画面

?>

<table>
    <tr>
        <th>ユーザーID</th>
        <td><?php echo Util::escape($userInfo['user_id']) ?></td>
    </tr>
    <tr>
        <th>ユーザー名</th>
        <td><?php echo Util::escape($userInfo['user_name']) ?></td>
    </tr>
</table>
<a href="/updateuserinfo">ユーザー情報の更新および削除はこちら</a>