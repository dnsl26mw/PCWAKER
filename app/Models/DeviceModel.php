<?php

require_once __DIR__ . '/../../database/Infrastructure/DbConnect.php';
require_once __DIR__ . '/../../database/Tables/DeviceTable.php';
require_once __DIR__ . '/../Support/SqlGenelator.php';
require_once __DIR__ . '/../Support/RequestKey.php';

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
        $db = DbConnect::getDbConnect();

        // INSERT対象カラム名配列
        $insertColumns = [DeviceTable::DEVICE_ID_COLUMN, DeviceTable::DEVICE_NAME_COLUMN, DeviceTable::MACADDRESS_COLUMN, DeviceTable::USER_ID_COLUMN];

        // デバイス情報を登録するSQL文を生成
        $sql = SqlGenelator::InsertQueryGenelator(DeviceTable::DEVICETABLE_NAME, $insertColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        try{

            // プレースホルダに値をバインドして実行
            $stmt->execute(array($data[RequestKey::DEVICE_ID],  $data[RequestKey::DEVICE_NAME], $data[RequestKey::MACADDRESS], $data[RequestKey::USER_ID]));
            return true;
        }
        catch(Exception $e){

            return false;
        }
    }

    // デバイス情報取得
    public function getDeviceInfoModel(array $data){

        // DBに接続
        $db = DbConnect::getDbConnect();

        // SELECT対象カラム名配列
        $selectColumns = [DeviceTable::DEVICE_ID_COLUMN, DeviceTable::DEVICE_NAME_COLUMN, DeviceTable::MACADDRESS_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [DeviceTable::DEVICE_ID_COLUMN, DeviceTable::USER_ID_COLUMN];

        // WHERE条件同士をANDで連結するための演算子
        $signs = ['AND'];

        // ユーザーIDおよびデバイスIDを条件にデバイス情報を取得するSQL文を生成
        $sql = SqlGenelator::SelectQueryGenelator($selectColumns, DeviceTable::DEVICETABLE_NAME, $whereColumns, $signs);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // プレースホルダに値をバインドして実行
        $stmt->execute(array($data['device_id'], $data[RequestKey::USER_ID]));

        // 指定されたデバイス情報のレコードを取得
        $retRow = $stmt->fetch();

        // デバイス情報を返す
        return $retRow;
    }

    // デバイス一覧情報取得
    public function getDeviceListInfoModel(array $data){

        // DBに接続
        $db = DbConnect::getDbConnect();

        // SELECT対象カラム名配列
        $selectColumns = [DeviceTable::DEVICE_ID_COLUMN, DeviceTable::DEVICE_NAME_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [DeviceTable::USER_ID_COLUMN];

        // ユーザーIDを条件にデバイス一覧情報を取得するSQL文を生成
        $sql = SqlGenelator::SelectQueryGenelator($selectColumns, DeviceTable::DEVICETABLE_NAME, $whereColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // WHERE句のプレースホルダに値をバインドして実行
        $stmt->execute(array($data[RequestKey::USER_ID]));

        // 実行結果を連想配列として全件取得
        $retDt = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // デバイス一覧情報を返す
        return $retDt;
    }

    // デバイス情報更新
    public function updateDeviceInfoModel(array $data){

        // DBに接続
        $db = DbConnect::getDbConnect();

        // UPDATE対象カラム名配列
        $updateColumns = [DeviceTable::DEVICE_NAME_COLUMN, DeviceTable::MACADDRESS_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [DeviceTable::DEVICE_ID_COLUMN, UserTable::USER_ID_COLUMN];

        // WHERE条件同士をANDで連結するための演算子
        $signs = ['AND'];

        // デバイスIDを条件にデバイス情報を更新するSQL文を生成
        $sql = SqlGenelator::UpdateQueryGenelator(DeviceTable::DEVICETABLE_NAME, $updateColumns, $whereColumns, $signs);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        try{

            // プレースホルダに値をバインドして実行
            $stmt->execute(array($data[RequestKey::DEVICE_NAME], $data[RequestKey::MACADDRESS], $data[RequestKey::DEVICE_ID], $data[RequestKey::USER_ID]));
            return true;
        }
        catch(Exception $e){

            return false;
        }
    }

    // デバイス情報削除
    public function deleteDeviceInfoModel(array $data){

        // DBに接続
        $db = DbConnect::getDbConnect();

        // WHERE条件カラム名配列
        $whereColumns = [DeviceTable::DEVICE_ID_COLUMN, UserTable::USER_ID_COLUMN];

        // WHERE条件同士をANDで連結するための演算子
        $signs = ['AND'];

        // デバイスIDを条件にデバイス情報を削除するSQL文を生成
        $sql = SqlGenelator::DeleteQueryGenelator(DeviceTable::DEVICETABLE_NAME, $whereColumns, $signs);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        try{

            // プレースホルダに値をバインドして実行
            $stmt->execute(array($data[RequestKey::DEVICE_ID], $data[RequestKey::USER_ID]));
            return true;
        }
        catch(Exception $e){

            return false;
        }
    }

    // デバイス情報全削除
    public function deleteAllDeviceInfoModel(array $data, $db){

        // WHERE条件カラム名配列
        $whereColumns = [DeviceTable::USER_ID_COLUMN];

        // ユーザIDを条件にデバイス情報を削除するSQL文を生成
        $sql = SqlGenelator::DeleteQueryGenelator(DeviceTable::DEVICETABLE_NAME, $whereColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // プレースホルダに値をバインドして実行
        $stmt->execute(array($data[RequestKey::USER_ID]));

        return true;
    }

    // マジックパケット送信
    public function sendMagickPacketModel($data){

        $retBool = true;

        try{
            
            // ソケット
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

            foreach($data[RequestKey::SELECTED_DEVICES] as $deviceId){

                // デバイス情報
                $deviceInfo = $this->getDeviceInfoModel([
                    RequestKey::DEVICE_ID => $deviceId,
                    RequestKey::USER_ID   => $data[RequestKey::USER_ID]
                ]);

                // MACアドレス
                $macAddress = $deviceInfo['macaddress'];
                $macAddress = str_replace(['-'], '', $macAddress);
                $macAddress = pack('H12', $macAddress);

                // マジックパケット
                $magickPacket = str_repeat(chr(0xFF), 6) . str_repeat($macAddress, 16);

                // ブロードキャスト送信オプションを設定
                socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, 1);

                // マジックパケット送信
                for($i = 0; $i < 3; $i++){

                    socket_sendto($socket, $magickPacket, strlen($magickPacket), 0, '255.255.255.255', 9);
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