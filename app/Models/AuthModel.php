<?php

require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../database/userTable.php';
require_once __DIR__ . '/../Service/util.php';
require_once __DIR__ . '/../Service/commonMessage.php';

class AuthModel{

    // ログイン処理
    public function loginModel(array $data){

        // トークン判定
        if($data['token'] !== $_SESSION['token']){
            return false;
        }

        // DBに接続
        $db = DBConnect::getDBConnect();

        // ユーザを検索
        $dbRow = UserTable::searchUserInfo(['userID' => $data['userID']], $db);

        // ユーザが存在しない場合
        if(!$dbRow){
            return false;
        }

        // 入力されたパスワードをハッシュ化
        $password = Util::getHashPassword($dbRow['salt'], $data['password']);

        // ソルト + 入力されたパスワードが登録されたパスワードと不一致の場合
        if($password !== $dbRow['password']){
            return false;
        }

        // ログイン成功
        return true;
    }
    
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

    // ログアウト処理
    public function logoutModel(){

        // セッション情報の削除
        $_SESSION = array();
        session_destroy();
    }
}
?>