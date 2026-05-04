<?php

class CommonMessage {

    public const USERIDANDPASSWORDNOTENTERD = 'ユーザーIDおよびパスワードを入力してください。'; 

    public const USERIDORPASSWORDUNMATCHED = 'ユーザーIDまたはパスワードが違います。';

    public const PASSWORDCOUNTUNDEROROVER = 'パスワードは8文字以上で入力してください。';

    public const OLDPASSWORDANDNEWPASSWORDNOTENTERD = '現在のパスワードおよび新しいパスワードを入力してください。';
    
    public const OLDPASSWORDNOTMATCHED = '現在のパスワードが違います。';

    public const USERIDANDPASSWORDANDUSERNAMENOTENTERD = 'ユーザーID、パスワード、ユーザー名を入力してください。';

    public const USERIDNOTHALFSIZENUMBER = 'ユーザーIDは記号無しの半角英数字で、20文字以内で入力してください。';

    public const USERNAMENOTENTERD = 'ユーザー名を入力してください。';

    public const USERNAMECOUNTOVER = 'ユーザー名は20文字以内で入力してください。';

    public const LOGOUTFAILURE = 'ログアウトに失敗しました。';

    public const UPDATEFAILURE = '更新に失敗しました。';

    public const REGISTFAILURE = '登録に失敗しました。';

    public const USERIDUSED = 'このユーザーIDは既に使われています。';

    public const DELETEFAILURE = '削除に失敗しました。';

    public const DEVICEIDANDDEVICENAMEANDMACADDRESSNOTENTERD = 'デバイスID、デバイス名、MACアドレスを入力してください。';

    public const DEVICEIDNOTHALFSIZENUMBER = 'デバイスIDは記号無しの半角英数字で、20文字以内で入力してください。';

    public const DEVICEUSED = 'このデバイスIDは既に使われています。';

    public const DEVICENAMEANDMACADDRESSNOTENTERD = 'デバイス名、MACアドレスを入力してください。';

    public const DEVICENAMECOUNTOVER= 'デバイス名は20文字以内で入力してください。';

    public const MACADDRESSFORMATVIOLATION = 'MACアドレスは次の形式で入力してください。"XX-XX-XX-XX-XX-XX"(XはA～F、a～f、0～9のいずれかの半角英数字)';

    public const DEVICENOTSELECTED = 'デバイスを選択してください。';

    public const SENDMAGICKPACKETFAILURE = 'マジックパケットの送信に失敗しました。';

    public const OPERATIONTIMEOUT = '操作の有効期限が切れました。再度入力してください。';
}

?>