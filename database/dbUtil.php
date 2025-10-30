<?php

require_once __DIR__ . '/../app/Service/util.php';

class DBUtil {
    // ユーザ情報検索
    public static function searchUserInfo(array $data, $db){
        $stmt = $db->prepare('SELECT user_id, salt, password, user_name FROM usertable WHERE user_id=?');
        $stmt->execute(array($data['userID']));
        $dbRow = $stmt->fetch();
        return $dbRow;
    }

    // ユーザ情報登録
    public static function registUserInfo(array $data, $db){
        try{
            $registStmt = $db->prepare('INSERT INTO usertable(user_id, salt, password, user_name) VALUES(?, ?, ?, ?)');
            $registStmt->execute(array($data['userID'],  $data['salt'], $data['password'], $data['userName']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    // パスワード以外のユーザ情報更新
    public static function updateUserInfo(array $data, $db){
        try{
            $registStmt = $db->prepare('UPDATE usertable SET user_name = ? WHERE user_id = ?');
            $registStmt->execute(array($data['userID'], $data['userID']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    // パスワードの更新
    public static function updateUserInfoPassword(array $data, $db){
        try{
            $registStmt = $db->prepare('UPDATE usertable SET password = ?, salt = ? WHERE user_id = ?');
            $registStmt->execute(array($data['password'], $data['salt'], $data['userID']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    // ユーザ情報削除
    public static function deleteUserInfo(array $data, $db){
        try{
            $stmt = $db->prepare('DELETE FROM usertable WHERE user_id=?');
            $stmt->execute(array($data['userID']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }
}
?>