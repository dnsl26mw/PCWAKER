<?php

require_once __DIR__ . '/../../Models/DeviceModel.php';
require_once __DIR__ . '/../../Support/CommonMessage.php';
require_once __DIR__ . '/../../Support/RequestKey.php';
require_once __DIR__ . '/../../Support/Util.php';

Class DeviceController{

    // デバイス一覧情報取得
    public function getDeviceListInfoController(array $data){

        $deviceModel = new DeviceModel();

        // 指定されたユーザIDに紐づくデバイス情報を取得し、返す
        return $deviceModel->getDeviceListInfoModel($data);
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
        if(empty($data[RequestKey::DEVICE_ID]) || empty($data[RequestKey::DEVICE_NAME]) || empty($data[RequestKey::MACADDRESS]) || empty($data[RequestKey::TOKEN])){

            // デバイスID、デバイス名、MACアドレス未入力メッセージを返す
            return CommonMessage::DEVICEIDANDDEVICENAMEANDMACADDRESSNOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        // デバイスIDバリデーション
        if(!Util::validateID($data['device_id'])){

            // 文字数超過または形式違反メッセージを返す
            return CommonMessage::DEVICEIDCOUNTOVERANDFORMATVIOLATION;
        }

        // デバイスIDおよびユーザID重複チェック
        if(!$deviceModel->isNotExsistDeviceID($data)){

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
        if(empty($data[RequestKey::DEVICE_ID]) || empty($data[RequestKey::DEVICE_NAME]) || empty($data[RequestKey::TOKEN])){

            // デバイス名、MACアドレス名未入力メッセージを返す
            return CommonMessage::DEVICENAMEANDMACADDRESSNOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            
            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
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
        if(empty($data[RequestKey::DEVICE_ID]) || empty($data[RequestKey::TOKEN])){

            // 削除失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            
            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        // デバイス削除処理を呼び出す
        if(!$deviceModel->deleteDeviceInfoModel($data)){
            
            // 削除失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // 削除成功を表す空文字列を返す
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

    // マジックパケット送信
    public function sendMagickPacketController($data){

        // デバイスが未選択
        if(empty($data['selectdevices'])){

            // デバイス未選択メッセージを返す
            return CommonMessage::DEVICENOTSELECTED;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        $deviceModel = new DeviceModel();

        // デバイスIDが全てログイン中ユーザに紐づくことを確認
        foreach($data['selectdevices'] as $device){

            $checkData = [
                RequestKey::DEVICE_ID => $device,
                RequestKey::USER_ID => $data[RequestKey::USER_ID]
            ];
            
            if($deviceModel->isNotExsistDeviceID($checkData)){

                // マジックパケット送信失敗メッセージを返す
                return CommonMessage::SENDMAGICKPACKETFAILURE;
            }
        }

        // マジックパケット送信処理を呼び出す
        if(!$deviceModel->sendMagickPacketModel($data)){

            // マジックパケット送信失敗メッセージを返す
            return CommonMessage::SENDMAGICKPACKETFAILURE;
        }

        // 送信成功を表す空文字列を返す
        return '';
    }
}