<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    // デバイス一覧画面を表示
    public function showDeviceList()
    {
        $devices = Device::where('user_id', Auth::id())->orderBy('id', 'asc')->get();

        $data = array();

        // デバイスが登録されていない場合
        if($devices->isEmpty()) {

            $data = [
                'devices' => $devices,
                'message' => 'デバイスが登録されていません。'
            ];

            return view('devicelist', ['data' => $data, 'pagetitle' => 'デバイス一覧']);
        }

        $data = [
            'devices' => $devices,
            'message' => ''
        ];

        return view('devicelist', ['data' => $data, 'pagetitle' => 'デバイス一覧']);
    }

    // デバイス情報登録画面を表示
    public function showRegistDeviceInfo()
    {
        $data = array();

        $data = [
            'device_id' => '',
            'device_name' => '',
            'macaddress' => '',
            'message' => ''
        ];

        return view('deviceregistform', ['data' => $data, 'pagetitle' => 'デバイス情報登録']);
    }

    // デバイス情報登録
    public function registDeviceInfo(Request $request)
    {
        // デバイスID
        $device_id = $request->input('device_id');

        // デバイス名
        $device_name = $request->input('device_name');

        // MACアドレス
        $macaddress = $request->input('macaddress');

        // いずれかが未入力
        if(empty($device_id) || empty($device_name) || empty($macaddress)) {

            $data = [
                'device_id' => $device_id,
                'device_name' => $device_name,
                'macaddress' => $macaddress,
                'message' => 'デバイスID、デバイス名、MACアドレスを入力してください。'
            ];

            return view('deviceregistform', ['data' => $data, 'pagetitle' => 'デバイス情報登録']);
        }

        // デバイスIDが既に登録されているか確認
        $existingDevice = Device::where('device_id', $device_id)->first();
        if($existingDevice) {

            $data = [
                'device_id' => $device_id,
                'device_name' => $device_name,
                'macaddress' => $macaddress,
                'message' => 'このデバイスIDは既に登録されています。'
            ];

            return view('deviceregistform', ['data' => $data, 'pagetitle' => 'デバイス情報登録']);
        }

        // MACアドレスのバリデーション
        if(!preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $macaddress)) {

            $data = [
                'device_id' => $device_id,
                'device_name' => $device_name,
                'macaddress' => $macaddress,
                'message' => 'MACアドレスの形式が正しくありません。'
            ];

            return view('deviceregistform', ['data' => $data, 'pagetitle' => 'デバイス情報登録']);
        }

        // デバイス情報登録処理の呼び出し
        try {

            Device::create([
                'user_id' => Auth::id(),
                'device_id' => $device_id,
                'name' => $device_name,
                'macaddress' => $macaddress
            ]);

            // 登録成功時はデバイス一覧画面へ遷移
            return redirect()->route('devicelist');
        }
        catch(\Exception $e) {

            $data = [
                'device_id' => $device_id,
                'device_name' => $device_name,
                'macaddress' => $macaddress,
                'message' => 'デバイス情報登録に失敗しました。'
            ];

            // 登録失敗時はデバイス情報登録画面へ遷移
            return view('deviceregistform', ['data' => $data, 'pagetitle' => 'デバイス情報登録']);
        }
    }

    // デバイス情報画面を表示
    public function showDeviceInfo($device_id)
    {
        $device = Device::where('user_id', Auth::id())->where('device_id', $device_id)->firstOrFail();

        $data = array();

        $data = [
            'device_id' => $device->device_id,
            'name' => $device->name,
            'macaddress' => $device->macaddress
        ];

        return view('deviceinfo', ['data' => $data, 'pagetitle' => 'デバイス情報']);
    }
}
