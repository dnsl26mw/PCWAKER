<?php

class RouteList{

    public static function getRoutes(){

        return [

            // トップ
            '/' => 'routesTop',

            // ユーザ情報登録
            '/registuser' => 'routesRegistUser',

            // ユーザ情報確認
            '/userinfo' => 'routesUserInfo',

            // ユーザ情報更新
            '/userinfo/update' => 'routesUpdateUserInfo',

            // ユーザ情報削除
            '/deleteuser' => 'routesDeleteUser',

            // デバイス一覧
            '/devicelist' => 'routesDeviceList',

            // デバイス起動
            '/device/wake' => 'routesWake',

            // デバイス情報
            '/deviceinfo' => 'routesDeviceInfo',

            // デバイス情報登録
            '/registdevice' => 'routesRegistDevice',

            // デバイス情報更新
            '/deviceinfo/update' => 'routesUpdateDeviceInfo',

            // デバイス情報削除
            '/deviceinfo/delete' => 'routesDeleteDeviceInfo',

            // ログアウト
            '/logout' => 'routesLogout'
        ];
    }
}
