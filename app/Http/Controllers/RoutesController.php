<?php

require_once __DIR__ . '/../../Service/util.php';
require_once __DIR__ . '/../../Http/Controllers/AuthController.php';
require_once __DIR__ . '/../../Http/Controllers/UserController.php';

Class RoutesController{

    // 共通
    private function render($title, $viewName, $data = []){
        $title = htmlspecialchars($title);
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

        // ログイン済みの場合
        if(Util::isLogin()){
            return;
        }

        // POST時
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'userID' => $_POST['userId'],
                'password' => $_POST['userPw'],
                'userName' => $_POST['userName'],
                'token' => $_POST['token']
            ];

            $userController = new UserController();
            $registFailMsg = $userController->registController($data);

            // 登録失敗
            if($registFailMsg !== ''){

                $data = [
                    'userID' => $_data['userID'],
                    'userName' => $_data['userName'],
                    'token' => $_POST['token']
                ];
            }

            // ユーザ登録成功画面へ遷移
            header("Location: /registeduser");
            exit;
        }

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render('ユーザー情報登録', 'userRegistForm.php', $data);
    }

    // ユーザ情報登録完了
    public function routesRegistedUser(){
        $this->forLoginForm();
        $this->render('ユーザー情報登録完了', 'userRegistedPage.php');
    }

    // ユーザ情報確認
    public function routesUserInfo(){
        $this->forLoginForm();
        $userController = new UserController();
        $data = $userController->getUserInfoController(['userID' => $_SESSION['user_id']]);
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
                'userName' => $_POST['userName'],
                'userID' => $_SESSION['user_id'],
                'isUpdatePassword' => $_POST['updatepass'] ?? 'notupdatepassword',
                'oldPassword' => $_POST['oldpass'] ?? '',
                'newPassword' => $_POST['newpass'] ?? '',
                'token' => $_POST['token']
            ];

            $updateFailMsg = $userController->updateUserInfoController($data);

            // 更新失敗
            if($updateFailMsg !== ''){

                $data = [
                    'userInfo' => [
                        'user_id' => $data['userID'],
                        'user_name' => $data['userName']
                    ],
                    'isUpdatePassword' => $data['isUpdatePassword'],
                    'token' => $_POST['token'],
                    'error' => $updateFailMsg
                ];
            }

            // 更新成功
            header("Location: /userinfo");
            exit;
        }

        // 表示用ユーザ情報取得
        $data = $userController->getUserInfoController(['userID' => $_SESSION['user_id']]);

        // CSRFトークンをセット
        $data['token'] = Util::createToken();

        $this->render('ユーザー情報更新', 'UpdateUserInfoForm.php', $data);
    }

    // ユーザ削除
    public function routesDeleteUser(){
        $this->forLoginForm();
        $this->render('ユーザー情報削除', 'userDeleteForm.php');
    }

    // ユーザ削除完了
    public function routesDeletedUser(){
        $this->forLoginForm();
        $this->render('ユーザー情報削除完了', 'deletedPage.php');
    }

    // デバイス一覧
    public function routesDeviceList(){
        $this->forLoginForm();
        $this->render('デバイス一覧', 'deviceListPage.php');
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
                'userID' => $_POST['userId'],
                'password' => $_POST['userPw'],
                'token' => $_POST['token']
            ];

            $authController = new AuthController();

            // ログイン処理の呼び出し
            $loginFailMsg = $authController->loginController($data);

            // ログイン失敗
            if($loginFailMsg !== ''){

                // ログイン失敗メッセージをセット
                $data['loginFailMsg'] = $loginFailMsg;
                header("Location: $url");
                exit;
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

}

?>