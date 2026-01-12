<?php

require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Models/AuthModel.php';
require_once __DIR__ . '/../../Service/commonMessage.php';
require_once __DIR__ . '/../../Service/util.php';

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
        if(empty($data['user_id']) || empty($data['password']) || empty($data['user_name']) || empty($data['token'])){

            // ユーザID、パスワード、ユーザ名未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // ユーザID、パスワード、ユーザ名未入力メッセージを返す
            return CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        // ユーザID半角英数字バリデーション
        if(!Util::validateID($data['user_id'])){

            // ユーザIDが20文字以内の記号なし半角英数字ではないメッセージを返す
            return CommonMessage::USERIDNOTHALFSIZENUMBER;
        }

        // ユーザID重複チェック
        if(!$userModel->isNotExsistUserID($data)){

            // ユーザID重複メッセージを返す
            return CommonMessage::USERIDUSED;
        }

        // パスワードバリデーション
        if(!$this->validatePassword($data['password'])){

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

        $userModel = new UserModel();

        // ユーザ情報入力判定
        if(empty($data['user_id']) || empty($data['user_name']) || empty($data['token'])){

            // ユーザ名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){
            
            // ユーザ名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
        }

        // ユーザ名バリデーション
        if(!Util::validateName($data['user_name'])){

            // 文字数超過メッセージを返す
            return CommonMessage::USERNAMECOUNTOVER;
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

            // 新パスワードバリデーション
            if(!$this->validatePassword($data['newPassword'])){

                // 文字数不足または超過メッセージを返す
                return '新しい'.CommonMessage::PASSWORDCOUNTUNDEROROVER;
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
    public function deleteUserInfoController(array $data){

        // ユーザIDまたはトークンが未セット
        if(empty($data['user_id']) || empty($data['token'])){

            // 削除失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // CSRFトークン判定
        if(!Util::verificationToken($data)){

            // 削除失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // ユーザ情報削除処理を呼び出す
        $userModel = new UserModel();
        if(!$userModel->deleteUserInfoModel($data)){

            // 削除失敗メッセージを返す
            return CommonMessage::DELETEFAILURE;
        }

        // 削除成功を表す空文字列を返す
        return '';
    }

    // パスワードバリデーション
    private static function validatePassword($str){

        // 最小文字数
        $minCount = 8;

        // 最小文字数以上かを返す
        return mb_strlen($str) >= $minCount;
    }
}