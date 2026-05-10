<?php

require_once __DIR__ . '/../app/Routing/RouteList.php';
require_once __DIR__ . '/../app/Support/Util.php';
require_once __DIR__ . '/../app/Http/Controllers/RoutesController.php';

// ルータ
function router($url){

    $routesController = new RoutesController;

    // 定義済みURLの取得
    $routes = RouteList::getRoutes();

    // 定義済みURLの場合
    if(array_key_exists($url, $routes)){

        $method = $routes[$url];
        if(method_exists($routesController, $method)){

            $routesController->$method();
        }
    }
    // 未定義URLの場合
    else{

        http_response_code(404);
        $routesController->routesNotFoundPage();
    }
}
