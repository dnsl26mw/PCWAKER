<?php

require_once __DIR__ . '/../../database/Infrastructure/DbConnect.php';
require_once __DIR__ . '/../../database/Tables/UserTable.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Support/Util.php';
require_once __DIR__ . '/../Support/RequestKey.php';

class AuthService{

    // ログイン
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

    // パスワードのみの照合
    public function onlyPasswordCheckService(array $data){

        // 現在のユーザ情報を取得
        $userModel = new UserModel();
        $dbRow = $userModel->getUserInfoModel($data);

        // 入力されたパスワードをハッシュ化
        $password = Util::getHashPassword($dbRow[RequestKey::SALT], $data[RequestKey::OLDPASSWORD]);

        // パスワード照合結果を返す
        return $dbRow[UserTable::PASSWORD_COLUMN] === $password;
    }
}

?>