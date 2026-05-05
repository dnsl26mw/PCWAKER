<?php

// テンプレート

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
            <p>
                <?php if (!empty($_SESSION[RequestKey::USER_ID])): ?>
                    ユーザーID:
                    <a href="/userinfo">
                        <?= Util::escape($_SESSION[RequestKey::USER_ID]) ?>
                    </a>でログイン中
                <?php endif; ?>
            </p>
        </header>
        <main>
            <?php include $contentView; ?>
        </main>
        <footer>
            Copyright©
        </footer>
    </body>
</html>