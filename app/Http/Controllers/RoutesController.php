<?php

require_once __DIR__ . '/../../Service/util.php';

Class RoutesController{

    // 共通
    private function render($title, $viewName){
        $title = htmlspecialchars($title);
        //$contentView = ;
        include __DIR__ . '/../../resource/views/loginForm.php';;
    }

    // トップページ
    public function routesTop(){
        
        if(Util::isLogin()){
            $this->rendar('トップ', 'topPage');
        }
        else{
            $this->rendar('ログイン', 'loginForm');
        }
    }

}

?>