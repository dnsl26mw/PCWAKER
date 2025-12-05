<?php

require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../database/userTable.php';
require_once __DIR__ . '/../Service/util.php';

Class UserModel{

    // ユーザID重複チェック
    public function isNotDuplicationUserID(array $data){

        // DBへの接続
        $db = DBConnect::getDBConnect();
        
        // ユーザID重複の有無を返す
        return !$dbRow = UserTable::searchUserInfo([
            'userID' => $data['userID']],
        $db);
    }

    // ユーザ情報登録
    public function registModel(array $data){

        $retFlg = false;

        if($data['token'] === $_SESSION['token']){

            // DBへの接続
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
    }

    // ユーザ情報取得
    public function getUserInfoModel(array $data){

        // DBへの接続
        $db = DBConnect::getDBConnect();

        // 指定されたユーザのレコードを返す
        $retRow = UserTable::searchUserInfo([
            'userID' => $data['userID']
        ], $db);
        return $retRow;
    }

    // パスワード以外のユーザ情報更新
    public function updateUserInfoModel(array $data){

        $retFlg = false;

        if($data['userID'] === $_SESSION['user_id'] && $data['token'] === $_SESSION['token']){

            // DBへの接続
            $db = DBConnect::getDBConnect();

            // 更新処理を呼び出す
            $retFlg = UserTable::updateUserInfo($data, $db);
        }
        
        return $retFlg;
    }

    // パスワードの更新
    public function updatePasswordModel(array $data){

        $retFlg = false;

        if($data['userID'] === $_SESSION['user_id'] && $data['token'] === $_SESSION['token']){

            // DBへの接続
            $db = DBConnect::getDBConnect();

            // ソルト用文字列を取得
            $salt = Util::hashConvert(Util::retRandomStr());

            // DB登録用パスワードを取得
            $password = Util::getHashPassword($salt, $data['newPassword']);

            // 更新処理を呼び出す
            $retFlg = UserTable::updateUserInfoPassword([
                'password' => $password,
                'salt' => $salt,
                'userID' => $data['userID']
            ], $db);
        }

        return $retFlg;
    }

    // ユーザ情報削除
    public function deleteModel(array $data){

        $retFlg = false;

        if($data['userID'] === $_SESSION['user_id'] && $data['token'] === $_SESSION['token']){

            // DBへの接続
            $db = DBConnect::getDBConnect();

            // 削除処理を呼び出す
            $retFlg = UserTable::deleteUserInfo($data, $db);
        }
        else{
            $retFlg = false;
        }

        return $retFlg;
    }
}