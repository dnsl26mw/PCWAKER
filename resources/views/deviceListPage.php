<?php
// デバイス一覧画面

// デバイス一覧情報
$deviceListInfo = $data['deviceListInfo'] ?? [];

?>

<table>
    <thead>
        <tr>
            <th>選択</th>
            <th>デバイスID</th>
            <th>デバイス名</th>
            <th>MACアドレス</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($deviceListInfo)): ?>
            <?php foreach ($deviceListInfo as $device): ?>
                <tr>
                    <td><input type="checkbox"></input></td>
                    <td><a href="/deviceinfo"><?= Util::escape($device['device_id']) ?></td>
                    <td><?= Util::escape($device['device_name']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="/registdevice">デバイスの追加はこちら</a>