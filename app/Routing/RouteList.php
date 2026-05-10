<?php

class RouteList{

    public static function getRoutes(){

        return [

            // トップ
            Env::$APP_BASE_PATH . '/' => 'routesTop',

            // ユーザ情報登録
            Env::$APP_BASE_PATH . '/registuser' => 'routesRegistUser',

            // ユーザ情報確認
            Env::$APP_BASE_PATH . '/userinfo' => 'routesUserInfo',

            // ユーザ情報更新
            Env::$APP_BASE_PATH . '/userinfo/update' => 'routesUpdateUserInfo',

            // ユーザ情報削除
            Env::$APP_BASE_PATH . '/deleteuser' => 'routesDeleteUser',

            // デバイス一覧
            Env::$APP_BASE_PATH . '/devicelist' => 'routesDeviceList',

            // デバイス起動
            Env::$APP_BASE_PATH . '/device/wake' => 'routesWake',

            // デバイス情報
            Env::$APP_BASE_PATH . '/deviceinfo' => 'routesDeviceInfo',

            // デバイス情報登録
            Env::$APP_BASE_PATH . '/registdevice' => 'routesRegistDevice',

            // デバイス情報更新
            Env::$APP_BASE_PATH . '/deviceinfo/update' => 'routesUpdateDeviceInfo',

            // デバイス情報削除
            Env::$APP_BASE_PATH . '/deviceinfo/delete' => 'routesDeleteDeviceInfo',

            // ログアウト
            Env::$APP_BASE_PATH . '/logout' => 'routesLogout'
        ];
    }
}
