<?php

require_once __DIR__ . '/../app/Service/util.php';
require_once __DIR__ . '/../app/Http/Controllers/RoutesController.php';

// ルータ
function router($url){

    $routesController = new RoutesController;

    $routes = [
        // トップ
        '/' => 'routesTop',

        // ユーザ登録
        '/registuser' => 'routesRegistUser',

        // ユーザ情報確認
        '/userinfo' => 'routesUserInfo',

        // ユーザ情報更新
        '/updateuserinfo' => 'routesUpdateUserInfo',

        // ユーザ情報削除
        '/deleteuser' => 'routesDeleteUser',

        // デバイス一覧
        '/devicelist' => 'routesDeviceList',
    ];

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

?>