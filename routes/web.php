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
        '/menu' => '/../resources/views/menuPage.php',

        // ユーザ登録画面
        '/regist' => '/../resources/views/registForm.php',

        // ユーザ登録後画面
        '/registed' => '/../resources/views/registedPage.php',

        // ユーザ情報確認・更新画面
        '/userinfo' => '/../resources/views/userinfoForm.php',

        // パスワード更新画面
        '/updatepassword' => '/../resources/views/updatePasswordForm.php',

        // ユーザ情報削除画面
        '/deleteConfirm' => '/../resources/views/deleteForm.php',

        // ユーザ情報削除後画面
        '/deleted' => '/../resources/views/deletedPage.php'
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