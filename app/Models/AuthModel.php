<?php

require_once __DIR__ . '/../../database/dbConnect.php';
require_once __DIR__ . '/../../database/userTable.php';
require_once __DIR__ . '/../Service/util.php';
require_once __DIR__ . '/../Service/commonMessage.php';

class AuthModel{

    // ログイン処理
    public function loginModel(array $data){

        // トークンが正しい場合
        if($data['token'] === $_SESSION['token']){

            // DBへの接続
            $db = DBConnect::getDBConnect();

            // 入力されたユーザIDを検索
            $dbRow = UserTable::searchUserInfo(['userID' => $data['userID']], $db);
                
            // ユーザIDが存在した場合
            if($dbRow){
                
                // 入力されたパスワードをハッシュ化
                $password = Util::getHashPassword($dbRow['salt'], $data['password']);

                // ソルト + 入力したパスワードが登録済みパスワードと一致した場合
                if($password === $dbRow['password']){
                    
                    // セッションにユーザIDおよびユーザ名をセット
                    Util::setSession($dbRow['user_id'], $dbRow['user_name']);
                }
                else{
                    return CommonMessage::USERIDORPASSWORDUNMATCHED;
                }
            }
            // ユーザIDが存在しなかった場合
            else{
                return CommonMessage::USERIDORPASSWORDUNMATCHED;
            }
        }
        else{
            return CommonMessage::USERIDORPASSWORDUNMATCHED;
        }
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