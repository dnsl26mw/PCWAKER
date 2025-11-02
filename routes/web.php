<?php

require_once __DIR__ . '/../app/Service/util.php';
require_once __DIR__ . '/../app/Http/Controllers/RoutesController.php';

// ルータ
function router($url){

    $routesController = new RoutesController;

    $routes = [
        // トップ
        '/' => 'routesTop',

        // メニュー
        '/menu' => 'routesMenu',

        // ユーザ登録
        '/regist' => 'routesRegistUser',

        // ユーザ登録完了
        '/registeduser' => 'routesRegistedUser',

        // ユーザ情報確認
        '/userinfo' => 'routesUserInfo',

        // ユーザ情報確認
        '/updateuserinfo' => 'routesUpdateUserInfo',

        // パスワード更新
        '/updatepassword' => 'routesUpdatePassword',

        // ユーザ情報削除
        '/deleteuser' => 'routesDeleteUser',

        // ユーザ情報削除完了
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