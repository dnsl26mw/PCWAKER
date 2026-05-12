<?php

require_once __DIR__ . '/../app/Routing/RouteList.php';
require_once __DIR__ . '/../app/Routing/RouteUtil.php';
require_once __DIR__ . '/../app/Support/Util.php';
require_once __DIR__ . '/../app/Http/Controllers/RoutesController.php';

// ルータ
function router($url){

    $routesController = new RoutesController;

    // URLに対応するメソッド名を取得
    $method = RouteUtil::getRouteMethod($url);

    // 定義済みURLの場合
    if($method !== null){

        // コントローラに対象メソッドが存在する場合
        if(method_exists($routesController, $method)){

            // 対応メソッドの呼び出し
            $routesController->$method();
        }
    }
    // 未定義URLの場合
    else{

        // HTTPステータスコードを404に設定
        http_response_code(404);

        // 404ページに遷移
        $routesController->routesNotFoundPage();
    }
}
