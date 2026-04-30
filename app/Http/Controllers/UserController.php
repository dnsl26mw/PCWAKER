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

            // ユーザID、パスワード、ユーザ名未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        // ユーザID半角英数字バリデーション
        if(!Util::validateID($data[RequestKey::USER_ID])){

            // ユーザIDが20文字以内の記号なし半角英数字ではないメッセージを返す
            return CommonMessage::USERIDNOTHALFSIZENUMBER;
        }

        // ユーザID重複チェック
        if(!$userModel->isNotExsistUserID($data)){

            // ユーザID重複メッセージを返す
            return CommonMessage::USERIDUSED;
        }

        // パスワードバリデーション
        if(!$this->validatePassword($data[RequestKey::PASSWORD])){

            // 文字数不足または超過メッセージを返す
            return CommonMessage::PASSWORDCOUNTUNDEROROVER;
        }

        // ユーザ名バリデーション
        if(!Util::validateName($data['user_name'])){

            // 文字数超過メッセージを返す
            return CommonMessage::USERNAMECOUNTOVER;
        }

        // ユーザ登録処理を呼び出す
        if(!$userModel->registUserInfoModel($data)){

            // 登録失敗メッセージを返す
            return CommonMessage::REGISTFAILURE;
        }

        // セッションからCSRFトークンを削除
        Util::deleteToken();

        // 登録成功を表す空文字列を返す
        return '';
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
            
            // ユーザ名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
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

            // 削除失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // 削除失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
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