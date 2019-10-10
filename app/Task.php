<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //状態定義
    const STATUS = [
        1 => ['label' => '未着手'],
        2 => ['label' => '着手中'],
        3 => ['label' => '完了'],
    ];

    public function getStatusLabelAttribute()
    {
        // 状態値 (状態カラムの値を取得)
        $status = $this->attributes['status'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        // STATUS配列から状態値をキーに文字列表現を探して返している
        return self::STATUS[$status]['label'];
    }

    public function getFormattedDueDateAttribute()
    {
        // Carbon ライブラリを使って期限日の値の形式を変更して返却
        return Carbon::createFromFormat('Y-m-d' , $this->attributes['due_date'])->format('Y/m/d');
    }
}
