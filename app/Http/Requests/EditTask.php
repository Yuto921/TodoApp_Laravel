<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
{
    public function rules()
    {
        $rule = parent::rules();

        $status_rule = Rule::in(array_keys(Task::STATUS));
        // -> 'in(1, 2, 3)' を出力する

        return $rule +  [
            'status' => 'required|' . $status_rule,
        ];
        // 'status' => 'required|in(1, 2, 3)'
    }

    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        $messages = parent::messages();

        $status_labels = array_map(function($item){
            return $item['label'];
        }, Task::STATUS);

        $status_labels = implode('、', $status_labels);

        // 「状態 には 未着手、着手中、完了 のいずれかを指定してください。」というメッセージ
        return [
            'status.in' => ':attribute には　' . $status_labels . '　のいずれかを指定してください。',
        ];
    }
}

// タスクの作成と編集では状態欄の有無が異なるだけでタイトルと期限日は同一なので重複を避けるために継承

// 状態欄には入力値が許可リストに含まれているか検証する in ルールを使用
// 許可リストは array_keys(Task::STATUS) で配列として取得できるので、Rule クラスの in メソッドを使ってルールの文字列を作成

// Task::STATUS から status.in ルールのメッセージを作成

// Task::STATUS の各要素から label キーの値のみ取り出して作った配列をさらに句読点でくっつけて文字列を作成

