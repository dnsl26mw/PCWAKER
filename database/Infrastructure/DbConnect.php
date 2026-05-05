<?php

require_once __DIR__ . '/../../bootstrap/env.php';
require_once __DIR__ . '/../../app/Http/Controllers/RoutesController.php';

class DbConnect {

    private static $pdo;

    // DBに接続
    public static function getDbConnect(){

        // 環境変数を取得
        Env::loadEnv();

        // DBに接続
        if(!self::$pdo){

            try{

                // ('DB接続方式: DB名; host = IPアドレスまたはホスト名; charset = 文字コード', 'DBユーザ名', 'パスワード')
                self::$pdo = new PDO(Env::$DB_CONNECTION . ':' 
                . 'dbname=' . Env::$DB_DATABASE . ';' 
                . 'host=' . Env::$DB_HOST . ';' 
                . 'port=' . Env::$DB_PORT . ';' 
                . 'charset=utf8',
                Env::$DB_USER_NAME,
                Env::$DB_PASSWORD);
            } catch(PDOException $e) {
                
                // DB接続失敗
                $routesController = new RoutesController();
                $routesController->routesDisConnect();
            }
        }
        return self::$pdo;
    }
}
?>