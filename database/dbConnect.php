<?php

require_once __DIR__ . '/../app/Http/Controllers/RoutesController.php';

class DBConnect {
    // DBへの接続
    private static $pdo;
    public static function getDBConnect(){

        if(!self::$pdo){
            try{
                // ('mysql: DB名前; host = IPまたはホスト名; charset = 文字コード', 'DBユーザ名', 'パスワード')
                self::$pdo = new PDO('mysql:dbname=pcwaker;host=127.0.0.1;charset=utf8','pcwaker','pcwaker');
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