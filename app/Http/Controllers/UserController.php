<?php

require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Support/CommonMessage.php';
require_once __DIR__ . '/../../Support/Util.php';
require_once __DIR__ . '/../../Support/RequestKey.php';
require_once __DIR__ . '/../../Service/UserService.php';


Class UserController{

    // ユーザ情報取得
    public function getUserInfoController(array $data){

        $userModel = new UserModel();

        // 指定されたユーザIDのユーザ情報を取得し、返す
        return $userModel->getUserInfoModel($data);
    }

    // ユーザ情報登録
    public function registUserInfoController(array $data){

        $userModel = new UserModel();

        // ユーザ情報入力判定
        if(empty($data[RequestKey::USER_ID]) || empty($data[RequestKey::PASSWORD]) || empty($data[RequestKey::USER_NAME]) || empty($data[RequestKey::TOKEN])){

            // ユーザID、パスワード、ユーザ名未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        // ユーザ情報登録処理を呼び出す
        $userService = new UserService();
        $retStr = $userService->registUserInfoService($data);

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        return $retStr;
    }

    // ユーザ情報更新
    public function updateUserInfoController(array $data){

        // ユーザ情報入力判定
        if(empty($data[RequestKey::USER_ID]) || empty($data[RequestKey::USER_NAME]) || empty($data[RequestKey::TOKEN])){

            // ユーザ名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
        }

        // パスワード入力判定
        if($data[RequestKey::ISUPDATEPASSWORD] === 'updatepassword' && (empty($data[RequestKey::OLDPASSWORD]) || empty($data[RequestKey::NEWPASSWORD]))){

            // 現在のパスワードおよび新しいパスワードが未入力メッセージを返す
            return CommonMessage::OLDPASSWORDANDNEWPASSWORDNOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            
            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        // ユーザ情報更新処理を呼び出す
        $userService = new UserService();
        $retStr = $userService->updateUserInfoService($data, $data[RequestKey::ISUPDATEPASSWORD] === 'updatepassword');

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        return $retStr;
    }

    // ユーザ情報削除
    public function deleteUserInfoController(array $data){

        // ユーザIDまたはトークンが未セット
        if(empty($data[RequestKey::USER_ID]) || empty($data[RequestKey::TOKEN])){

            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // 操作の有効期限切れメッセージを返す
            return CommonMessage::OPERATIONTIMEOUT;
        }

        // ユーザ情報削除処理を呼び出す
        $userService = new UserService();
        if(!$userService->deleteUserInfoService($data)){

            // 削除失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // 削除成功を表す空文字列を返す
        return '';
    }
}