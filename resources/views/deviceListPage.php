<?php
// デバイス一覧画面

// デバイス一覧情報
$deviceListInfo = $data['deviceListInfo'] ?? [];

// CSRFトークン
$token = $data['token'] ?? '';

// 起動失敗メッセージ
$wakeFailMsg = $data['loginFailMsg'] ?? '';

?>

<?php if(!empty($deviceListInfo)): ?>
    <table>
        <thead>
            <tr>
                <th>選択</th>
                <th>デバイスID</th>
                <th>デバイス名</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deviceListInfo as $device): ?>
                <tr>
                    <td><input type="checkbox"></input></td>
                    <td><a href="/deviceinfo"><?= Util::escape($device['device_id']) ?></a></td>
                    <td><a href="/deviceinfo"><?= Util::escape($device['device_name']) ?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <form action="" method="POST">
        <button type="submit" name="wakeBtn">起動</button><br>
    </form>
<?php else: ?>
    <p>登録されているデバイスはありません。</p>
<?php endif; ?>

<a href="/registdevice">デバイス情報の登録はこちら</a>