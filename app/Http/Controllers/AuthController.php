<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // ログイン画面を表示
    public function showLogin() {

        $data = array();

        $data = [
            'login_id' => '',
            'message' => ''
        ];

        return view('login', ['data' => $data, 'pagetitle' => 'ログイン']);
    }

    // ログイン
    public function login(Request $request) {

        $data = array();

        $data = [
            'login_id' => '',
            'message' => ''
        ];

        $loginId = $request->input('login_id');
        $password = $request->input('password');

        // ログインIDまたはパスワードが未入力
        if(empty($loginId) || empty($password)) {

            $data = [
                'login_id' => $loginId,
                'message' => 'ユーザーIDおよびパスワードを入力してください。'
            ];

            return view('login', ['data' => $data, 'pagetitle' => 'ログイン']);
        }

        $loginData = [
            'login_id' => $loginId,
            'password' => $password
        ];

        if(Auth::attempt($loginData)) {

            // ログイン成功時はトップページへ遷移
            return redirect()->route('top');
        }
            
        $data = [
            'message' => 'ユーザーIDまたはパスワードが違います。',
            'login_id' => $loginId ?? ''
        ];

        return view('login', ['data' => $data, 'pagetitle' => 'ログイン']);
    }

    // ログアウト
    public function logout() {

        // ログアウト処理
        Auth::logout();

        // セッションを無効化
        $request->session()->invalidate();

        // CSRFトークンを再生性
        $request->session()->regenerateToken();

        // ログイン成功時はログイン画面へ遷移
        return redirect()->route('login');
    }
}
