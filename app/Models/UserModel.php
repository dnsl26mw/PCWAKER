<?php

require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../database/dbUtil.php';
require_once __DIR__ . '/../Service/util.php';

Class UserModel{

    // ユーザID重複チェック
    public function isNotDuplicationUserID(array $data){

        // DBへの接続
        $db = DBConnect::getDBConnect();
        
        // ユーザID重複の有無を返す
        return !$dbRow = DBUtil::searchUserInfo([
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
            $retFlg = DBUtil::registUserInfo([
                'userID' => $data['userID'],
                'password' => $password,
                'salt' => $salt,
                'userName' => $data['userName']
            ],$db);
        }

        return $retFlg;
    }

    // ユーザ情報取得
    public function getUserInfoModel(array $data){

        // DBへの接続
        $db = DBConnect::getDBConnect();

        // 指定されたユーザのレコードを返す
        $retRow = DBUtil::searchUserInfo([
            'userID' => $data['userID']
        ], $db);
        return $retRow;
    }

    // パスワード以外のユーザ情報更新
    public function updateModel(array $data){

        $retFlg = false;

        if($data['userID'] === $_SESSION['user_id'] && $data['token'] === $_SESSION['token']){

            // DBへの接続
            $db = DBConnect::getDBConnect();

            // 更新処理を呼び出す
            $retFlg = DBUtil::updateUserInfo($data, $db);
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
            $retFlg = DBUtil::updateUserInfoPassword([
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
            $retFlg = DBUtil::deleteUserInfo($data, $db);
        }
        else{
            $retFlg = false;
        }

        return $retFlg;
    }
}