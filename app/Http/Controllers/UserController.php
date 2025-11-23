<?php

require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Models/AuthModel.php';
require_once __DIR__ . '/../../Service/commonMessage.php';

Class UserController{

    // ユーザ情報登録
    public function registController(array $data){

        $userModel = new UserModel();

        // ユーザID重複時のメッセージ
        $retStr = '';

        //  ユーザID、パスワード、ユーザ名の未入力チェック
        if(!empty($data['userID']) && !empty($data['password']) && !empty($data['userName'] && !empty($data['token']))){

            // ユーザID重複チェック
            if(!$userModel->isNotDuplicationUserID(['userID' => $data['userID']])){
                $retStr = CommonMessage::USERIDUSED;
            }

            // ユーザ登録処理を呼び出す
            if(empty($retStr) && $userModel->registModel($data)){

                // セッションにユーザIDおよびユーザ名をセット
                $authModel = new AuthModel;
                $authModel->setSession($data['userID'], $data['userName']);
            
                // ユーザ登録成功画面へ遷移
                header("Location: /registeduser");
                exit;
            }
            else{
                // ユーザIDおよびパスワード未入力メッセージを返す
                $retStr = CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
            }
        }
        else{
            // ユーザIDおよびパスワード未入力メッセージを返す
            $retStr = CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        return $retStr;
    }

    // ユーザ情報取得
    public function getUserInfoController(array $data){

        $userModel = new UserModel();

        // 指定されたユーザIDのユーザ情報を受け取り、返す
        $retRow = $userModel->getUserInfoModel($data);
        return $retRow;
    }

    // ユーザ情報更新
    public function updateUserInfoController(array $data){

        $userModel = new UserModel();

        // ユーザ情報未入力判定
        if(!empty($data['userName']) && !empty($data['userID']) &&!empty($data['isUpdatePassword']) && !empty($data['token'])){

            // パスワード更新を行う場合
            if($data['isUpdatePassword'] === 'updatepassword'){

                if(!empty($data['oldPassword']) && !empty($data['newPassword'])){

                    $authModel = new AuthModel();

                    // 現在のパスワードを照合
                    if($authModel->onlyPasswordCheckModel($data)){
                    
                        // パスワード更新処理を呼び出す
                        if(!$userModel->updatePasswordModel($data)){

                            // 更新失敗メッセージを返す
                            return CommonMessage::UPDATEFAILURE;
                        }
                    }
                    else{
                        // 現在のパスワードが違うメッセージを返す
                        return CommonMessage::OLDPASSWORDNOTMATCHED;
                    }
                }
                else{
                    // 現在のパスワードおよび新しいパスワードが未入力メッセージを返す
                    return CommonMessage::OLDPASSWORDANDNEWPASSWORDNOTENTERD;
                }                
            }

            // パスワード以外のユーザ情報更新処理を呼び出す
            if($userModel->updateUserInfoModel($data)){

                // セッションにユーザ名をセット
                $_SESSION['user_name'] = $data['userName'];
                    
                // 更新成功メッセージを返す
                return CommonMessage::UPDATESUCSESS;
            }
            else{
                // 更新失敗メッセージを返す
                return CommonMessage::UPDATEFAILURE;
            }
        }
        else{            
            // ユーザ名未入力メッセージを返す
            return CommonMessage::USERNAMENOTENTERD;
        }
    }

    // ユーザ情報削除
    public function deleteController(array $data){

        $userModel = new UserModel();

        if(!empty($data['userID']) && !empty($data['token'])){

            // ユーザ削除処理を呼び出す
            if($userModel->deleteModel($data)){                
                header("Location: /deleted");
                exit;
            }
            else{
                header("Location: /deleteConfirm");
                exit;
            }
        }
        else{
            header("Location: /deleteConfirm");
            exit;
        }
    }
}