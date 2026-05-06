<?php

class Util {

    // 文字列のハッシュ変換を行う
    public static function hashConvert($paramStr){

        // ハッシュ関数
        $hashFunction = 'sha256';

        // ストレッチング回数
        $streachingCount = 1000000;

        // ハッシュ化後に返す文字列
        $retStr = $paramStr;

        for($i = 0; $i <= $streachingCount; $i++){
            
            $retStr = hash($hashFunction, $retStr);
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

    // CSRFトークンの生成
    public static function createToken(){

        if(empty($_SESSION[RequestKey::TOKEN])){

            $token = self::createSaltOrTokenCommon();

            $_SESSION[RequestKey::TOKEN] = $token;
        }
    }

    // CSRFトークンの照合
    public static function verificationToken(array $data){

        // CSRFトークン不一致
        if($data[RequestKey::TOKEN] !== $_SESSION[RequestKey::TOKEN]){

            return false;
        }

        // 古いCSRFトークンを削除
        unset($_SESSION[RequestKey::TOKEN]);

        // 新しいCSRFトークンをセット
        $_SESSION[RequestKey::TOKEN] = Util::createToken();

        return true;
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

    // ログイン済みかどうかを判定する
    public static function isLogin(){
        return !empty($_SESSION['user_id']);
    }

    // 特殊文字列のエスケープ処理
    public static function escape($str){
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    // URLのパース
    public static function parseURL(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    // IDバリデーション
    public static function validateID($str){

        // IDの共通フォーマット(記号なし半角英数字で20文字以内)
        $format = '/^([0-9A-Za-z]){1,20}$/';

        // バリデーション結果を返す
        return preg_match($format, $str);
    }

    // 名前バリデーション
    public static function validateName($str){

        // 最大文字数
        $maxCount = 20;

        // 20文字以内かを返す
        return mb_strlen($str) <= $maxCount;
    }
}

?>