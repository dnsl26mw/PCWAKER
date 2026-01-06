<?php

require_once __DIR__ . '/../app/Service/util.php';

class DeviceTable {
    
    // デバイス情報全検索
    public static function searchDeviceInfoAll(array $data, $db){
        $stmt = $db->prepare('SELECT device_id, device_name, macaddress FROM devicetable WHERE user_id=?');
        $stmt->execute(array($data['user_id']));
        $dt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $dt;
    }

    // デバイス情報検索
    public static function searchDeviceInfo(array $data, $db){
        $stmt = $db->prepare('SELECT device_id, device_name, macaddress FROM devicetable WHERE device_id=? AND user_id=?');
        $stmt->execute(array($data['device_id'], $data['user_id']));
        $dbRow = $stmt->fetch();
        return $dbRow;
    }

    // デバイス情報登録
    public static function registDeviceInfo(array $data, $db){
        try{
            $registStmt = $db->prepare('INSERT INTO devicetable(device_id, device_name, macaddress, user_id) VALUES(?, ?, ?, ?)');
            $registStmt->execute(array($data['device_id'],  $data['device_name'], $data['macaddress'], $data['user_id']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    // デバイス情報更新
    public static function updateDeviceInfo(array $data, $db){
        try{
            $registStmt = $db->prepare('UPDATE devicetable SET device_name = ?, macaddress = ? WHERE device_id = ?');
            $registStmt->execute(array($data['device_name'], $data['macaddress'], $data['device_id']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    // デバイス情報削除
    public static function deleteDeviceInfo(array $data, $db){
        try{
            $stmt = $db->prepare('DELETE FROM devicetable WHERE device_id=?');
            $stmt->execute(array($data['device_id']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    // デバイス情報全削除
    public static function deleteDeviceInfoAll(array $data, $db){
        try{
            $stmt = $db->prepare('DELETE FROM devicetable WHERE user_id=?');
            $stmt->execute(array($data['user_id']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }
}
?>