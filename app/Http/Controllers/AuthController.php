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

    public function onlyPasswordCheckController(array $data){

        $authModel = new AuthModel();

        // 未入力および現在のパスワード不一致メッセージ
        $retStr = '';

        if(!empty($data['userID']) && !empty($data['oldPassword']) && !empty($data['newPassword']) && !empty($data['token'])){
            // 現在のパスワードのみ照合する処理の呼び出し
            if(!$authModel->onlyPasswordCheckModel($data)){
                $retStr = CommonMessage::OLDPASSWORDNOTMATCHED;
            }
        }
        else{
            $retStr = CommonMessage::OLDPASSWORDANDNEWPASSWORDNOTENTERD;
        }

        return $retStr;
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