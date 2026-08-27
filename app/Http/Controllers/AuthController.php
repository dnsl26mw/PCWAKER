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

        return view('login', ['pagetitle' => 'ログイン']);
    }

    // ログイン
    public function login(Request $request) {

        // ログイン済みの場合は現在のページに留まる
        if(Auth::check()) {
            return back();
        }

        // メールアドレス
        $email = $request->input('email');

        // パスワード
        $password = $request->input('password');

        // メールアドレスまたはパスワードが未入力
        if(empty($email) || empty($password)) {

            return back()->withInput()->withErrors(['message' => 'メールアドレスおよびパスワードを入力してください。']);
        }

        $loginData = [
            'email' => $email,
            'password' => $password
        ];

        if(Auth::attempt($loginData)) {

            // ログイン成功時は要求されたページへ遷移
            return redirect()->intended(route('top'));
        }

        return back()->withInput()->withErrors(['message' => 'メールアドレスまたはパスワードが違います。']);
    }

    // ログアウトをGET要求で受け取った場合の処理
    public function getLogout() {
    
        // ログイン済みでない場合はログイン画面へ遷移
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        // 現在のページに留まる
        return back();
    }

    // ログアウト
    public function logout(Request $request) {

        // ログアウト処理
        Auth::logout();

        // セッションを無効化
        $request->session()->invalidate();

        // CSRFトークンを再生成
        $request->session()->regenerateToken();

        // ログイン画面へ遷移
        return redirect()->route('login');
    }
}
