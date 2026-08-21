<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // ログイン画面を表示
    public function showLogin() {

        $data = array();

        $data = [
            'email' => '',
            'message' => ''
        ];

        return view('login', ['data' => $data, 'pagetitle' => 'ログイン']);
    }

    // ログイン
    public function login(Request $request) {

        $data = array();

        $data = [
            'email' => '',
            'message' => ''
        ];

        $email = $request->input('email');
        $password = $request->input('password');

        // メールアドレスまたはパスワードが未入力
        if(empty($email) || empty($password)) {

            $data = [
                'email' => $email,
                'message' => 'メールアドレスおよびパスワードを入力してください。'
            ];

            return view('login', ['data' => $data, 'pagetitle' => 'ログイン']);
        }

        $loginData = [
            'email' => $email,
            'password' => $password
        ];

        if(Auth::attempt($loginData)) {

            // ログイン成功時はトップページへ遷移
            return redirect()->route('top');
        }
            
        $data = [
            'message' => 'メールアドレスまたはパスワードが違います。',
            'email' => $email ?? ''
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
