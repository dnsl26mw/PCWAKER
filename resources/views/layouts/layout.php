<?php

// テンプレート

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PCWAKER - <?php echo htmlspecialchars($title); ?></title>
    </head>
    <body>
        <header>
            <h1><a href="/">PCWAKER</a></h1>
            <p>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <a href="/userinfo">
                        <?= Util::escape($_SESSION['user_id']) ?>
                    </a>でログイン中
                <?php endif; ?>
            </p>
        </header>
            <?php include $contentView; ?>
        <footer>
            Copyright©
        </footer>
    </body>
</html>