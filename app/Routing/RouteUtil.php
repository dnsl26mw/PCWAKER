<?php

require_once __DIR__ . '/RouteList.php';

class RouteUtil{

    // 定義済みルートかどうかを判定
    public static function isRoute($url){

        return self::getRouteMethod($url) !== null;
    }

    // URLに対応するメソッド名を取得
    public static function getRouteMethod($url){

        // URLのパース
        $path = self::parseURL($url);

        // 定義済みURL配列の取得
        $routes = RouteList::getRoutes();

        // URLに対応するメソッド名を取得して返す
        if(isset($routes[$path])){

            return $routes[$path];
        }

        // 未定義ルートの場合
        return null;
    }

    // URLのパース
    public static function parseURL($url){

        return parse_url($url, PHP_URL_PATH);
    }
}