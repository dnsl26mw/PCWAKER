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

        $data = array();

        $data = [
            'email' => '',
            'user_name' => '',
            'message' => ''
        ];

        return view('userregistform', ['data' => $data, 'pagetitle' => 'ユーザー情報登録']);
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

        $data = [
            'email' => $email,
            'user_name' => $userName,
            'message' => ''
        ];

        // いずれかが未入力
        if(empty($request->input('email')) || empty($request->input('password')) || empty($request->input('user_name'))) {

            $data = [
                'email' => $email,
                'user_name' => $userName,
                'message' => 'メールアドレス、パスワード、ユーザー名を入力してください。'
            ];

            return view('userregistform', ['data' => $data, 'pagetitle' => 'ユーザー情報登録']);
        }

        // メールアドレスのバリデーション
        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            
            $data = [
                'email' => $email,
                'user_name' => $userName,
                'message' => 'メールアドレスの形式が正しくありません。'
            ];

            return view('userregistform', ['data' => $data, 'pagetitle' => 'ユーザー情報登録']);
        }

        // メールアドレスが重複
        if(User::where('email', $request->input('email'))->exists()) {

            $data = [
                'email' => $email,
                'user_name' => $userName,
                'message' => 'このメールアドレスは既に登録されています。'
            ];

            return view('userregistform', ['data' => $data, 'pagetitle' => 'ユーザー情報登録']);
        }

        // パスワードのバリデーション
        if(!AppServiceProvider::passwordValidate($request->input('password'))) {
            
            $data = [
                'email' => $email,
                'user_name' => $userName,
                'message' => 'パスワードは8文字以上で入力してください。'
            ];

            return view('userregistform', ['data' => $data, 'pagetitle' => 'ユーザー情報登録']);
        }

        // ユーザ情報登録処理の呼び出し
        try {

            User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'name' => $userName,
            ]);

            // 登録成功時はログイン画面へ遷移
            return redirect()->route('login');
        }
        catch(\Exception $e) {

            $data = [
                'email' => $email,
                'user_name' => $userName,
                'message' => 'ユーザー情報登録に失敗しました。'
            ];

            // 登録失敗時はユーザ情報登録画面へ遷移
            return view('userregistform', ['data' => $data, 'pagetitle' => 'ユーザー情報登録']);
        }
    }

    // ユーザ情報画面を表示
    public function showUserInfo(Request $request, $email) {

        // ログイン中のユーザ情報
        $userInfo = User::where('email', $email)->firstOrFail();

        $data = array();

        $data = [
            'email' => $userInfo->email,
            'user_name' => $userInfo->user_name,
            'message' => ''
        ];

        return view('userinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報']);
    }

    // // ユーザ情報更新画面を表示
    // public function showUpdateUserInfo() {

    //     // ログイン中のユーザ情報
    //     $userInfo = User::find(Auth::id());

    //     // トップへ戻る押下時の戻り先
    //     $backUrl = request()->query('back');

    //     $data = array();

    //     $data = [
    //         'email' => $userInfo->email,
    //         'user_name' => $userInfo->user_name,
    //         'updatepassword' => 'notupdatepassword',
    //         'allow_redirect' => false,
    //         'back_url' => $backUrl,
    //         'message' => ''
    //     ];

    //     return view('updateuserinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報更新']);
    // }

    // // ユーザ情報更新
    // public function updateUserInfo(Request $request) {

    //     // ログイン中のユーザ情報
    //     $userInfo = User::find(Auth::id());

    //     // トップへ戻る押下時の戻り先
    //     $backUrl = request()->input('back');

    //     $data = array();

    //     $data = [
    //         'email' => '',
    //         'user_name' => '',
    //         'updatepassword' => 'notupdatepassword',
    //         'allow_redirect' => false,
    //         'back_url' => $backUrl,
    //         'message' => ''
    //     ];

    //     $email = $request->input('email');
    //     $userName = $request->input('user_name');
    //     $updatePassword = $request->input('updatepassword');
    //     $oldPassword = $request->input('oldpassword');
    //     $newPassword = $request->input('newpassword');

    //     try{

    //         // メールアドレスを更新する場合
    //         if($userInfo->email != $email) {

    //             // メールアドレスのバリデーション
    //             if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    //                 $data = [
    //                     'email' => $email,
    //                     'user_name' => $userName,
    //                     'allow_redirect' => false,
    //                     'back_url' => $backUrl,
    //                     'message' => 'メールアドレスの形式が正しくありません。'
    //                 ];

    //                 // メールアドレスのフォーマット違反時はユーザ情報更新画面に遷移
    //                 return view('updateuserinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報更新']);
    //             }

    //             // メールアドレス重複チェック
    //             if(User::where('email', $email)->where('id', '!=', Auth::id())->exists()) {

    //                 $data = [
    //                     'email' => $email,
    //                     'user_name' => $userName,
    //                     'updatepassword' => $updatePassword,
    //                     'allow_redirect' => false,
    //                     'back_url' => $backUrl,
    //                     'message' => 'このメールアドレスは既に使用されています。'
    //                 ];

    //                 return view('updateuserinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報更新']);
    //             }

    //             $userInfo->email = $email;
    //         }

    //         // パスワードを更新する場合
    //         if($updatePassword == 'updatepassword') {

    //             // メールアドレス、ユーザ名、現在のパスワード、新しいパスワードが未入力
    //             if(empty($email) || empty($userName) || empty($oldPassword) || empty($newPassword)) {

    //                 $data = [
    //                     'email' => $email,
    //                     'user_name' => $userName,
    //                     'updatepassword' => $updatePassword,
    //                     'allow_redirect' => false,
    //                     'back_url' => $backUrl,
    //                     'message' => 'メールアドレス、ユーザー名、現在のパスワード、新しいパスワードを入力してください。'
    //                 ];

    //                 return view('updateuserinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報更新']);
    //             }

    //             // 現在のパスワードを照合
    //             if(!Hash::check($oldPassword, $userInfo->password)) {

    //                 $data = [
    //                     'email' => $email,
    //                     'user_name' => $userName,
    //                     'updatepassword' => $updatePassword,
    //                     'allow_redirect' => false,
    //                     'back_url' => $backUrl,
    //                     'message' => '現在のパスワードが違います。'
    //                 ];

    //                 return view('updateuserinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報更新']);
    //             }

    //             // 新しいパスワードのバリデーション
    //             if(!AppServiceProvider::passwordValidate($newPassword)) {

    //                 $data = [
    //                     'email' => $email,
    //                     'user_name' => $userName,
    //                     'updatepassword' => $updatePassword,
    //                     'allow_redirect' => false,
    //                     'back_url' => $backUrl,
    //                     'message' => '新しいパスワードは8文字以上で入力してください。'
    //                 ];

    //                 // パスワードバリデーション失敗時はユーザ情報更新画面に遷移
    //                 return view('updateuserinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報更新']);
    //             }

    //             $userInfo->password = Hash::make($newPassword);
    //         }
    //         else {

    //             // メールアドレス、ユーザ名が未入力
    //             if(empty($email) || empty($userName)) {

    //                 $data = [
    //                     'email' => $email,
    //                     'user_name' => $userName,
    //                     'updatepassword' => $updatePassword,
    //                     'allow_redirect' => false,
    //                     'back_url' => $backUrl,
    //                     'message' => 'メールアドレス、ユーザー名を入力してください。'
    //                 ];

    //                 return view('updateuserinfo', ['data' => $data, 'pagetitle' => 'ユーザー情報更新']);
    //             }
    //         }

    //         $userInfo->user_name = $userName;

    //         $userInfo->save();

    //         // 更新成功時はトップページへ遷移
    //         return redirect($backUrl);
    //     }
    //     catch(\Exception $e) {

    //         $data = [
    //             'email' => $email,
    //             'user_name' => $userName,
    //             'updatepassword' => $updatePassword,
    //             'allow_redirect' => false,
    //             'message' => 'ユーザー情報更新に失敗しました。'
    //         ];

    //         // 更新失敗時はユーザ登録画面へ遷移
    //         return view('updateuserinfo', ['data' => $data, 'pagetitle' => 'ユーザ情報更新']);
    //     }
    // }

    // // ユーザ情報削除画面を表示
    // public function showDeleteUserInfo() {

    //     // ログイン中のユーザ情報
    //     $userInfo = User::find(Auth::id());

    //     // ログイン中のユーザ名
    //     $userName = $userInfo->user_name;

    //     // トップへ戻る押下時の戻り先
    //     $backUrl = request()->query('back');

    //     $data = array();

    //     $data = [
    //         'user_name' => $userName,
    //         'allow_redirect' => false,
    //         'back_url' => $backUrl,
    //         'message' => ''
    //     ];

    //     return view('deleteuserinfo', ['data' => $data, 'pagetitle' => 'ユーザ情報削除']);
    // }

    // // ユーザ情報削除
    // public function deleteUserInfo(Request $request) {

    //     // ログイン中のユーザ情報
    //     $userInfo = User::find(Auth::id());

    //     // ログイン中のユーザ名
    //     $userName = $userInfo->user_name;

    //     // トップへ戻る押下時の戻り先
    //     $backUrl = request()->input('back');

    //     $data = array();

    //     $data = [
    //         'user_name' => $userName,
    //         'allow_redirect' => false,
    //         'back_url' => $backUrl,
    //         'message' => ''
    //     ];

    //     try {

    //         // ログアウト処理
    //         Auth::logout();

    //         // セッションを無効化
    //         $request->session()->invalidate();

    //         // CSRFトークンを再生性
    //         $request->session()->regenerateToken();

    //         // ユーザ情報削除処理
    //         $userInfo->delete();

    //         // 元ページへ、元ページが存在しなければトップページへ遷移
    //         return redirect($backUrl ?: route('top'));
    //     }
    //     catch(\Exception $e) {

    //         $data = [
    //             'user_name' => $userName,
    //             'allow_redirect' => false,
    //             'back_url' => $backUrl,
    //             'message' => 'ユーザ情報削除に失敗しました。'
    //         ];

    //         // 削除失敗時はユーザ削除確認画面へ遷移
    //         return view('deleteuserconfirm', ['data' => $data, 'pagetitle' => 'ユーザ情報削除']);
    //     }
    // }
}
