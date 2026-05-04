<?php

require_once __DIR__ . '/../../app/Support/Util.php';

class DeviceTable {

    // テーブル名
    public const DEVICETABLE_NAME = 'devicetable';

    // カラム名定数
    public const DEVICE_ID_COLUMN = 'device_id';
    public const DEVICE_NAME_COLUMN = 'device_name';
    public const MACADDRESS_COLUMN = 'macaddress';
    public const USER_ID_COLUMN = 'user_id';
}
?>