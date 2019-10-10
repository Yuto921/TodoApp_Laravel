<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //このモデルクラスがどのテーブルに対応しているかは、
    //クラス名から自動的に推定される
    //つまり、モデルクラスのクラス名の複数形のテーブルが対応していると解釈される。

    public function tasks()
    {
        // フォルダテーブルとタスクテーブルの関連性を辿って、フォルダクラスのインスタンスから紐づくタスククラスのリストを取得
        // 第一引数=モデル名(名前空間も含む) 
        // 第二引数=関連するテーブルが持つ外部キーカラム名 
        // 第三引数=モデルにhasManyが定義されている側のテーブル持つ、外部キーに紐づけられたカラムの名前
        // * 第二引数が テーブル名単数形_id で第三引数が id の決まりであれば、省略可
        return $this->hasMany('App\Task', 'folder_id', 'id');
    }
}
