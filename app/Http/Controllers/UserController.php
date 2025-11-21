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

            // 登録成功
            if(empty($retStr) && $userModel->registModel($data)){

                // セッションにユーザIDおよびユーザ名をセット
                $authModel = new AuthModel;
                $authModel->setSession($data['userID'], $data['userName']);
            
                // ユーザ登録成功画面へ遷移
                header("Location: /registeduser");
                exit;
            }
            else{
                $retStr = CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
            }
        }
        else{
            $retStr = CommonMessage::USERIDANDPASSWORDANDUSERNAMENOTENTERD;
        }

        return $retStr;
    }

    // ユーザ情報の取得
    public function getUserInfoController(array $data){

        $userModel = new UserModel();

        // 指定されたユーザIDのユーザ情報を受け取り、返す
        $retRow = $userModel->getUserInfoModel($data);
        return $retRow;
    }

    // ユーザ情報更新
    public function updateController(array $data){

        $userModel = new UserModel();

        $retStr = '';

        if(!empty($data['userName']) && !empty($data['userID']) &&!empty($data['isUpdatePassword']) && !empty($data['token'])){

            if($data['isUpdatePassword'] === 'updatepassword'){
                return;
            }

            // ユーザ情報更新処理を呼び出す
            if($userModel->updateModel($data)){

                // セッションにユーザ名をセット
                $_SESSION['user_name'] = $data['userName'];

                $retStr = CommonMessage::UPDATESUCSESS;
            }
            else{
                $retStr = CommonMessage::UPDATEFAILURE;
            }
        }
        else{
            $retStr = CommonMessage::USERNAMENOTENTERD;
        }

        // セッションからトークンを削除
        Util::deleteToken();

        return $retStr;
    }

    // パスワードの更新
    public function updatePasswordController(array $data){

        $userModel = new UserModel();

        $retStr = '';

        if(!empty($data['userID']) && !empty($data['newPassword']) && !empty($data['token'])){

            // パスワード更新処理を呼び出す
            if($userModel->updatePasswordModel($data)){
                $retStr = CommonMessage::UPDATESUCSESS;
            }
        }
        else{
            $retStr = CommonMessage::UPDATEFAILURE;
        }

        // セッションからトークンを削除
        Util::deleteToken();

        return $retStr;
    }

    // ユーザ情報削除
    public function deleteController(array $data){

        $userModel = new UserModel();

        if(!empty($data['userID']) && !empty($data['token'])){

            // ユーザ削除処理を呼び出す
            if($userModel->deleteModel($data)){

                // セッションからトークンを削除
                Util::deleteToken();
                
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