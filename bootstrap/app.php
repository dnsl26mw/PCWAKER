<?php

// DBに接続
require_once __DIR__ . '/../database/Infrastructure/DbConnect.php';

// 環境変数の読み込み
require_once __DIR__ . '/env.php';
Env::loadEnv();

// ルータの読み込み
require_once __DIR__.'/../routes/web.php';

// リクエストURLに応じたルーティング
router(Util::parseURL($_SERVER['REQUEST_URI']));

?>