<?php

require_once __DIR__ . '/../app/Routing/RouteList.php';
require_once __DIR__ . '/../app/Support/Util.php';
require_once __DIR__ . '/../app/Http/Controllers/RoutesController.php';

// ルータ
function router($url){

    $routesController = new RoutesController;

    // 定義済みURLの場合
    if(Util::isRoute($url)){

        // 定義済みURL配列の取得
        $routes = RouteList::getRoutes();

        // URLに対応するメソッド名を取得
        $method = $routes[$url];

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
