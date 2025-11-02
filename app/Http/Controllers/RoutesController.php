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

    // ユーザ登録
    public function routesRegistUser(){
        if(!Util::isLogin()){
            $this->render('ユーザー登録', 'registForm.php');
        }
    }

    // ユーザ登録後
    public function routesRegistedUser(){
        $this->forLoginForm();
        $this->render('ユーザ登録完了', 'registedPage.php');
    }

    // メニュー
    public function routesMenu(){
        $this->forLoginForm();
        $this->render('メニュー', 'menuPage.php');
    }

    // ユーザ情報確認・更新
    public function routesUserInfo(){
        $this->forLoginForm();
        $this->render('ユーザー情報', 'userInfoForm.php');
    }

    // パスワード更新
    public function routesUpdatePassword(){
        $this->forLoginForm();
        $this->render('パスワード更新', 'updatePasswordForm.php');
    }

    // ユーザ削除
    public function routesDeleteUser(){
        $this->forLoginForm();
        $this->render('ユーザー削除', 'deleteForm.php');
    }

    // ユーザ削除完了
    public function routesDeletedUser(){
        $this->forLoginForm();
        $this->render('ユーザー削除完了', 'deletedPage.php');
    }

    // 404
    public function notFoundPage(){
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