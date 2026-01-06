<?php

require_once __DIR__ . '/../../Models/DeviceModel.php';
require_once __DIR__ . '/../../Service/commonMessage.php';
require_once __DIR__ . '/../../Service/util.php';

Class DeviceController{

    // デバイス情報全取得
    public function getDeviceInfoAllController(array $data){

        $deviceModel = new DeviceModel();

        // 指定されたユーザIDに紐づくデバイス情報を取得し、返す
        return $deviceModel->getDeviceInfoAllModel($data);
    }

    // デバイス情報取得
    public function getDeviceInfoController(array $data){

        $deviceModel = new DeviceModel();

        // 指定されたデバイスIDのデバイス情報を取得し、返す
        return $deviceModel->getDeviceInfoModel($data);
    }

    // デバイス情報登録
    public function registDeviceInfoController(array $data){

        $deviceModel = new DeviceModel();

        //  デバイスID、デバイス名、MACアドレスの未入力チェック
        if(empty($data['device_id']) || empty($data['device_name']) || empty($data['macaddress']) || empty($data['token'])){

            // デバイスID、デバイス名、MACアドレス未入力メッセージを返す
            return CommonMessage::DEVICEIDANDDEVICENAMEANDMACADDRESSNOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // デバイスID、デバイス名、MACアドレス未入力メッセージを返す
            return CommonMessage::DEVICEIDANDDEVICENAMEANDMACADDRESSNOTENTERD;
        }

        // デバイスIDバリデーション
        if(!Util::validateID($data['device_id'])){

            // 文字数超過または形式違反メッセージを返す
            return CommonMessage::DEVICEIDCOUNTOVERANDFORMATVIOLATION;
        }

        // デバイスIDおよびユーザID重複チェック
        if(!$deviceModel->isNotDuplicationdevice_id($data)){

            // デバイスID重複メッセージを返す
            return CommonMessage::DEVICEUSED;
        }

        // デバイス名バリデーション
        if(!Util::validateName($data['device_name'])){

            // 文字数超過メッセージを返す
            return CommonMessage::DEVICENAMECOUNTOVER;
        }

        // MACアドレスバリデーション
        if(!$this->validatemacaddress($data)){

            // MACアドレス形式違反メッセージを返す
            return CommonMessage::MACADDRESSFORMATVIOLATION;
        }

        // デバイス登録処理を呼び出す
        if(!$deviceModel->registDeviceInfoModel($data)){

            // 登録失敗メッセージを返す
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
        if(empty($data['device_name']) || empty($data['macaddress']) || empty($data['token'])){

            // デバイス名、MACアドレス名未入力メッセージを返す
            return CommonMessage::DEVICENAMEANDMACADDRESSNOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            
            // デバイス名、MACアドレス名未入力メッセージを返す
            return CommonMessage::DEVICENAMEANDMACADDRESSNOTENTERD;
        }

        // デバイス名バリデーション
        if(!Util::validateName($data['device_name'])){

            // デバイス名文字数超過メッセージを返す
            return CommonMessage::DEVICENAMECOUNTOVER;
        }

        // MACアドレスバリデーション
        if(!$this->validatemacaddress($data)){

            // MACアドレス形式違反メッセージを返す
            return CommonMessage::MACADDRESSFORMATVIOLATION;
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
        if(empty($data['device_id']) || empty($data['token'])){
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
        if(empty($data['user_id']) || empty($data['token'])){
            return false;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            return false;
        }

        // デバイス情報全削除処理を呼び出す
        if(!$deviceModel->deleteAllDeviceInfoModel($data)){
            return false;
        }

        // デバイス情報全削除成功
        return true;
    }

    // MACアドレスのバリデーション
    private function validatemacaddress($data){

        // MACアドレスのフォーマット
        $format = '/^([0-9A-Fa-f]{2}-){5}[0-9A-Fa-f]{2}$/';

        // MACアドレス
        $macStr = $data['macaddress'];

        // バリデーション結果を返す
        return preg_match($format, $macStr);
    }
}