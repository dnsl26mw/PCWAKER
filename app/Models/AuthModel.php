<?php

require_once __DIR__ . '/../../database/DbConnect.php';
require_once __DIR__ . '/../../database/UserTable.php';
require_once __DIR__ . '/../Support/Util.php';
require_once __DIR__ . '/../Support/CommonMessage.php';

class AuthModel{
    
    // パスワードのみの照合
    public function onlyPasswordCheckModel(array $data){

        // DBへの接続
        $db = DBConnect::getDBConnect();

        // 現在のユーザ情報を取得
        $dbRow = UserTable::searchUserInfo($data, $db);

        // 入力されたパスワードをハッシュ化
        $password = Util::getHashPassword($dbRow['salt'], $data['oldPassword']);

        // パスワード照合結果を返す
        return $dbRow['password'] === $password;
    }
}
?>