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
        // ログインユーザーのデバイス一覧を取得
        $devices = Device::where('user_id', Auth::id())->orderBy('id', 'asc')->get();

        $data = array();

        $data = [
            'devices' => $devices,
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

        $data = array();

        // いずれかが未入力
        if(empty($device_id) || empty($device_name) || empty($macaddress)) {

            return back()->withInput()->withErrors(['message' => 'デバイスID、デバイス名、MACアドレスを入力してください。']);
        }

        // デバイスIDが既に登録されているか確認
        $existingDevice = Device::where('device_id', $device_id)->first();
        if($existingDevice) {

            return back()->withInput()->withErrors(['message' => 'このデバイスIDは既に登録されています。']);
        }

        // MACアドレスのバリデーション
        if(!preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $macaddress)) {

            return back()->withInput()->withErrors(['message' => 'MACアドレスの形式が正しくありません。正しい形式は「XX:XX:XX:XX:XX:XX」または「XX-XX-XX-XX-XX-XX」です。Xには、0～9、A～F、a～fのいずれかが入ります。']);
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

            return back()->withInput()->with('message', 'デバイス情報登録に失敗しました。');
        }
    }

    // デバイス情報画面を表示
    public function showDeviceInfo($device_id)
    {
        // 指定されたデバイス情報を取得
        $device = Device::where('user_id', Auth::id())->where('device_id', $device_id)->firstOrFail();

        $data = array();

        $data = [
            'device_id' => $device->device_id,
            'name' => $device->name,
            'macaddress' => $device->macaddress
        ];

        return view('deviceinfo', ['data' => $data, 'pagetitle' => 'デバイス情報']);
    }

    // デバイス情報更新画面を表示
    public function showUpdateDeviceInfo($device_id)
    {
        // 指定されたデバイス情報を取得
        $device = Device::where('user_id', Auth::id())->where('device_id', $device_id)->firstOrFail();

        $data = array();

        $data = [
            'device_id' => $device->device_id,
            'name' => $device->name,
            'macaddress' => $device->macaddress
        ];

        return view('deviceinfoupdateform', ['data' => $data, 'pagetitle' => 'デバイス情報更新']);
    }

    // デバイス情報更新
    public function updateDeviceInfo(Request $request, $device_id)
    {
        // 指定されたデバイス情報を取得
        $device = Device::where('user_id', Auth::id())->where('device_id', $device_id)->firstOrFail();

        // デバイス名
        $device_name = $request->input('device_name');

        // MACアドレス
        $macaddress = $request->input('macaddress');

        $data = array();

        // MACアドレスのバリデーション
        if(!preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $macaddress)) {

            $data = [
                'device_id' => $device_id,
                'device_name' => $device_name,
                'macaddress' => $macaddress,
                'message' => 'MACアドレスの形式が正しくありません。正しい形式は「XX:XX:XX:XX:XX:XX」または「XX-XX-XX-XX-XX-XX」です。Xには、0～9、A～F、a～fのいずれかが入ります。'
            ];

            return view('deviceregistform', ['data' => $data, 'pagetitle' => 'デバイス情報登録']);
        }

        // デバイス情報更新処理の呼び出し
        try{
            
            Device::where('user_id', Auth::id())->where('device_id', $device_id)->update([
                'name' => $device_name,
                'macaddress' => $macaddress
            ]);

            // 更新成功時はデバイス情報画面へ遷移
            return redirect()->route('deviceinfo', ['device_id' => $device_id]);
        }
        catch(\Exception $e) {

            $data = [
                'device_id' => $device->device_id,
                'name' => $device->name,
                'macaddress' => $device->macaddress,
                'message' => 'デバイス情報更新に失敗しました。'
            ];

            // 更新失敗時はデバイス情報更新画面へ遷移
            return view('deviceinfoupdateform', ['data' => $data, 'pagetitle' => 'デバイス情報更新']);
        }
    }

    // デバイス情報削除画面を表示
    public function showDeleteDeviceInfo($device_id)
    {
        // 指定されたデバイス情報を取得
        $device = Device::where('user_id', Auth::id())->where('device_id', $device_id)->firstOrFail();

        $data = array();

        $data = [
            'device_id' => $device->device_id,
            'name' => $device->name,
            'macaddress' => $device->macaddress
        ];

        return view('devicedeleteform', ['data' => $data, 'pagetitle' => 'デバイス情報削除']);
    }

    // デバイス情報削除
    public function deleteDeviceInfo(Request $request, $device_id)
    {
        // 指定されたデバイス情報を取得
        $device = Device::where('user_id', Auth::id())->where('device_id', $device_id)->firstOrFail();

        $data = array();

        // デバイス情報削除処理の呼び出し
        try {

            Device::where('user_id', Auth::id())->where('device_id', $device_id)->delete();

            // 削除成功時はデバイス一覧画面へ遷移
            return redirect()->route('devicelist');

        } catch (\Exception $e) {

            $data = [
                'device_id' => $device->device_id,
                'name' => $device->name,
                'macaddress' => $device->macaddress,
                'message' => 'デバイス情報削除に失敗しました。'
            ];

            return view('devicedeleteform', ['data' => $data, 'pagetitle' => 'デバイス情報削除']);
        }
    }

    // マジックパケット送信をGETで要求された場合
    public function getWakeDevices(){

        // 現在のページに留まる
        return redirect()->back();
    }

    // マジックパケット送信
    public function wakeDevices(Request $request){

        // 選択されたデバイスIDを取得
        $deviceIds = $request->input('selectdevices', []);

        $data = array();

        // デバイスIDが指定されていない場合
        if(empty($deviceIds)){

            return redirect()->back()->withInput()->withErrors(['message' => 'デバイスを選択してください。']);
        }

        // デバイス情報を取得
        $devices = Device::where('user_id', Auth::id())->whereIn('device_id', $deviceIds)->get();

        // デバイス情報が取得できなかった場合
        if($devices->isEmpty()){

            return redirect()->back()->withInput()->withErrors(['message' => '指定されたデバイス情報を取得できませんでした。']);
        }

        // マジックパケット送信処理
        foreach($devices as $device){

            try{

                // MACアドレスを取得
                $macaddress = $device->macaddress;

                // ソケット
                $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

                // マジックパケットの作成
                $macaddress = str_replace('-', '', $macaddress);
                $macaddress = str_replace(':', '', $macaddress);
                $macBinary = pack('H12', $macaddress);
                $magicPacket = str_repeat(chr(0xFF), 6) . str_repeat($macBinary, 16);

                // ブロードキャストを有効化
                socket_set_option($socket, SOL_SOCKET, SO_BROADCAST, 1);

                // マジックパケットの送信
                for($i = 0; $i < 3; $i++){

                    socket_sendto($socket, $magicPacket, strlen($magicPacket), 0, '255.255.255.255', 9);
                }
            }
            catch(\Exception $e){

                // 送信失敗時はデバイス一覧画面へ遷移
                return redirect()->back()->withInput()->withErrors(['message' => 'マジックパケットの送信に失敗しました。']);
            }
        }

        // 送信成功時はトップページへ遷移
        return redirect()->route('top');
    }
}
