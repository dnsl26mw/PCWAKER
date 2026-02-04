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

            foreach($data['selectdevices'] as $deviceId){

                // デバイス情報
                $deviceInfo = $this->getDeviceInfoModel([
                    'device_id' => $deviceId,
                    'user_id'   => $data['user_id']
                ]);

                // ブロードキャストIPアドレス
                $bloadCastIpAddress = '255.255.255.255';

                // MACアドレス変換フォーマット
                $macAddressConvertFormat = 'H12';

                // MACアドレス
                $macAddress = $deviceInfo['macaddress'];
                $macAddress = str_replace(['-'], '', $macAddress);
                $macAddress = pack($macAddressConvertFormat, $macAddress);

                // ブロードキャスト送信フラグ
                $bloadCastFlag = 1;

                // 送信オプションデフォルトフラグ
                $sendOptionDefaultFlag = 0;

                // 宛先ポート番号
                $port = 9;

                // マジックパケットヘッダ繰り返し回数
                $magickPacketHeaderRepeatCount = 6;

                // MACアドレス繰り返し回数
                $macAddressRepeatCount = 16;

                // マジックパケット
                $magickPacket = str_repeat(chr(0xFF), $magickPacketHeaderRepeatCount) . str_repeat($macAddress, $macAddressRepeatCount);

                // ブロードキャスト送信オプションを設定
                socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, $bloadCastFlag);

                // 送信回数
                $sendCount = 3;

                // マジックパケット送信
                for($i = 0; $i < $sendCount; $i++){
                    socket_sendto($socket, $magickPacket, strlen($magickPacket), $sendOptionDefaultFlag, $bloadCastIpAddress, $port);
                }
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