<?php

require_once __DIR__ . '/../../Service/util.php';

Class RoutesController{

    // 共通
    private function render($title, $viewName){
        $title = htmlspecialchars($title);
        $contentView = __DIR__ . '/../../../resources/views/'.$viewName;
        include __DIR__ . '/../../../resources/views/layouts/layout.php';
        exit;
    }

    // トップページ
    public function routesTop(){   
        $this->forLoginForm();
        $this->render('トップ', 'topPage.php');
    }

    // ユーザ情報登録
    public function routesRegistUser(){
        if(!Util::isLogin()){
            $this->render('ユーザー情報登録', 'userRegistForm.php');
        }
    }

    // ユーザ情報登録完了
    public function routesRegistedUser(){
        $this->forLoginForm();
        $this->render('ユーザー情報登録完了', 'userRegistedPage.php');
    }

    // メニュー
    public function routesMenu(){
        $this->forLoginForm();
        $this->render('メニュー', 'menuPage.php');
    }

    // ユーザ情報確認
    public function routesUserInfo(){
        $this->forLoginForm();
        $this->render('ユーザー情報', 'userInfoPage.php');
    }

    // ユーザ情報更新
    public function routesUpdateUserInfo(){
        $this->forLoginForm();
        $this->render('ユーザー情報更新', 'UpdateUserInfoForm.php');
    }

    // パスワード更新
    public function routesUpdatePassword(){
        $this->forLoginForm();
        $this->render('パスワード更新', 'updatePasswordForm.php');
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
        $this->render('ページが見つかりません', 'errors/404Page.php');
        exit;
    }

    // ログイン
    private function forLoginForm(){
        if(!Util::isLogin()){
            $this->render('ログイン', 'loginForm.php');
            exit;
        }
    }

}

?>