<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    // ログイン画面を表示
    public function showLogin() {

        // ログイン済みの場合は現在のページに留まる
        if(Auth::check()) {
            return back();
        }

        $data = array();

        $data = [
            'email' => '',
            'message' => ''
        ];

        return view('login', ['data' => $data, 'pagetitle' => 'ログイン']);
    }

    // ログイン
    public function login(Request $request) {

        // ログイン済みの場合は現在のページに留まる
        if(Auth::check()) {
            return back();
        }

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

            // ログイン成功時は要求されたページへ遷移
            return redirect()->intended(route('top'));
        }
            
        $data = [
            'message' => 'メールアドレスまたはパスワードが違います。',
            'email' => $email ?? ''
        ];

        return view('login', ['data' => $data, 'pagetitle' => 'ログイン']);
    }

    // ログアウト
    public function logout(Request $request) {

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
