<?php

// DBへの接続
require_once __DIR__ . '/../database/dbConnect.php';

// ルータの読み込み
require_once __DIR__.'/../routes/web.php';

// リクエストURLに応じたルーティング
router(Util::parseURL());

?>