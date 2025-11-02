<?php

require_once __DIR__ . '/../app/Service/util.php';
require_once __DIR__ . '/../app/Http/Controllers/RoutesController.php';

// ルータ
function router($url){

    $routesController = new RoutesController;

    $routes = [
        // トップページ
        '/' => 'routesTop',

        // メニューページ
        '/menu' => 'routesMenu',

        // ユーザ登録画面
        '/regist' => 'routesRegistUser',

        // ユーザ登録後画面
        '/registeduser' => 'routesRegistedUser',

        // ユーザ情報確認・更新画面
        '/userinfo' => 'routesUserInfo',

        // パスワード更新画面
        '/updatepassword' => 'routesUpdatePassword',

        // ユーザ情報削除画面
        '/deleteuser' => 'routesDeleteUser',

        // ユーザ情報削除後画面
        '/deleted' => 'routesDeletedUser'
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
        $routesController->notFoundPage();
    }
}

?>