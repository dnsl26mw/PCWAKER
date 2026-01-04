<?php
// ユーザ情報確認画面

?>

<table>
    <tr>
        <th>デバイスID</th>
        <td><?php echo Util::escape($deviceInfo['device_id']) ?></td>
    </tr>
    <tr>
        <th>デバイス名</th>
        <td><?php echo Util::escape($deviceInfo['device_name']) ?></td>
    </tr>
    <tr>
        <th>MACアドレス</th>
        <td><?php echo Util::escape($deviceInfo['macaddress']) ?></td>
    </tr>
</table>
<a href="/deviceinfo/update">デバイス情報の更新および削除はこちら</a><br>
<a href="/devicelist">デバイス一覧画面に戻る</a>