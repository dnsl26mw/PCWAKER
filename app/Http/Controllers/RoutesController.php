<?php

require_once __DIR__ . '/../../Service/util.php';

Class RoutesController{

    // 共通
    private function render($title, $viewName){
        $title = htmlspecialchars($title);
        $contentView = '/../../resource/views/'.$viewName;
        include __DIR__ . '/../../resource/views/layouts/layout.php';
    }

    // トップページ
    public function routesTop(){
        
        if(Util::isLogin()){
            $this->rendar('トップ', 'topPage.php');
        }
        else{
            $this->forLoginForm();
        }
    }

    // トップページ
    public function routesMenu(){
        
        if(Util::isLogin()){
            $this->rendar('トップ', 'topPage.php');
        }
        else{
            $this->rendar('ログイン', 'loginForm.php');
        }
    }

    // ログイン画面
    private function forLoginForm(){
        $this->rendar('ログイン', 'loginForm.php');
    }

}

?>