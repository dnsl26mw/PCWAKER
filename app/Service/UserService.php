<?php

class UserService{

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

}

?>