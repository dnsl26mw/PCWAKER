<?php

require_once __DIR__ . '/../../Service/util.php';
require_once __DIR__ . '/../../Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../Http/Controllers/UserController.php';
require_once __DIR__ . '/../../Http/Controllers/DeviceController.php';

Class RoutesController{

    // 共通
    private function render($title, $viewName, $data = []){
        $title = Util::escape($title);
        $contentView = __DIR__ . '/../../../resources/views/'.$viewName;
        extract($data);
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
        exit;
    }

    // トップページ
    public function routesTop(){
        
        //ログイン判定
        $this->forLoginForm();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'token' => $_POST['token']
            ];

            // ログアウト処理の呼び出し
            $autController = new AuthController();
            $autController->logoutController($data);

            // トップページURLに遷移
            header("Location: /");
            exit;
        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render('トップ', 'topPage.php', $data);
    }

    // ユーザ情報登録
    public function routesRegistUser(){

        // ログイン判定
        if(Util::isLogin()){
            return;
        }

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'user_id' => $_POST['user_id'],
                'password' => $_POST['userPw'],
                'user_name' => $_POST['user_name'],
                'token' => $_POST['token']
            ];

            $userController = new UserController();
            $registFailMsg = $userController->registUserInfoController($data);

            // 登録失敗
            if(!empty($registFailMsg)){

                $data = [
                    'user_id' => $_POST['user_id'],
                    'user_name' => $_POST['user_name'],
                    'token' => $_POST['token'],
                    'registFailMsg' => $registFailMsg
                ];

                $this->render('ユーザー情報登録', 'userRegistForm.php', $data);
            }

            // トップページに遷移
            header("Location: /");
            exit;
        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render('ユーザー情報登録', 'userRegistForm.php', $data);
    }

    // ユーザ情報確認
    public function routesUserInfo(){

        // ログイン判定
        $this->forLoginForm();

        $userController = new UserController();

        // ユーザ情報取得
        $data = $userController->getUserInfoController(['user_id' => $_SESSION['user_id']]);

        $this->render('ユーザー情報', 'userInfoPage.php', $data);
    }

    // ユーザ情報更新
    public function routesUpdateUserInfo(){

        // ログイン判定
        $this->forLoginForm();

        $userController = new UserController();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'user_id' => $_SESSION['user_id'],
                'user_name' => $_POST['user_name'],
                'isUpdatePassword' => $_POST['updatepass'] ?? 'notupdatepassword',
                'oldPassword' => $_POST['oldpass'] ?? '',
                'newPassword' => $_POST['newpass'] ?? '',
                'token' => $_POST['token']
            ];

            $updateFailMsg = $userController->updateUserInfoController($data);

            // 更新失敗
            if(!empty($updateFailMsg)){

                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'user_name' => $data['user_name'],
                    'isUpdatePassword' => $data['isUpdatePassword'],
                    'token' => $_POST['token'],
                    'updateFailMsg' => $updateFailMsg
                ];

                $this->render('ユーザー情報更新', 'UpdateUserInfoForm.php', $data);
            }

            // 更新成功
            header("Location: /userinfo");
            exit;
        }

        // ユーザ情報取得
        $data = $userController->getUserInfoController(['user_id' => $_SESSION['user_id']]);

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render('ユーザー情報更新', 'UpdateUserInfoForm.php', $data);
    }

    // ユーザ情報削除
    public function routesDeleteUser(){

        // ログイン判定
        $this->forLoginForm();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $deviceController = new DeviceController();

            $userController = new UserController();

            $data = [
                'user_id' => $_SESSION['user_id'],
                'token' => $_POST['token']
            ];

            // デバイス情報全削除処理の呼び出し
            if(!$deviceController->deleteDeviceInfoAllController($data)){

                // 失敗した場合、削除確認画面にとどまる
                $this->render('ユーザー情報削除', 'userDeleteForm.php', $data);
            }

            // ユーザ情報削除処理の呼び出し
            if(!$userController->deleteUserInfoController($data)){

                // 失敗した場合、削除確認画面にとどまる
                $this->render('ユーザー情報削除', 'userDeleteForm.php', $data);
            }

            // ログアウト
            $autController = new AuthController();
            $autController->logoutController($data);

            // トップページURLに遷移
            header("Location: /");
            exit;
        }

        // ユーザIDをセット
        $data['user_id'] = $_SESSION['user_id'];

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render('ユーザー情報削除', 'userDeleteForm.php', $data);
    }

    // デバイス情報一覧
    public function routesDeviceList(){

        // ログイン判定
        $this->forLoginForm();

        $deviceController = new DeviceController();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [

            ];

            // マジックパケット送信処理の呼び出し
            $sendFailMsg = $deviceController->sendMagickPacketController($data);

            if(!empty($sendFailMsg)){

                $data = [

                ];

                $this->render('デバイス一覧', 'deviceListPage.php', ['deviceListInfo' => $data]);
            }

            // トップページURLに遷移
            header("Location: /");
        }

        // デバイス情報取得
        $data = $deviceController->getDeviceInfoAllController(['user_id' => $_SESSION['user_id']]);

        $this->render('デバイス一覧', 'deviceListPage.php', ['deviceListInfo' => $data]);
    }

    // デバイス情報確認
    public function routesDeviceInfo(){

        // ログイン判定
        $this->forLoginForm();

        $deviceController = new DeviceController();

        // URLパラメータにデバイスIDがセット済みか確認
        $this->isSetUrlParameter($_GET['device_id']);

        // デバイス情報取得
        $data = $deviceController->getDeviceInfoController([
            'device_id' => $_GET['device_id'],
            'user_id' => $_SESSION['user_id']
        ]);

        // URLパラメータにデバイスIDがセットされており、ログイン中ユーザに紐づく場合
        if(!empty($data)){

            $this->render('デバイス情報', 'deviceInfoPage.php', $data);
        }
        // それ以外
        else{

            // 404ページに遷移
            $this->routesNotFoundPage();
        }
    }

    // デバイス情報登録
    public function routesRegistDevice(){
        
        // ログイン判定
        $this->forLoginForm();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $data = [
                    'device_id' => $_POST['device_id'],
                    'device_name' => $_POST['device_name'],
                    'macaddress' => $_POST['macaddress'],
                    'user_id' => $_SESSION['user_id'],
                    'token' => $_POST['token']
                ];

            $deviceController = new DeviceController();
            $registFailMsg = $deviceController->registDeviceInfoController($data);

            // 登録失敗
            if($registFailMsg !== ''){

                $data = [
                    'device_id' => $_POST['device_id'],
                    'device_name' => $_POST['device_name'],
                    'macaddress' => $_POST['macaddress'],
                    'user_id' => $_SESSION['user_id'],
                    'token' => $_POST['token'],
                    'registFailMsg' => $registFailMsg
                ];

                $this->render('デバイス登録', 'deviceRegistForm.php', $data);
            }

            // デバイス一覧画面に遷移
            header("Location: /devicelist");
            exit;
        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render('デバイス登録', 'deviceRegistForm.php', $data);
    }

    // デバイス情報更新
    public function routesUpdateDeviceInfo(){

        // ログイン判定
        $this->forLoginForm();

        $deviceController = new DeviceController();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'device_id' => $_POST['device_id'],
                'device_name' => $_POST['device_name'],
                'macaddress' => $_POST['macaddress'],
                'user_id' => $_SESSION['user_id'],
                'token' => $_POST['token']
            ];

            $updateFailMsg = $deviceController->updateDeviceInfoController($data);

            // 更新失敗
            if(!empty($updateFailMsg)){

                $data = [
                    'device_id' => $data['device_id'],
                    'device_name' => $data['device_name'],
                    'macaddress' => $data['macaddress'],
                    'user_id' => $_SESSION['user_id'],
                    'token' => $_POST['token'],
                    'updateFailMsg' => $updateFailMsg
                ];

                $this->render('デバイス情報更新', 'updateDeviceInfoForm.php', $data);
            }

            // 更新成功
            header("Location: /deviceinfo?device_id=".urlencode($data['device_id']));
            exit;
        }

        // URLパラメータにデバイスIDがセット済みか確認
        $this->isSetUrlParameter($_GET['device_id']);

        // 表示用デバイス情報取得
        $data = $deviceController->getDeviceInfoController([
            'device_id' => $_GET['device_id'],
            'user_id' => $_SESSION['user_id']
        ]);

        // ログイン中ユーザに紐づくデバイス情報が存在
        if(!empty($data)){

            // CSRFトークンをセット
            $data['token'] = Util::createToken();

            $this->render('デバイス情報更新', 'updateDeviceInfoForm.php', $data);
        }
        // それ以外
        else{

            // 404ページに遷移
            $this->routesNotFoundPage();
        }
    }

    // デバイス情報削除
    public function routesDeleteDeviceInfo(){

        // ログイン判定
        $this->forLoginForm();

        $deviceController = new DeviceController();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'device_id' => $_POST['device_id'],
                'user_id' => $_SESSION['user_id'],
                'token' => $_POST['token']
            ];

            // デバイス情報全削除処理の呼び出し
            if(!$deviceController->deleteDeviceInfoController($data)){

                // 失敗した場合、削除確認画面にとどまる
                $this->render('デバイス情報削除', 'deviceDeleteForm.php', $data);
                exit;
            }

            // デバイス一覧画面に遷移
            header("Location: /devicelist");
            exit;
        }

        // URLパラメータにデバイスIDがセット済みか確認
        $this->isSetUrlParameter($_GET['device_id']);

        // デバイス情報を取得
        $data = $deviceController->getDeviceInfoController([
            'device_id' => $_GET['device_id'],
            'user_id' => $_SESSION['user_id']
        ]);

        // URLパラメータにデバイスIDがセットされており、ログイン中ユーザに紐づく場合
        if(!empty($data)){

            // CSRFトークンをセット
            $data['token'] = Util::createToken();

            $this->render('デバイス情報削除', 'deviceDeleteForm.php', $data);
        }
        // それ以外
        else{

            // 404ページに遷移
            $this->routesNotFoundPage();
        }        
    }

    // DB接続エラー
    public function routesDisConnect(){
        $this->render('接続失敗', 'errors/dbConnectErrorPage.php');
        exit;
    }

    // 404
    public function routesNotFoundPage(){
        http_response_code(404);
        $this->render('ページが見つかりません', 'errors/404Page.php');
        exit;
    }

    // ログイン
    private function forLoginForm(){

        // ログイン判定
        if(Util::isLogin()){
            return;
        }

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'user_id' => $_POST['user_id'],
                'password' => $_POST['userPw'],
                'token' => $_POST['token']
            ];

            $authController = new AuthController();

            // ログイン処理の呼び出し
            $loginFailMsg = $authController->loginController($data);

            // ログイン失敗
            if(!empty($loginFailMsg)){

                // ログイン失敗メッセージをセット
                $data['loginFailMsg'] = $loginFailMsg;

                $this->render('ログイン', 'loginForm.php', $data);
            }

            // リクエストされたURLに遷移
            $url = Util::parseURL();
            header("Location: $url");
            exit;

        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render('ログイン', 'loginForm.php', $data);
    }

    // URLパラメータのセット有無を確認
    private function isSetUrlParameter($data){

        // URLパラメータが未セット
        if(empty($data)){

            // 404ページに遷移
            $this->routesNotFoundPage();
        }
    }
}

?>