<?php

require_once __DIR__ . '/../../Service/DeviceService.php';
require_once __DIR__ . '/../../Support/CommonMessage.php';
require_once __DIR__ . '/../../Support/RequestKey.php';
require_once __DIR__ . '/../../Support/Util.php';

Class DeviceController{

    // デバイス一覧情報取得
    public function getDeviceListInfoController(array $data){

        // 指定されたユーザIDに紐づくデバイス情報を取得し、返す
        $deviceModel = new DeviceModel();
        return $deviceModel->getDeviceListInfoModel($data);
    }

    // デバイス情報取得
    public function getDeviceInfoController(array $data){

        // 指定されたデバイスIDのデバイス情報を取得し、返す
        $deviceModel = new DeviceModel();
        return $deviceModel->getDeviceInfoModel($data);
    }

    // デバイス情報登録
    public function registDeviceInfoController(array $data){

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

        // デバイス登録処理を呼び出す
        $deviceService = new DeviceService();
        $retStr = $deviceService->registDeviceInfoService($data);

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        return $retStr;
    }

    // デバイス情報更新
    public function updateDeviceInfoController(array $data){

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

        // デバイス情報の更新処理を呼び出す
        $deviceService = new DeviceService();
        $retStr = $deviceService->updateDeviceInfoService($data);

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        return $retStr;
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

        // マジックパケット送信処理を呼び出す
        $deviceService = new DeviceService();
        $retStr = $deviceService->sendMagicPacketService($data);

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        return $retStr;
    }
}