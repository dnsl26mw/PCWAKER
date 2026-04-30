<?php

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Support/CommonMessage.php';
require_once __DIR__ . '/../Service/AuthService.php';
require_once __DIR__ . '/../Support/RequestKey.php';

class UserService{

    // ユーザ情報削除
    public function deleteUserInfoService(array $data){

        // DBに接続
        $db = DBConnect::getDBConnect();

        // トランザクションの開始
        $db->beginTransaction();

        try{

            // 指定されたユーザIDに紐づくデバイス情報を全て削除
            $userModel = new DeviceModel();
            $userModel->deleteAllDeviceInfoModel($data, $db);

            // 指定されたユーザIDのユーザ情報を削除
            $userModel = new UserModel();
            $userModel->deleteUserInfoModel($data, $db);

            // 成功した場合はコミット
            $db->commit();

            return true;
        }
        catch(Exception $e){

            // 失敗した場合はロールバック
            $db->rollback();

            return false;
        }
    }

    // ユーザ情報更新
    public function updateUserInfoService(array $data, $updatePasswordFlg){

        // ユーザ名バリデーション
            if(!Util::validateName($data[RequestKey::USER_NAME])){

            // 文字数超過メッセージを返す
            return CommonMessage::USERNAMECOUNTOVER;
        }

        // パスワードを更新する場合
        if($updatePasswordFlg){

            // 旧パスワードの照合
            $authService = new AuthService();
            if(!$authService->onlyPasswordCheckService($data)){

                // 旧パスワード不一致のメッセージを返す
                return CommonMessage::OLDPASSWORDNOTMATCHED;
            }

            // 新パスワードバリデーション
            if(!$this->validatePassword($data[RequestKey::NEWPASSWORD])){

                // 文字数不足または超過メッセージを返す
                return '新しい'.CommonMessage::PASSWORDCOUNTUNDEROROVER;
            }
        }

        // DBに接続
        $db = DBConnect::getDBConnect();

        // トランザクションの開始
        $db->beginTransaction();

        try{

            $userModel = new UserModel();

            // パスワードの更新
            if($updatePasswordFlg){

                $userModel->updatePasswordModel($data, $db);
            }

            // パスワード以外のユーザ情報の更新
            $userModel->updateUserInfoModel($data, $db);

            // 成功した場合はコミット
            $db->commit();

            // 更新成功を表す空文字列を返す
            return '';
        }
        catch(Exception $e){

            // 失敗した場合はロールバック
            $db->rollback();

            // 更新失敗メッセージを返す
            return CommonMessage::UPDATEFAILURE;
        }

    }

    // パスワードバリデーション
    private static function validatePassword($str){

        // 最小文字数
        $minCount = 8;

        // 最小文字数以上かを返す
        return mb_strlen($str) >= $minCount;
    }

}

?>