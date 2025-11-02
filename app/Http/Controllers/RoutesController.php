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

    // メニュー画面
    public function routesMenu(){
        $this->forLoginForm();
        $this->render('メニュー', 'menuPage.php');
    }

    // 404画面
    public function notFoundPage(){
        $this->render('ページが見つかりません', 'errors/404Page.php');
        exit;
    }

    // ログイン画面
    private function forLoginForm(){
        if(!Util::isLogin()){
            $this->render('ログイン', 'loginForm.php');
            exit;
        }
    }

}

?>