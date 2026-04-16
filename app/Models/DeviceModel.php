<?php

require_once __DIR__ . '/../../database/DbConnect.php';
require_once __DIR__ . '/../../database/DeviceTable.php';
require_once __DIR__ . '/../../database/SqlGenelator.php';

Class DeviceModel{

    // デバイスIDおよびユーザID重複チェック
    public function isNotExsistDeviceID(array $data){
        
        // デバイス情報を検索して取得
        $dbRow = $this->getDeviceInfoModel($data);

        // 取得結果を返す
        return ($dbRow === false);
    }

    // デバイス情報登録
    public function registDeviceInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // INSERT対象カラム名配列
        $insertColumns = [deviceTable::DEVICE_ID_COLUMN, deviceTable::DEVICE_NAME_COLUMN, deviceTable::MACADDRESS_COLUMN, deviceTable::USER_ID_COLUMN];

        // デバイス情報を登録するSQL文を生成
        $sql = sqlGenelator::InsertQueryGenelator(deviceTable::DEVICETABLE_NAME, $insertColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        try{

            // プレースホルダに値をバインドして実行
            $stmt->execute(array($data['device_id'],  $data['device_name'], $data['macaddress'], $data['user_id']));
            return true;
        }
        catch(Exception $e){

            return false;
        }
    }

    // デバイス情報取得
    public function getDeviceInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // SELECT対象カラム名配列
        $selectColumns = [deviceTable::DEVICE_ID_COLUMN, deviceTable::DEVICE_NAME_COLUMN, deviceTable::MACADDRESS_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [deviceTable::DEVICE_ID_COLUMN, deviceTable::USER_ID_COLUMN];

        // WHERE条件同士をANDで連結するための演算子
        $signs = ['AND'];

        // ユーザーIDを条件にデバイス情報を取得するSQL文を生成
        $sql = sqlGenelator::SelectQueryGenelator($selectColumns, deviceTable::DEVICETABLE_NAME, $whereColumns, $signs);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // WHERE句のプレースホルダに値をバインドして実行
        $stmt->execute(array($data['device_id'], $data['user_id']));

        // 指定されたデバイス情報のレコードを取得
        $retRow = $stmt->fetch();

        // デバイス情報を返す
        return $retRow;
    }

    // デバイス一覧情報取得
    public function getDeviceListInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // SELECT対象カラム名配列
        $selectColumns = [deviceTable::DEVICE_ID_COLUMN, deviceTable::DEVICE_NAME_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [deviceTable::USER_ID_COLUMN];

        // ユーザーIDを条件にデバイス一覧情報を取得するSQL文を生成
        $sql = sqlGenelator::SelectQueryGenelator($selectColumns, deviceTable::DEVICETABLE_NAME, $whereColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // WHERE句のプレースホルダに値をバインドして実行
        $stmt->execute(array($data['user_id']));

        // 実行結果を連想配列として全件取得
        $retDt = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // デバイス一覧情報を返す
        return $retDt;
    }

    // デバイス情報更新
    public function updateDeviceInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // UPDATE対象カラム名配列
        $updateColumns = [deviceTable::DEVICE_NAME_COLUMN, deviceTable::MACADDRESS_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [deviceTable::DEVICE_ID_COLUMN];

        // デバイスIDを条件にデバイス情報を更新するSQL文を生成
        $sql = sqlGenelator::UpdateQueryGenelator(deviceTable::DEVICETABLE_NAME, $updateColumns, $whereColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        try{

            // プレースホルダに値をバインドして実行
            $stmt->execute(array($data['device_name'], $data['macaddress'], $data['device_id']));
            return true;
        }
        catch(Exception $e){

            return false;
        }
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