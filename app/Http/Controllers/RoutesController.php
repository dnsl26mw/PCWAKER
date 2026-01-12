<?php

require_once __DIR__ . '/../../Service/util.php';
require_once __DIR__ . '/../../Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../Http/Controllers/UserController.php';
require_once __DIR__ . '/../../Http/Controllers/DeviceController.php';

Class RoutesController{

    // 共通
    private function render($pageTitle, $viewName, $data = [], $errorPageFlg = false){

        //ページタイトル
        $pageTitle = Util::escape($pageTitle);

        // エラーページの場合
        if($errorPageFlg){
            $viewName = 'errors/' . $viewName;
        }

        // 表示対象ビューを設定
        $contentView = __DIR__ . '/../../../resources/views/'.$viewName;
        extract($data);

        // テンプレートビューの呼び出し
        include __DIR__ . '/../../../resources/views/layouts/layout.php';

        exit;
    }

    // トップページ
    public function routesTop(){
        
        //ログイン判定
        $this->forLoginForm();

        // ページタイトル
        $pageTitle = 'トップ';

        // ビューのファイル名
        $viewFileName = 'topPage.php';

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'token' => $_POST['token']
            ];

            // ログアウト処理の呼び出し
            $autController = new AuthController();
            $logoutFailMsg = $autController->logoutController($data);
            if(!empty($logoutFailMsg)){

                // ログアウト失敗
                $data = [
                    'token' => $_POST['token'],
                    'logoutFailMsg' => $logoutFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // トップページURLに遷移
            header("Location: /");
            exit;
        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render($pageTitle, $viewFileName, $data);
    }

    // ユーザ情報登録
    public function routesRegistUser(){

        // ログイン判定
        if(Util::isLogin()){
            return;
        }

        // ページタイトル
        $pageTitle = 'ユーザー情報登録';

        // ビューのファイル名
        $viewFileName = 'userRegistForm.php';

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

                $this->render($pageTitle, $viewFileName, $data);
            }

            // トップページに遷移
            header("Location: /");
            exit;
        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render($pageTitle, $viewFileName, $data);
    }

    // ユーザ情報確認
    public function routesUserInfo(){

        // ログイン判定
        $this->forLoginForm();

        // ページタイトル
        $pageTitle = 'ユーザー情報';

        // ビューのファイル名
        $viewFileName = 'userInfoPage.php';

        // ユーザ情報取得
        $userController = new UserController();
        $data = $userController->getUserInfoController(['user_id' => $_SESSION['user_id']]);

        $this->render($pageTitle, 'userInfoPage.php', $data);
    }

    // ユーザ情報更新
    public function routesUpdateUserInfo(){

        // ログイン判定
        $this->forLoginForm();

        // ページタイトル
        $pageTitle = 'ユーザー情報更新';

        // ビューのファイル名
        $viewFileName = 'updateUserInfoForm.php';

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

            // ユーザ情報更新処理の呼び出し
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

                $this->render($pageTitle, $viewFileName, $data);
            }

            // 更新成功
            header("Location: /userinfo");
            exit;
        }

        // ユーザ情報取得
        $data = $userController->getUserInfoController(['user_id' => $_SESSION['user_id']]);

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render($pageTitle, $viewFileName, $data);
    }

    // ユーザ情報削除
    public function routesDeleteUser(){

        // ログイン判定
        $this->forLoginForm();

        // ページタイトル
        $pageTitle = 'ユーザー情報削除';

        // ビューのファイル名
        $viewFileName = 'userDeleteForm.php';

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'user_id' => $_SESSION['user_id'],
                'token' => $_POST['token']
            ];

            // デバイス情報全削除処理の呼び出し
            $deviceController = new DeviceController();
            $deleteFailMsg = $deviceController->deleteDeviceInfoAllController($data);
            if(!empty($deleteFailMsg)){

                // 削除失敗
                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'token' => $_POST['token'],
                    'deleteFailMsg' => $deleteFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // ユーザ情報削除処理の呼び出し
            $userController = new UserController();
            $deleteFailMsg = $userController->deleteUserInfoController($data);
            if(!empty($deleteFailMsg)){

                // 削除失敗
                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'token' => $_POST['token'],
                    'deleteFailMsg' => $deleteFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // ログアウト処理の呼び出し
            $autController = new AuthController();
            $logoutFailMsg = $autController->logoutController($data);
            if(!empty($logoutFailMsg)){

                // ログアウト失敗
                $data = [
                    'token' => $_POST['token'],
                    'deleteFailMsg' => $logoutFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // トップページURLに遷移
            header("Location: /");
            exit;
        }

        // ユーザIDおよびCSRFトークンをセット
        $data = [
            'user_id' => $_SESSION['user_id'],
            'token' => Util::createToken()
        ];

        $this->render($pageTitle, $viewFileName, $data);
    }

    // デバイス情報一覧
    public function routesDeviceList(){

        // ログイン判定
        $this->forLoginForm();

        // ページタイトル
        $pageTitle = 'デバイス情報一覧';

        // ビューのファイル名
        $viewFileName = 'deviceListPage.php';

        $deviceController = new DeviceController();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'selectdevices' => $_POST['selectdevices'],
                'user_id' => $_SESSION['user_id'],
                'token' => $_POST['token']     
            ];

            // マジックパケット送信処理の呼び出し
            $magickPacketSendFailmsg = $deviceController->sendMagickPacketController($data);

            // 送信失敗
            if(!empty($magickPacketSendFailmsg)){

                // デバイス一覧情報情報取得
                $deviceListInfo = $deviceController->getDeviceInfoAllController(['user_id' => $_SESSION['user_id']]);

                $this->render($pageTitle, 
                    $viewFileName, [
                        'deviceListInfo' => $deviceListInfo, 
                        'selectdevices' => $_POST['selectdevices'],
                        'magickpacketsendfailmsg' => $magickPacketSendFailmsg, 
                        'token' => $_POST['token']
                    ]
                );
            }

            // トップページURLに遷移
            header("Location: /");
        }

        // デバイス一覧情報情報取得
        $deviceListInfo = $deviceController->getDeviceInfoAllController(['user_id' => $_SESSION['user_id']]);

        $this->render($pageTitle, 
                $viewFileName, [
                'deviceListInfo' => $deviceListInfo, 
                'token' => Util::createToken(), 
                'selectDeviceIds' => []
            ]
        );
    }

    // デバイス情報確認
    public function routesDeviceInfo(){

        // ログイン判定
        $this->forLoginForm();

        // ページタイトル
        $pageTitle = 'デバイス情報';

        // ビューのファイル名
        $viewFileName = 'deviceInfoPage.php';

        $deviceController = new DeviceController();

        // URLパラメータが未セットの場合は404ページに遷移
        $this->isSetUrlParameter($_GET['device_id']);

        // デバイス情報取得
        $data = $deviceController->getDeviceInfoController([
            'device_id' => $_GET['device_id'],
            'user_id' => $_SESSION['user_id']
        ]);

        // URLパラメータにデバイスIDがセットされており、ログイン中ユーザに紐づく場合
        if(!empty($data)){

            $this->render($pageTitle, $viewFileName, $data);
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

        // ページタイトル
        $pageTitle = 'デバイス情報登録';

        // ビューのファイル名
        $viewFileName = 'deviceRegistForm.php';

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

                $data = [
                    'device_id' => $_POST['device_id'],
                    'device_name' => $_POST['device_name'],
                    'macaddress' => $_POST['macaddress'],
                    'user_id' => $_SESSION['user_id'],
                    'token' => $_POST['token']
                ];

            // デバイス情報登録処理の呼び出し
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

                $this->render($pageTitle, $viewFileName, $data);
            }

            // デバイス一覧画面に遷移
            header("Location: /devicelist");
            exit;
        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render($pageTitle, $viewFileName, $data);
    }

    // デバイス情報更新
    public function routesUpdateDeviceInfo(){

        // ログイン判定
        $this->forLoginForm();

        // ページタイトル
        $pageTitle = 'デバイス情報更新';

        // ビューのファイル名
        $viewFileName = 'updateDeviceInfoForm.php';

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

            // デバイス情報更新処理の呼び出し
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

                $this->render($pageTitle, $viewFileName, $data);
            }

            // 更新成功
            header("Location: /deviceinfo?device_id=".urlencode($data['device_id']));
            exit;
        }

        // URLパラメータが未セットの場合は404ページに遷移
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

            $this->render($pageTitle, $viewFileName, $data);
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

        // ページタイトル
        $pageTitle = 'デバイス情報削除';

        // ビューのファイル名
        $viewFileName = 'deviceDeleteForm.php';

        $deviceController = new DeviceController();

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'device_id' => $_POST['device_id'],
                'user_id' => $_SESSION['user_id'],
                'token' => $_POST['token']
            ];

            // デバイス情報全削除処理の呼び出し
            $deleteFailMsg = $deviceController->deleteDeviceInfoController($data);
            if(!empty($deleteFailMsg)){

                // 削除失敗
                $data = [
                    'device_id' => $_POST['device_id'],
                    'user_id' => $_SESSION['user_id'],
                    'token' => $_POST['token'],
                    'deleteFailMsg' => $deleteFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // デバイス一覧画面に遷移
            header("Location: /devicelist");
            exit;
        }

        // URLパラメータが未セットの場合は404ページに遷移
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

            $this->render($pageTitle, $viewFileName, $data);
        }
        // それ以外
        else{

            // 404ページに遷移
            $this->routesNotFoundPage();
        }        
    }

    // DB接続エラー
    public function routesDisConnect(){

        // ページタイトル
        $pageTitle = '接続失敗';

        // ビューのファイル名
        $viewFileName = 'dbConnectErrorPage.php';

        http_response_code(404);
        $this->render($pageTitle, $viewFileName, [], true);
        exit;
    }

    // 404
    public function routesNotFoundPage(){

        // ページタイトル
        $pageTitle = 'ページが見つかりません';

        // ビューのファイル名
        $viewFileName = '404Page.php';

        http_response_code(404);
        $this->render($pageTitle, $viewFileName, [], true);
        exit;
    }

    // ログイン
    private function forLoginForm(){

        // ログイン判定
        if(Util::isLogin()){
            return;
        }

        // ページタイトル
        $pageTitle = 'ログイン';

        // ビューのファイル名
        $viewFileName = 'loginForm.php';

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'user_id' => $_POST['user_id'],
                'password' => $_POST['userPw'],
                'token' => $_POST['token']
            ];

            // ログイン処理の呼び出し
            $authController = new AuthController();
            $loginFailMsg = $authController->loginController($data);
            if(!empty($loginFailMsg)){

                // ログイン失敗
                $data['loginFailMsg'] = $loginFailMsg;

                $this->render($pageTitle, $viewFileName, $data);
            }

            // リクエストされたURLに遷移
            $url = Util::parseURL();
            header("Location: $url");
            exit;

        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render($pageTitle, $viewFileName, $data);
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