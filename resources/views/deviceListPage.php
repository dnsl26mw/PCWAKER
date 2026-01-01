<?php
// デバイス一覧画面

// デバイス一覧情報
$deviceListInfo = $data ?? [];

?>

<table>
    <tr>
        <th>選択</th>
        <th>デバイスID</th>
        <th>デバイス名</th>
        <th>MACアドレス</th>
    </tr>
    <?php for ($i = 0; $i <= count($deviceListInfo); $i++): ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php endfor; ?>
</table>

<a href="/registdevice">デバイスの追加はこちら</a>