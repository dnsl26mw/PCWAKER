<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Providers\AppServiceProvider;

class UserController extends Controller
{
    // トップページを表示
    public function showTop() {
        
        return view('top', ['pagetitle' => 'トップ']);
    }

    // ユーザ情報登録画面を表示
    public function showRegistUserInfo(Request $request) {

        // ログイン済みの場合は現在のページに留まる
        if(Auth::check()) {

            return back();
        }

        return view('userinforegistform', ['pagetitle' => 'ユーザー情報登録']);
    }

    // ユーザ情報登録
    public function registUserInfo(Request $request) {

        // ログイン済みの場合は現在のページに留まる
        if(Auth::check()) {

            return back();
        }

        // メールアドレス
        $email = $request->input('email');

        // パスワード
        $password = $request->input('password');

        // ユーザ名
        $userName = $request->input('user_name');

        // バリデーション用の配列
        $data = array();

        // いずれかが未入力
        if(empty($email) || empty($password) || empty($userName)) {

            return back()->withInput()->withErrors(['message' => 'メールアドレス、パスワード、ユーザー名を入力してください。']);
        }

        // メールアドレスのバリデーション
        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {

            return back()->withInput()->withErrors(['message' => 'メールアドレスの形式が正しくありません。']);
        }

        // メールアドレスが重複
        if(User::where('email', $request->input('email'))->exists()) {

            return back()->withInput()->withErrors(['message' => 'このメールアドレスは既に登録されています。']);
        }

        // パスワードのバリデーション
        if(!AppServiceProvider::passwordValidate($request->input('password'))) {

            return back()->withInput()->withErrors(['message' => 'パスワードは8文字以上で入力してください。']);
        }

        // ユーザ情報登録処理の呼び出し
        try {

            User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'user_name' => $userName,
            ]);

            // 登録成功時はログイン画面へ遷移
            return redirect()->route('login');
        }
        catch(\Exception $e) {

            // 登録失敗時はユーザ情報登録画面に留まる
            return back()->withInput()->with('message', 'ユーザー情報登録に失敗しました。');
        }
    }

    // ユーザ情報画面を表示
    public function showUserInfo() {

        // ログイン中のユーザ情報
        $userInfo = User::find(Auth::id());

        $data = array();

        $data = [
            'email' => $userInfo->email,
            'user_name' => $userInfo->name
        ];

        return view('userinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報']);
    }

    // ユーザ情報更新画面を表示
    public function showUpdateUserInfo() {

        // ログイン中のユーザ情報
        $userInfo = User::find(Auth::id());

        $data = array();

        $data = [
            'email' => $userInfo->email,
            'user_name' => $userInfo->name,
            'updatepassword' => 'notupdatepassword',
        ];

        return view('userinfoupdateform', ['data' => $data, 'pagetitle' => 'ユーザー情報更新']);
    }

    // ユーザ情報更新
    public function updateUserInfo(Request $request) {

        // ログイン中のユーザ情報
        $userInfo = User::find(Auth::id());

        // メールアドレス
        $email = $request->input('email');

        // ユーザ名
        $userName = $request->input('user_name');

        // パスワード更新要否
        $updatePassword = $request->input('updatepassword');

        // 現在のパスワード
        $oldPassword = $request->input('oldpassword');

        // 新しいパスワード
        $newPassword = $request->input('newpassword');

        try{

            // メールアドレスを更新する場合
            if($userInfo->email != $email) {

                // メールアドレスのバリデーション
                if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {

                    return back()->withInput()->withErrors(['message' => 'メールアドレスの形式が正しくありません。']);
                }

                // メールアドレスが重複
                if(User::where('email', $request->input('email'))->exists()) {

                    return back()->withInput()->withErrors(['message' => 'このメールアドレスは既に登録されています。']);
                }

                $userInfo->email = $email;
            }

            // パスワードを更新する場合
            if($updatePassword == 'updatepassword') {

                // メールアドレス、ユーザ名、現在のパスワード、新しいパスワードが未入力
                if(empty($email) || empty($userName) || empty($oldPassword) || empty($newPassword)) {

                    return back()->withInput()->withErrors(['message' => 'メールアドレス、ユーザー名、現在のパスワード、新しいパスワードを入力してください。']);
                }

                // 現在のパスワードを照合
                if(!Hash::check($oldPassword, $userInfo->password)) {

                    return back()->withInput()->withErrors(['message' => '現在のパスワードが違います。']);
                }

                // 新しいパスワードのバリデーション
                if(!AppServiceProvider::passwordValidate($newPassword)) {

                    return back()->withInput()->withErrors(['message' => '新しいパスワードは8文字以上で入力してください。']);
                }

                $userInfo->password = Hash::make($newPassword);
            }
            else {

                // メールアドレス、ユーザ名が未入力
                if(empty($email) || empty($userName)) {

                    return back()->withInput()->withErrors(['message' => 'メールアドレス、ユーザー名を入力してください。']);
                }
            }

            $userInfo->name = $userName;

            $userInfo->save();

            // 更新成功時はトップページへ遷移
            return redirect('/top');
        }
        catch(\Exception $e) {

            // 更新失敗時はユーザ情報登録画面に留まる
            return back()->withInput()->with('message', 'ユーザー情報更新に失敗しました。');
        }
    }

    // ユーザ情報削除画面を表示
    public function showDeleteUserInfo() {

        // ログイン中のユーザ情報
        $userInfo = User::find(Auth::id());

        // ログイン中のユーザ名
        $userName = $userInfo->name;

        $data = array();

        $data = [
            'email' => $userInfo->email,
            'user_name' => $userName,
        ];

        return view('userinfodeleteform', ['data' => $data, 'pagetitle' => 'ユーザ情報削除']);
    }

    // ユーザ情報削除
    public function deleteUserInfo(Request $request) {

        // ログイン中のユーザ情報
        $userInfo = User::find(Auth::id());

        // ログイン中のユーザ名
        $userName = $userInfo->name;

        try {

            // ログアウト処理
            Auth::logout();

            // セッションを無効化
            $request->session()->invalidate();

            // CSRFトークンを再生性
            $request->session()->regenerateToken();

            // ユーザ情報削除処理
            $userInfo->delete();

            // ログイン画面に遷移
            return redirect()->route('login');
        }
        catch(\Exception $e) {

            $data = [
                'user_name' => $userName,
                'message' => 'ユーザ情報削除に失敗しました。'
            ];

            // 削除失敗時はユーザ削除確認画面に留まる
            return back()->withInput()->with('message', 'ユーザー情報更新に失敗しました。');
        }
    }
}
