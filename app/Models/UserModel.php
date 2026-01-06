<?php

require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../database/userTable.php';
require_once __DIR__ . '/../Service/util.php';

Class UserModel{

    // ユーザID重複チェック
    public function isNotDuplicationuser_id(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();
        
        // ユーザID重複の有無を返す
        return !$dbRow = UserTable::searchUserInfo([
            'user_id' => $data['user_id']],
        $db);
    }

    // ユーザ情報登録
    public function registUserInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // ソルト用文字列を取得
        $salt = Util::hashConvert(Util::retRandomStr());

        // DB登録用パスワードを取得
        $password = Util::getHashPassword($salt, $data['password']);

        // 登録処理を呼び出す
        return UserTable::registUserInfo([
            'user_id' => $data['user_id'],
            'password' => $password,
            'salt' => $salt,
            'user_name' => $data['user_name']
        ],$db);
    }

    // ユーザ情報取得
    public function getUserInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 指定されたユーザのレコードを取得
        $retRow = UserTable::searchUserInfo($data, $db);

        return $retRow;
    }

    // パスワード以外のユーザ情報更新
    public function updateUserInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 更新処理を呼び出す
        return UserTable::updateUserInfo($data, $db);
    }

    // パスワードの更新
    public function updatePasswordModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // ソルト用文字列を取得
        $salt = Util::hashConvert(Util::retRandomStr());

        // DB登録用パスワードを取得
        $password = Util::getHashPassword($salt, $data['newPassword']);

        // 更新処理を呼び出す
        return UserTable::updateUserInfoPassword([
            'password' => $password,
            'salt' => $salt,
            'user_id' => $data['user_id']
        ], $db);
    }

    // ユーザ情報削除
    public function deleteUserInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 削除処理を呼び出す
        return UserTable::deleteUserInfo($data, $db);
    }
}