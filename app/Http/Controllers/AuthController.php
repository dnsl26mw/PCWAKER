<?php

require_once __DIR__ . '/../../Models/AuthModel.php';
require_once __DIR__ . '/../../Service/commonMessage.php';

class AuthController{

    // ログイン
    public function loginController(array $data){

        // ユーザIDおよびパスワード入力チェック
        if(empty($data['userID']) || empty($data['password']) || empty($data['token'])){

            // ユーザIDおよびパスワード未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDNOTENTERD;
        }

        $authModel = new AuthModel();

        // ログイン処理の呼び出し
        if(!$authModel->loginModel($data)){

            // ユーザIDまたはパスワードが違うメッセージを返す
            return CommonMessage::USERIDORPASSWORDUNMATCHED;
            exit;  
        }

        // セッションにユーザIDをセット
        Util::setSession($data['userID']);
    }

    // ログアウト
    public function logoutController(array $data){

        if(empty($data['token'])){
            return;
        }

        // ログアウト処理の呼び出し
        $authModel = new AuthModel();
        return $authModel->logoutModel($data);
    }
}
?>