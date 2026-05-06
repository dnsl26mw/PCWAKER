<?php
// ユーザ情報確認画面

// ユーザID
$user_id = $data[RequestKey::USER_ID] ?? '';

// ユーザ名
$user_name = $data[RequestKey::USER_NAME] ?? '';

// エラーメッセージ
$errorMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<h2 class="page-title"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<?php if (!empty($errorMsg)): ?>
    <p class="error-msg">
        <?php echo Util::escape($errorMsg) ?>
    </p>
<?php endif; ?>
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
<div class="action-area">
    <a href="/userinfo/update">ユーザー情報の更新および削除はこちら</a><br>
    <a href="/">トップに戻る</a>
</div>