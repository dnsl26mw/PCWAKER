<?php

require_once __DIR__ . '/../../app/Support/Util.php';

class UserTable {

    // テーブル名
    public const USERTABLE_NAME = 'usertable';

    // カラム名定数
    public const USER_ID_COLUMN = 'user_id';
    public const SALT_COLUMN = 'salt';
    public const PASSWORD_COLUMN = 'user_password';
    public const USER_NAME_COLUMN = 'user_name';
}
?>