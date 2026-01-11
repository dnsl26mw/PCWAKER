<?php

require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../database/deviceTable.php';

Class DeviceModel{

    // デバイスIDおよびユーザID重複チェック
    public function isNotExsistDeviceID(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();
        
        // デバイスIDおよびユーザID重複の有無を返す
        return !$dbRow = DeviceTable::searchDeviceInfo($data, $db);
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
        $retRow = deviceTable::searchDeviceInfo($data, $db);

        return $retRow;
    }

    // デバイス情報全取得
    public function getDeviceInfoAllModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 指定されたユーザに紐づくデバイス情報のレコードを取得
        $retDt = deviceTable::searchDeviceInfoAll($data, $db);

        return $retDt;
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

        // 全削除処理を呼び出す
        return deviceTable::deleteDeviceInfoAll($data, $db);
    }

    // マジックパケット送信
    public function sendMagickPacketModel($data){

        $retBool = true;

        try{
            // ソケット
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

            foreach($data['selectdevices'] as $device){

                // デバイス情報
                $deviceInfo = $this->getDeviceInfoModel($data);

                // ブロードキャストIPアドレス
                $bloadCastIpAddress = '255.255.255.255';

                // MACアドレス
                $macAddress = pack('H12', (str_replace(['-'], '', $deviceInfo['macaddress'])));

                // マジックパケット
                $magickPacket = str_repeat(chr(0xFF), 6) . str_repeat($macAddress, 16);

                // ブロードキャスト送信オプションを設定
                socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, 1);

                // マジックパケット送信
                socket_sendto($socket, $magicPacket, strlen($magicPacket), 0, $bloadCastIpAddress, 9);
            }
        }
        catch(Exception $e){
            $retBool = false;
        }
        finally{

            // ソケットを閉じる
            socket_close($socket);

            return $retBool;
        }
    }
}