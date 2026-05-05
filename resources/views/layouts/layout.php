<?php

// テンプレート

// ログアウト用CSRFトークン
$logoutToken = $data[RequestKey::LOGOUT_TOKEN] ?? '';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PCWAKER - <?php echo Util::escape($pageTitle); ?></title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <header>
            <h1><a href="/">PCWAKER</a></h1>
            <?php if (!empty($_SESSION[RequestKey::USER_ID])): ?>
                <div class="header-right">
                    <span class="user-info">
                        ユーザーID:
                        <a href="/userinfo">
                            <?= Util::escape($_SESSION[RequestKey::USER_ID]) ?>
                        </a>
                        でログイン中
                    </span>
                    <form action="logout" method="POST">
                        <button type="submit" name="logoutBtn" class="logoutBtn">ログアウト</button>
                        <input type="hidden" name="<?php echo RequestKey::LOGOUT_TOKEN; ?>" value = "<?php echo $logoutToken; ?>"/>
                    </form>
                </div>
            <?php endif; ?>
        </header>
        <main>
            <?php include $contentView; ?>
        </main>
        <footer>
            Copyright©
        </footer>
    </body>
</html>