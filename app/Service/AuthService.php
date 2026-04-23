<?php

require_once __DIR__ . '/../../database/DbConnect.php';
require_once __DIR__ . '/../../database/UserTable.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Support/Util.php';
require_once __DIR__ . '/../Support/RequestKey.php';

class AuthService{

    // ログイン処理
    public function loginService(array $data){

        // ユーザを検索
        $userModel = new UserModel();
        $dbRow = $userModel->getUserInfoModel($data);

        // ユーザが存在しない場合
        if($dbRow === false){

            return false;
        }

        // 入力されたパスワードをハッシュ化
        $password = Util::getHashPassword($dbRow[RequestKey::SALT], $data[RequestKey::PASSWORD]);

        // ソルト + 入力されたパスワードが登録されたパスワードと不一致の場合
        if($password !== $dbRow[UserTable::PASSWORD_COLUMN]){

            return false;
        }

        // ログイン成功
        return true;
    }
}

?>