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

        // ログイン処理の呼び出し
        $authModel = new AuthModel();
        $loginFailmsg = $authModel->loginModel($data);

        // ログイン失敗の場合
        if(!$authModel->loginModel($data)){

            // ユーザIDまたはパスワードが違うメッセージを返す
            return CommonMessage::USERIDORPASSWORDUNMATCHED;
            exit;  
        }

        // セッションにユーザIDをセット
        Util::setSession($data['userID']);

        // リクエストされたURLに遷移
        $url = Util::parseURL();
        header("Location: $url");
    }

    // ログアウト
    public function logoutController(){

        // ログアウト処理の呼び出し
        $authModel = new AuthModel();
        $authModel->logoutModel();

        // トップページURLに戻す
        header("Location: /");
    }
}
?>