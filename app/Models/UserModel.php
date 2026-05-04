<?php

require_once __DIR__ . '/../../database/Infrastructure/DbConnect.php';
require_once __DIR__ . '/../../database/Tables/UserTable.php';
require_once __DIR__ . '/../Support/SqlGenelator.php';
require_once __DIR__ . '/../Support/Util.php';
require_once __DIR__ . '/../Support/RequestKey.php';

Class UserModel{

    // ユーザID重複チェック
    public function isNotExsistUserID(array $data){

        // ユーザ情報を検索して取得
        $dbRow = $this->getUserInfoModel($data);

        // 取得結果を返す
        return ($dbRow === false);
    }

    // ユーザ情報登録
    public function registUserInfoModel(array $data){

        // DBに接続
        $db = DbConnect::getDbConnect();

        // ソルト用文字列を取得
        $salt = Util::hashConvert(Util::retRandomStr());

        // DB登録用パスワードを取得
        $password = Util::getHashPassword($salt, $data[RequestKey::PASSWORD]);

        // INSERT対象カラム名配列
        $insertColumns = [UserTable::USER_ID_COLUMN, UserTable::SALT_COLUMN, UserTable::PASSWORD_COLUMN, UserTable::USER_NAME_COLUMN];

        // ユーザ情報を登録するSQL文を生成
        $sql = SqlGenelator::InsertQueryGenelator(UserTable::USERTABLE_NAME, $insertColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        try{

            // プレースホルダに値をバインドして実行
            $stmt->execute(array($data[RequestKey::USER_ID], $salt, $password, $data[RequestKey::USER_NAME]));
            return true;
        }
        catch(Exception $e){

            return false;
        }
    }

    // ユーザ情報取得
    public function getUserInfoModel(array $data){

        // DBに接続
        $db = DbConnect::getDbConnect();

        // SELECT対象カラム名配列
        $selectColumns = [UserTable::USER_ID_COLUMN, UserTable::SALT_COLUMN, UserTable::PASSWORD_COLUMN, UserTable::USER_NAME_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [UserTable::USER_ID_COLUMN];

        // ユーザIDを条件にユーザ情報を取得するSQL文を生成
        $sql = SqlGenelator::SelectQueryGenelator($selectColumns, UserTable::USERTABLE_NAME, $whereColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // プレースホルダに値をバインドして実行
        $stmt->execute(array($data[RequestKey::USER_ID]));

        // 指定されたユーザ情報のレコードを取得
        $retRow = $stmt->fetch();

        // ユーザ情報を返す
        return $retRow;
    }

    // パスワード以外のユーザ情報更新
    public function updateUserInfoModel(array $data, $db){

        // UPDATE対象カラム名配列
        $updateColumns = [UserTable::USER_NAME_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [UserTable::USER_ID_COLUMN];

        // ユーザIDを条件にパスワード以外のユーザ情報を更新するSQL文を生成
        $sql = SqlGenelator::UpdateQueryGenelator(UserTable::USERTABLE_NAME, $updateColumns, $whereColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // プレースホルタに値をバインドして実行
        $stmt->execute(array($data[RequestKey::USER_NAME], $data[RequestKey::USER_ID]));

        return true;
    }

    // パスワードの更新
    public function updatePasswordModel(array $data, $db){

        // ソルト用文字列を取得
        $salt = Util::hashConvert(Util::retRandomStr());

        // DB登録用パスワードを取得
        $password = Util::getHashPassword($salt, $data[RequestKey::NEWPASSWORD]);

        // UPDATE対象カラム名配列
        $updateColumns = [UserTable::SALT_COLUMN, UserTable::PASSWORD_COLUMN];

        // WHERE条件カラム名配列
        $whereColumns = [UserTable::USER_ID_COLUMN];

        // ユーザIDを条件にパスワードを更新するSQL文を生成
        $sql = SqlGenelator::UpdateQueryGenelator(UserTable::USERTABLE_NAME, $updateColumns, $whereColumns);

        // SQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // プレースホルダに値をバインドして実行
        $stmt->execute(array($salt, $password, $data[RequestKey::USER_ID]));

        return true;
    }

    // ユーザ情報削除
    public function deleteUserInfoModel(array $data, $db){

        // 指定されたユーザに紐づくデバイス情報およびユーザ情報を全て削除するWHERE条件カラム名配列
        $whereColumns = [DeviceTable::USER_ID_COLUMN];

        // 指定されたユーザに紐づくデバイス情報を全て削除するSQL文を生成
        $sql = SqlGenelator::DeleteQueryGenelator(DeviceTable::DEVICETABLE_NAME, $whereColumns);

        // 指定されたユーザに紐づくデバイス情報を削除するSQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // 指定されたユーザに紐づくデバイス情報を削除するSQL文を実行
        $stmt->execute(array($data[RequestKey::USER_ID]));

        // ユーザ情報を削除するSQL文を生成
        $sql = SqlGenelator::DeleteQueryGenelator(UserTable::USERTABLE_NAME, $whereColumns);

        // ユーザ情報削除のSQL文をプリペアドステートメントとして準備
        $stmt = $db->prepare($sql);

        // ユーザ情報削除のSQL文を実行
        $stmt->execute(array($data[RequestKey::USER_ID]));

        return true;
    }
}