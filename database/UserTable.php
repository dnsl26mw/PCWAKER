<?php

require_once __DIR__ . '/../app/Support/Util.php';

class UserTable {

    // テーブル名
    public const USERTABLE_NAME = 'usertable';

    // カラム名定数
    public const USER_ID_COLUMN = 'user_id';
    public const SALT_COLUMN = 'salt';
    public const PASSWORD_COLUMN = 'user_password';
    public const USER_NAME_COLUMN = 'user_name';

    // パスワード以外のユーザ情報更新
    public static function updateUserInfo(array $data, $db){
        try{
            $registStmt = $db->prepare('UPDATE usertable SET user_name = ? WHERE user_id = ?');
            $registStmt->execute(array($data['user_name'], $data['user_id']));
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
            $registStmt->execute(array($data['password'], $data['salt'], $data['user_id']));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }
}
?>