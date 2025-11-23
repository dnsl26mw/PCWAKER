<?php

require_once __DIR__ . '/../../Models/AuthModel.php';
require_once __DIR__ . '/../../Service/commonMessage.php';

class AuthController{

    // ログイン
    public function loginController(array $data){

        $authModel = new AuthModel();

        // ログイン失敗時メッセージ
        $retStr = '';

        // ユーザIDおよびパスワードの未入力チェック
        if(!empty($data['userID']) && !empty($data['password']) && !empty($data['token'])){
            // ログイン処理の呼び出し
            $retStr = $authModel->loginModel($data);
        }
        else{
            $retStr = CommonMessage::USERIDANDPASSWORDNOTENTERD;
        }

        if($retStr != ''){
            return $retStr;
            exit;
        }

        // リクエストされたURLに遷移
        $url = Util::parseURL();
        header("Location: $url");
    }

    // ログアウト
    public function logoutController(){

        $authModel = new AuthModel();

        // ログアウト処理の呼び出し
        $authModel->logoutModel();

        // トップページURLに戻す
        header("Location: /");
    }
}
?>