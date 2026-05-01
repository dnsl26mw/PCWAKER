<?php

require_once __DIR__ . '/../Models/DeviceModel.php';
require_once __DIR__ . '/../Support/CommonMessage.php';
require_once __DIR__ . '/../Support/RequestKey.php';
require_once __DIR__ . '/../Support/Util.php';

class DeviceService{

    // デバイス情報登録
    public function registDeviceInfoService(array $data){

        $deviceModel = new DeviceModel();

        // デバイスIDバリデーション
        if(!Util::validateID($data['device_id'])){

            // 文字数超過または形式違反メッセージを返す
            return CommonMessage::DEVICEIDCOUNTOVERANDFORMATVIOLATION;
        }

        // デバイスIDおよびユーザID重複チェックrequire_once __DIR__ . '/../../Models/DeviceModel.php';
        if(!$deviceModel->isNotExsistDeviceID($data)){

            // デバイスID重複メッセージを返す
            return CommonMessage::DEVICEUSED;
        }

        // デバイス名バリデーション
        if(!Util::validateName($data['device_name'])){

            // 文字数超過メッセージを返す
            return CommonMessage::DEVICENAMECOUNTOVER;
        }

        // MACアドレスのバリデーション
        if(!$this->validatemacaddress($data)){

            // MACアドレス形式違反メッセージを返す
            return CommonMessage::MACADDRESSFORMATVIOLATION;
        }

        // デバイス情報登録処理を呼び出す
        if(!$deviceModel->registDeviceInfoModel($data)){

            // 登録失敗メッセージを返す
            return CommonMessage::REGISTFAILURE;
        }
        
        // 登録成功を表す空文字列を返す
        return '';
    }

    // デバイス情報更新
    public function updateDeviceInfoService(array $data){

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

        // デバイス情報の更新処理を呼び出す
        $deviceModel = new DeviceModel();
        if(!$deviceModel->updateDeviceInfoModel($data)){

            // 更新失敗メッセージを返す
            return CommonMessage::UPDATEFAILURE;
        }

        // 更新成功を表す空文字列を返す
        return '';
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