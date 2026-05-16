<?php

// テンプレート

// CSRFトークン
$token = $token ?? '';

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PCWAKER - <?php echo Util::escape($pageTitle); ?></title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <header>
            <h1><a href="<?php echo Util::createAppUrl('/') ?>">PCWAKER</a></h1>
            <?php if (!empty($_SESSION[RequestKey::USER_ID])): ?>
                <div class="header-right">
                    <span class="user-info">
                        ユーザーID:
                        <a href="<?php echo Util::createAppUrl('/userinfo') ?>">
                            <?= Util::escape($_SESSION[RequestKey::USER_ID]) ?>
                        </a>
                        でログイン中
                    </span>
                    <form action="<?php echo Util::createAppUrl('/logout') ?>" method="POST">
                        <button class="logout-button" type="submit" name="logoutBtn" class="logoutBtn">ログアウト</button>
                        <input type="hidden" name="<?php echo RequestKey::TOKEN; ?>" value = "<?php echo $token; ?>"/>
                    </form>
                </div>
            <?php endif; ?>
        </header>
        <main>
            <?php include $contentView; ?>
        </main>
        <footer>
            <small>
                Copyright© 2026 MasayukiHoshikawa All rights reserved.
            </small>
        </footer>
    </body>
</html>