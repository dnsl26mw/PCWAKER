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
    
        // セッションにユーザIDをセット
        $_SESSION[RequestKey::USER_ID] = $data[RequestKey::USER_ID];

        // セッションにログアウト用CSRFトークンをセット
        Util::createToken(true);
    
        // ログイン成功を表す空文字列を返す
        return '';
    }

    // ログアウト
    public function logoutController(array $data){

        // ユーザIDおよびCSRFトークンが未セット
        if(empty($data[RequestKey::USER_ID]) || empty($data[RequestKey::TOKEN])){

            // ログアウト失敗メッセージを返す
            return CommonMessage::LOGOUTFAILURE;
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