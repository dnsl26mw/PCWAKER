<?php

require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../database/deviceTable.php';

Class DeviceModel{

    // デバイスID重複チェック
    public function isNotDuplicationDeviceID(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();
        
        // デバイスID重複の有無を返す
        return !$dbRow = DeviceTable::searchDeviceInfo([
            'deviceID' => $data['deviceID']],
        $db);
    }

    // デバイス情報登録
    public function registDeviceInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 登録処理を呼び出す
        return deviceTable::registDeviceInfo($data, $db);
    }

    // デバイス情報取得
    public function getDeviceInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 指定されたデバイス情報のレコードを取得
        $retRow = deviceTable::searchDeviceInfo([
            'deviceID' => $data['deviceID']
        ], $db);

        return $retRow;
    }

    // デバイス情報全取得
    public function getDeviceInfoAllModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 指定されたユーザに紐づくデバイス情報のレコードを取得
        $retRow = deviceTable::searchDeviceInfoAll([
            'userID' => $data['userID']
        ], $db);

        return $retRow;
    }

    // デバイス情報更新
    public function updateDeviceInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 更新処理を呼び出す
        return deviceTable::updateDeviceInfo($data, $db);
    }

    // デバイス情報削除
    public function deleteDeviceInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 削除処理を呼び出す
        return deviceTable::deleteDeviceInfo($data, $db);
    }

    // デバイス情報全削除
    public function deleteAllDeviceInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 削除処理を呼び出す
        return deviceTable::deleteDeviceInfoAll($data, $db);
    }
}