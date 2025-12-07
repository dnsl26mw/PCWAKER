<?php

require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Models/AuthModel.php';
require_once __DIR__ . '/../../Service/commonMessage.php';
require_once __DIR__ . '/../../Service/util.php';

Class UserController{

    // ユーザ情報取得
    public function getUserInfoController(array $data){

        $userModel = new UserModel();

        // 指定されたユーザIDのユーザ情報を取得
        $retRow = $userModel->getUserInfoModel($data);

        // 取得したユーザ情報を返す
        return ['userInfo' => $retRow];
    }

    // ユーザ情報登録
    public function registController(array $data){

        $userModel = new UserModel();

        //  ユーザID、パスワード、ユーザ名の未入力チェック
        if(empty($data['userID']) || empty($data['password']) || empty($data['userName'] || empty($data['token']))){

            // ユーザID、パスワード、ユーザ名未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        // CSRFトークン判定
        if(Util::verificationToken()){

            // ユーザID、パスワード、ユーザ名未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        // ユーザID重複チェック
        if(!$userModel->isNotDuplicationUserID(['userID' => $data['userID']])){

            // ユーザID重複メッセージを返す
            return CommonMessage::USERIDUSED;
        }

        // ユーザ登録処理を呼び出す
        if(!$userModel->registModel($data)){

            // ユーザ登録失敗メッセージを返す
            return CommonMessage::REGISTFAILURE;
        }

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        // セッションにユーザIDをセット
        Util::setSession($data['userID']);

        // ユーザ登録成功画面へ遷移
        header("Location: /registeduser");
        exit;
    }

    // ユーザ情報更新
    public function updateUserInfoController(array $data){

        $userModel = new UserModel();

        // ユーザ情報入力判定
        if(empty($data['userName']) || empty($data['userID']) || empty($data['token'])){

            // ユーザ名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
        }

        // CSRFトークン判定
        if(Util::verificationToken()){
            
            // ユーザ名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
        }

        // パスワード更新を行う場合
        if($data['isUpdatePassword'] === 'updatepassword'){

            // 新旧パスワード入力判定
            if(empty($data['oldPassword']) || empty($data['newPassword'])){

                // 現在のパスワードおよび新しいパスワードが未入力メッセージを返す
                return CommonMessage::OLDPASSWORDANDNEWPASSWORDNOTENTERD;
            }

            $authModel = new AuthModel();

            // 旧パスワード判定
            if(!$authModel->onlyPasswordCheckModel($data)){

                // 旧パスワードが違うメッセージを返す
                return CommonMessage::OLDPASSWORDNOTMATCHED;
            }

            // パスワード更新
            if(!$userModel->updatePasswordModel($data)){

                // 更新失敗メッセージを返す
                return CommonMessage::UPDATEFAILURE;
            }
        }

        // パスワード以外のユーザ情報の更新
        if(!$userModel->updateUserInfoModel($data)){

            // 更新失敗メッセージを返す
            return CommonMessage::UPDATEFAILURE;
        }

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        // 更新成功を表す空文字列を返す
        return '';
    }

    // ユーザ情報削除
    public function deleteController(array $data){

        $userModel = new UserModel();

        // ユーザIDまたはトークンが未セット
        if(empty($data['userID']) || empty($data['token'])){
            header("Location: /deleteConfirm");
            exit;
        }

        // CSRFトークン判定
        if(Util::verificationToken()){
            header("Location: /deleteConfirm");
            exit;
        }

        // ユーザ削除処理を呼び出す
        if(!$userModel->deleteModel($data)){

            // 削除失敗
            header("Location: /deleteConfirm");
            exit;
        }

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        // ユーザ情報削除完了画面に遷移
        header("Location: /deleteConfirm");
        exit;
    }
}