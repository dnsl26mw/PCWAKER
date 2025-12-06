<?php

require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../database/userTable.php';
require_once __DIR__ . '/../Service/util.php';

Class UserModel{

    // ユーザID重複チェック
    public function isNotDuplicationUserID(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();
        
        // ユーザID重複の有無を返す
        return !$dbRow = UserTable::searchUserInfo([
            'userID' => $data['userID']],
        $db);
    }

    // ユーザ情報登録
    public function registModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // ソルト用文字列を取得
        $salt = Util::hashConvert(Util::retRandomStr());

        // DB登録用パスワードを取得
        $password = Util::getHashPassword($salt, $data['password']);

        // 登録処理を呼び出す
        return UserTable::registUserInfo([
            'userID' => $data['userID'],
            'password' => $password,
            'salt' => $salt,
            'userName' => $data['userName']
        ],$db);
    }

    // ユーザ情報取得
    public function getUserInfoModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 指定されたユーザのレコードを取得
        $retRow = UserTable::searchUserInfo([
            'userID' => $data['userID']
        ], $db);

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
            'userID' => $data['userID']
        ], $db);
    }

    // ユーザ情報削除
    public function deleteModel(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // 削除処理を呼び出す
        return UserTable::deleteUserInfo($data, $db);
    }
}