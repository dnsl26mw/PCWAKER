<?php

require_once __DIR__ . '/../../Support/Util.php';
require_once __DIR__ . '/../../Support/RequestKey.php';
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
                RequestKey::TOKEN => $_POST[RequestKey::TOKEN]
            ];

            // ログアウト処理の呼び出し
            $autController = new AuthController();
            $logoutFailMsg = $autController->logoutController($data);
            if(!empty($logoutFailMsg)){

                // ログアウト失敗
                $data = [
                    RequestKey::TOKEN => Util::createToken(),
                    RequestKey::MESSAGE => $logoutFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // トップページURLに遷移
            header("Location: /");
            exit;
        }

        // CSRFトークンをセット
        $data[RequestKey::TOKEN] = Util::createToken();

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
                RequestKey::USER_ID => $_POST[RequestKey::USER_ID],
                RequestKey::PASSWORD => $_POST[RequestKey::PASSWORD],
                RequestKey::USER_NAME => $_POST[RequestKey::USER_NAME],
                RequestKey::TOKEN => $_POST[RequestKey::TOKEN]
            ];

            $userController = new UserController();
            $registFailMsg = $userController->registUserInfoController($data);

            // 登録失敗
            if(!empty($registFailMsg)){

                $data = [
                    RequestKey::USER_ID => $_POST[RequestKey::USER_ID],
                    RequestKey::USER_NAME => $_POST[RequestKey::USER_NAME],
                    RequestKey::TOKEN => Util::createToken(),
                    RequestKey::MESSAGE => $registFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // トップページに遷移
            header("Location: /");
            exit;
        }

        // CSRFトークンをセット
        $data[RequestKey::TOKEN] = Util::createToken();

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
        $data = $userController->getUserInfoController([RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID]]);

        $this->render($pageTitle, $viewFileName, $data);
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
                RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                RequestKey::USER_NAME => $_POST[RequestKey::USER_NAME],
                RequestKey::ISUPDATEPASSWORD => $_POST['updatepass'] ?? 'notupdatepassword',
                RequestKey::OLDPASSWORD => $_POST[RequestKey::OLDPASSWORD ] ?? '',
                RequestKey::NEWPASSWORD => $_POST[RequestKey::NEWPASSWORD] ?? '',
                RequestKey::TOKEN => $_POST[RequestKey::TOKEN]
            ];

            // ユーザ情報更新処理の呼び出し
            $updateFailMsg = $userController->updateUserInfoController($data);

            // 更新失敗
            if(!empty($updateFailMsg)){

                $data = [
                    RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                    RequestKey::USER_NAME => $data[RequestKey::USER_NAME],
                    RequestKey::ISUPDATEPASSWORD => $data[RequestKey::ISUPDATEPASSWORD],
                    RequestKey::TOKEN => Util::createToken(),
                    RequestKey::MESSAGE => $updateFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // 更新成功
            header("Location: /userinfo");
            exit;
        }

        // ユーザ情報取得
        $data = $userController->getUserInfoController([RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID]]);

        // CSRFトークンをセット
        $data[RequestKey::TOKEN] = Util::createToken();

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
                RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                RequestKey::TOKEN => $_POST[RequestKey::TOKEN]
            ];

            // ユーザ情報削除処理の呼び出し
            $userController = new UserController();
            $deleteFailMsg = $userController->deleteUserInfoController($data);
            if(!empty($deleteFailMsg)){

                // 削除失敗
                $data = [
                    RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                    RequestKey::TOKEN => Util::createToken(),
                    RequestKey::MESSAGE => $deleteFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // ログアウト処理の呼び出し
            $autController = new AuthController();
            $logoutFailMsg = $autController->logoutController($data);
            if(!empty($logoutFailMsg)){

                // ログアウト失敗
                $data = [
                    RequestKey::TOKEN => Util::createToken(),
                    RequestKey::MESSAGE => $logoutFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // トップページURLに遷移
            header("Location: /");
            exit;
        }

        // ユーザIDおよびCSRFトークンをセット
        $data = [
            RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
            RequestKey::TOKEN => Util::createToken()
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
                RequestKey::SELECTED_DEVICES => $_POST[RequestKey::SELECTED_DEVICES],
                RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                RequestKey::TOKEN => $_POST[RequestKey::TOKEN]     
            ];

            // マジックパケット送信処理の呼び出し
            $magickPacketSendFailmsg = $deviceController->sendMagickPacketController($data);

            // 送信失敗
            if(!empty($magickPacketSendFailmsg)){

                // デバイス一覧情報情報取得
                $deviceListInfo = $deviceController->getDeviceListInfoController([RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID]]);

                $this->render($pageTitle, 
                    $viewFileName, [
                        RequestKey::DEVICE_LIST_INFO => $deviceListInfo, 
                        RequestKey::SELECTED_DEVICES=> $_POST[RequestKey::SELECTED_DEVICES],
                        RequestKey::MESSAGE => $magickPacketSendFailmsg, 
                        RequestKey::TOKEN => Util::createToken()
                    ]
                );
            }

            // トップページURLに遷移
            header("Location: /");
        }

        // デバイス一覧情報情報取得
        $deviceListInfo = $deviceController->getDeviceListInfoController([RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID]]);

        $this->render($pageTitle, 
                $viewFileName, [
                RequestKey::DEVICE_LIST_INFO => $deviceListInfo, 
                RequestKey::TOKEN => Util::createToken(), 
                RequestKey::SELECTED_DEVICES => []
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
            RequestKey::DEVICE_ID => $_GET[RequestKey::DEVICE_ID],
            RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID]
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
                    RequestKey::DEVICE_ID => $_POST[RequestKey::DEVICE_ID],
                    RequestKey::DEVICE_NAME => $_POST[RequestKey::DEVICE_NAME],
                    RequestKey::MACADDRESS => $_POST[RequestKey::MACADDRESS],
                    RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                    RequestKey::TOKEN => $_POST[RequestKey::TOKEN]
                ];

            // デバイス情報登録処理の呼び出し
            $deviceController = new DeviceController();
            $registFailMsg = $deviceController->registDeviceInfoController($data);

            // 登録失敗
            if($registFailMsg !== ''){

                $data = [
                    RequestKey::DEVICE_ID => $_POST[RequestKey::DEVICE_ID],
                    RequestKey::DEVICE_NAME => $_POST[RequestKey::DEVICE_NAME],
                    RequestKey::MACADDRESS => $_POST[RequestKey::MACADDRESS],
                    RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                    RequestKey::TOKEN => Util::createToken(),
                    RequestKey::MESSAGE => $registFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // デバイス一覧画面に遷移
            header("Location: /devicelist");
            exit;
        }

        // CSRFトークンをセット
        $data[RequestKey::TOKEN] = Util::createToken();

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
                RequestKey::DEVICE_ID => $_POST[RequestKey::DEVICE_ID],
                RequestKey::DEVICE_NAME => $_POST[RequestKey::DEVICE_NAME],
                RequestKey::MACADDRESS => $_POST[RequestKey::MACADDRESS],
                RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                RequestKey::TOKEN => $_POST[RequestKey::TOKEN]
            ];

            // デバイス情報更新処理の呼び出し
            $updateFailMsg = $deviceController->updateDeviceInfoController($data);

            // 更新失敗
            if(!empty($updateFailMsg)){

                $data = [
                    RequestKey::DEVICE_ID => $data[RequestKey::DEVICE_ID],
                    RequestKey::DEVICE_NAME => $data[RequestKey::DEVICE_NAME],
                    RequestKey::MACADDRESS => $data[RequestKey::MACADDRESS],
                    RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                    RequestKey::TOKEN => Util::createToken(),
                    RequestKey::MESSAGE => $updateFailMsg
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // 更新成功
            header("Location: /deviceinfo?device_id=".urlencode($data['device_id']));
            exit;
        }

        // URLパラメータが未セットの場合は404ページに遷移
        $this->isSetUrlParameter($_GET[RequestKey::DEVICE_ID]);

        // 表示用デバイス情報取得
        $data = $deviceController->getDeviceInfoController([
            RequestKey::DEVICE_ID => $_GET[RequestKey::DEVICE_ID],
            RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID]
        ]);

        // ログイン中ユーザに紐づくデバイス情報が存在
        if(!empty($data)){

            // CSRFトークンをセット
            $data[RequestKey::TOKEN] = Util::createToken();

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
                RequestKey::DEVICE_ID => $_POST[RequestKey::DEVICE_ID],
                RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                RequestKey::TOKEN => $_POST[RequestKey::TOKEN]
            ];

            // デバイス情報全削除処理の呼び出し
            $deleteFailMsg = $deviceController->deleteDeviceInfoController($data);
            if(!empty($deleteFailMsg)){

                // 削除失敗
                $data = [
                    RequestKey::DEVICE_ID => $_POST[RequestKey::DEVICE_ID],
                    RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID],
                    RequestKey::TOKEN => Util::createToken(),
                    RequestKey::MESSAGE => $deleteFailMsg
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
            RequestKey::DEVICE_ID => $_GET[RequestKey::DEVICE_ID],
            RequestKey::USER_ID => $_SESSION[RequestKey::USER_ID]
        ]);

        // URLパラメータにデバイスIDがセットされており、ログイン中ユーザに紐づく場合
        if(!empty($data)){

            // CSRFトークンをセット
            $data[RequestKey::TOKEN] = Util::createToken();

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

        http_response_code(500);
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
                RequestKey::USER_ID => $_POST[RequestKey::USER_ID],
                RequestKey::PASSWORD => $_POST[RequestKey::PASSWORD],
                RequestKey::TOKEN => $_POST[RequestKey::TOKEN]
            ];

            // ログイン処理の呼び出し
            $authController = new AuthController();
            $loginFailMsg = $authController->loginController($data);
            if(!empty($loginFailMsg)){

                // ログイン失敗
                $data = [
                    RequestKey::MESSAGE => $loginFailMsg,
                    RequestKey::USER_ID => $_POST[RequestKey::USER_ID],
                    RequestKey::TOKEN => Util::createToken()
                ];

                $this->render($pageTitle, $viewFileName, $data);
            }

            // リクエストされたURLに遷移
            $url = Util::parseURL();
            header("Location: $url");
            exit;

        }

        // CSRFトークンをセット
        $data[RequestKey::TOKEN] = Util::createToken();

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