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

        // ログイン済み
        /*if(Util::isLogin()){

            // ユーザ登録画面へのリクエストの場合
            if($url === '/regist'){
                header("Location: /");
            }

            // リクエストURLに応じたルーティング
            include __DIR__ . $routes[$url];
            exit;
        }
        // 未ログイン
        else{

            // ユーザ登録画面へのリクエストの場合
            if($url === '/regist'){
                include __DIR__.'/../resources/views/registForm.php';
                exit;
            }
            // それ以外
            else{
                $method = $routes[$url];
                if(method_exists($routesController, $method)){
                    $routesController->$method();
                    return;
                }
            }

        }*/
    }
    // 未定義URLの場合
    else{
        http_response_code(404);
        include __DIR__ . '/../resources/views/errors/404Page.php';
        exit;
    }
}

?>