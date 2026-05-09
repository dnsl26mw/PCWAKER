<?php
// トップページ

// エラーメッセージ
$errorMsg = $data[RequestKey::MESSAGE] ?? '';

?>

<h2 class="page-title"><?php echo Util::escape($pageTitle) ?? ''; ?></h2>
<?php if (!empty($errorMsg)): ?>
    <p class="error-msg">
        <?php echo Util::escape($errorMsg) ?>
    </p>
<?php endif; ?>
<div class="menu-button-container">
<ul class="menu-button-list">
    <li><a href="/devicelist"><button>デバイス一覧</button></a></li>
    <li><a href="/userinfo"><button>ユーザー情報</button></a></li>
</ul>
</div>
