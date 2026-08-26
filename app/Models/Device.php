<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    // タイムスタンプを無効化
    public $timestamps = false;

    // テーブル名を指定
    protected $table = 'devices';

    // Fillable属性を設定
    protected $fillable = [
        'device_id',
        'name',
        'macaddress',
        'user_id'
    ];
}
