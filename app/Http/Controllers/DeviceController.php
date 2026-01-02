<?php

require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Models/AuthModel.php';
require_once __DIR__ . '/../../Service/commonMessage.php';
require_once __DIR__ . '/../../Service/util.php';

Class UserController{

    // デバイス情報取得
    public function getDeviceInfoController(array $data){

        $deviceModel = new DeviceModel();

        // 指定されたデバイスIDのデバイス情報を取得
        $retRow = $deviceModel->getDeviceInfoModel($data);

        // 取得したデバイス情報を返す
        return ['deviceInfo' => $retRow];
    }

    // デバイス情報登録
    public function registDeviceInfoController(array $data){

        $deviceModel = new DeviceModel();

        //  デバイスID、デバイス名、MACアドレスの未入力チェック
        if(empty($data['deviceID']) || empty($data['deviceName']) || empty($data['macAddress']) || empty($data['token'])){

            // デバイスID、デバイス名、MACアドレス未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // デバイスID、デバイス名、MACアドレス未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        // デバイスID重複チェック
        if(!$deviceModel->isNotDuplicationUserID(['deviceID' => $data['deviceID']])){

            // デバイスID重複メッセージを返す
            return CommonMessage::USERIDUSED;
        }

        // デバイス登録処理を呼び出す
        if(!$deviceModel->registDeviceModel($data)){

            // デバイス登録失敗メッセージを返す
            return CommonMessage::REGISTFAILURE;
        }

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        // 登録成功を表す空文字列を返す
        return '';
    }

    // デバイス情報更新
    public function updateDeviceInfoController(array $data){

        $deviceModel = new DeviceModel();

        // デバイス情報入力判定
        if(empty($data['deviceName']) || empty($data['macAddress']) || empty($data['token'])){

            // デバイス名、MACアドレス名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            
            // デバイス名、MACアドレス名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
        }

        // デバイス情報の更新
        if(!$deviceModel->updateDeviceInfoModel($data)){

            // 更新失敗メッセージを返す
            return CommonMessage::UPDATEFAILURE;
        }

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        // 更新成功を表す空文字列を返す
        return '';
    }

    // デバイス情報削除
    public function deleteDeviceInfoController(array $data){

        $deviceModel = new DeviceModel();

        // デバイスIDまたはCSRFトークンが未セット
        if(empty($data['deviceID']) || empty($data['token'])){
            return false;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            return false;
        }

        // デバイス削除処理を呼び出す
        if(!$userModel->deleteDeviceInfoModel($data)){
            return false;
        }

        // デバイス削除成功
        return true;
    }

    // デバイス情報全削除
    public function deleteDeviceInfoAllController(array $data){

        $deviceModel = new DeviceModel();

        // ユーザIDまたはCSRFトークンが未セット
        if(empty($data['userID']) || empty($data['token'])){
            return false;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            return false;
        }

        // デバイス削除処理を呼び出す
        if(!$userModel->deleteAllDeviceInfoModel($data)){
            return false;
        }

        // デバイス削除成功
        return true;
    }
}