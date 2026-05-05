<?php

class RequestKey{

    // ユーザID
    public const USER_ID = 'user_id';

    // パスワード
    public const PASSWORD = 'user_password';

    // ソルト
    public const SALT = 'salt';

    // ユーザ名
    public const USER_NAME = 'user_name';

    // CSRFトークン
    public const TOKEN = 'token';

    // ログアウト用CSRFトークン
    public const LOGOUT_TOKEN = 'logout_token';

    // デバイスID
    public const DEVICE_ID = 'device_id';

    // デバイス名
    public const DEVICE_NAME = 'device_name';

    // MACアドレス
    public const MACADDRESS = 'macaddress';

    // メッセージ
    public const MESSAGE = 'message';

    // パスワード更新有無
    public const ISUPDATEPASSWORD = 'isUpdatePassword';

    // 旧パスワード
    public const OLDPASSWORD = 'oldPassword';

    // 新パスワード
    public const NEWPASSWORD = 'newPassword';

    // 選択したデバイス
    public const SELECTED_DEVICES = 'selectdevices';

    // デバイス一覧情報
    public const DEVICE_LIST_INFO = 'devicelistinfo';

}

?>