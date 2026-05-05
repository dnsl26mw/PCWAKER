<?php

class Env{

    // 環境変数キー定数
    private const DB_CONNECTION_KEY = 'DB_CONNECTION';
    private const DB_HOST_KEY = 'DB_HOST';
    private const DB_PORT_KEY = 'DB_PORT';
    private const DB_DATABASE_KEY = 'DB_DATABASE';
    private const DB_USER_NAME_KEY = 'DB_USER_NAME';
    private const DB_PASSWORD_KEY = 'DB_PASSWORD';

    // 環境変数定数
    public static string $DB_CONNECTION = '';
    public static string $DB_HOST = '';
    public static int $DB_PORT = 0;
    public static string $DB_DATABASE = '';
    public static string $DB_USER_NAME = '';
    public static string $DB_PASSWORD = '';

    // .envファイルのファイルパス
    private const ENV_PATH = __DIR__ . '/../.env';

    // .envファイルの読み込み
    public static function loadEnv(): void
    {
        // .envファイルを取得
        $envLines = file(self::ENV_PATH, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        for($i = 0; $i < count($envLines); $i++) {

            // .envファイルの現在の行
            $line = $envLines[$i];

            // コメント行は飛ばす
            if(str_starts_with(trim($line), '#')){
                
                continue;
            }

            // .envの1行（KEY=VALUE形式）をキーと値に分割
            [$key, $value] = explode('=', $line, 2);

            // 値の前後のクオートや余分な空白を除去
            $value = trim($value, "\"' ");

            // DB接続方法をセット
            if($key === self::DB_CONNECTION_KEY){

                self::$DB_CONNECTION = $value;
            }
            // DBサーバのホスト名をセット
            else if($key === self::DB_HOST_KEY){

                self::$DB_HOST = $value;
            }
            // DBサーバのポート番号をセット
            else if($key === self::DB_PORT_KEY){

                self::$DB_PORT = (int)$value;
            }
            // DB名をセット
            else if($key === self::DB_DATABASE_KEY){

                self::$DB_DATABASE = $value;
            }
            // DBユーザ名をセット
            else if($key === self::DB_USER_NAME_KEY){

                self::$DB_USER_NAME = $value;
            }
            // DBパスワードをセット
            else if($key === self::DB_PASSWORD_KEY){

                self::$DB_PASSWORD = $value;
            }
        }
    }
}

?>