<?php

require_once __DIR__ . '/../../Models/AuthModel.php';
require_once __DIR__ . '/../../Service/commonMessage.php';

class AuthController{

    // ログイン
    public function loginController(array $data){

        // ユーザ情報入力判定
        if(empty($data['user_id']) || empty($data['password']) || empty($data['token'])){

            // ユーザIDおよびパスワード未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDNOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            
            // ユーザIDおよびパスワード未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDNOTENTERD;
        }

        // ログイン処理の呼び出し
        $authModel = new AuthModel();
        if(!$authModel->loginModel($data)){

            // ユーザIDまたはパスワード不一致のメッセージを返す
            return CommonMessage::USERIDORPASSWORDUNMATCHED;
            exit;  
        }

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        // セッションにユーザIDをセット
        Util::setSession($data['user_id']);

        // ログイン成功を表す空文字列を返す
        return '';
    }

    // ログアウト
    public function logoutController(array $data){

        // CSRFトークンが未セット
        if(empty($data['token'])){

            // ログアウト失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // ログアウト失敗メッセージを返す
            return CommonMessage::LOGOUTFAILURE;
        }

        // セッション情報の削除
        $_SESSION = array();
        session_destroy();

        // ログアウト成功を表す空文字列を返す
        return '';
    }
}
?>