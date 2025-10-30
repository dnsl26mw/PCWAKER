<?php
Class Util {
    // 文字列のハッシュ変換を行う
    public static function hashConvert($paramStr){

        // ハッシュ化後に返す文字列
        $retStr = $paramStr;

        // ストレッチング回数
        $streachingCount = 1000000;

        for($i = 0; $i <= $streachingCount; $i++){
            $retStr = hash('sha256', $retStr);
        }
        
        return $retStr;
    }

    // ランダムな文字列を生成する
    public static function retRandomStr(){
        return bin2hex(random_bytes(16));
    }

    // ソルトまたはトークンの生成時の共通処理
    public static function createSaltOrTokenCommon(){
        return self::hashConvert(self::retRandomStr());
    }

    // トークンの生成
    public static function createToken(){
        $token = self::createSaltOrTokenCommon();
        $_SESSION['token'] = $token;
        return $token;
    }

    // トークンの削除
    public static function deleteToken(){
        unset($_SESSION['token']);
    }

    // ソルト付きハッシュ化済みパスワードを取得
    public static function getHashPassword($salt, $password){

        // パスワードをハッシュ化
        $password = self::hashConvert($password);

        // ハッシュ化したパスワードにソルトを付加して再ハッシュ化
        $password = self::hashConvert($salt . $password);

        // ソルト付きハッシュ化済みパスワードを返す
        return $password;
    }

    // 共通メッセージ画面に表示するメッセージをセット
    public static function setCommonMessage($message){
        $_SESSION['message'] = $message;
    }

    // 共通メッセージ画面に表示するメッセージを削除
    public static function unSetCommonMessage($message){
        unset($_SESSION['message']);
    }

    // ログイン済みかどうかを判定する
    public static function isLogin(){
        return isset($_SESSION['user_id']) && isset($_SESSION['user_name']);
    }

    // 特殊文字列のエスケープ処理
    public static function escape($str){
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    // URLのパース
    public static function parseURL(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
?>