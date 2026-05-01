<?php

require_once __DIR__ . '/../../Support/CommonMessage.php';
require_once __DIR__ . '/../../Support/RequestKey.php';
require_once __DIR__ . '/../../Service/AuthService.php';
require_once __DIR__ . '/../../Support/RequestKey.php';

class AuthController{

    // ログイン
    public function loginController(array $data){

        // ユーザ情報入力判定
        if(empty($data[RequestKey::USER_ID]) || empty($data[RequestKey::PASSWORD]) || empty($data[RequestKey::TOKEN])){

            // ユーザIDおよびパスワード未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDNOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            
            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        // ログイン処理呼び出し
        $authService = new AuthService();
        if(!$authService->loginService($data)){

            // ユーザIDまたはパスワード不一致のメッセージを返す
            return CommonMessage::USERIDORPASSWORDUNMATCHED;
            exit;
        }

        // セッションからCSRFトークンを削除
        Util::deleteToken();
    
        // セッションにユーザIDをセット
        Util::setSession($data[RequestKey::USER_ID]);
    
        // ログイン成功を表す空文字列を返す
        return '';
    }

    // ログアウト
    public function logoutController(array $data){

        // CSRFトークンが未セット
        if(empty($data[RequestKey::TOKEN])){

            // ログアウト失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        // セッション情報の削除
        $_SESSION = array();
        session_destroy();

        // ログアウト成功を表す空文字列を返す
        return '';
    }
}
?>