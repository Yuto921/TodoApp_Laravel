<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
            'due_date' => 'required|date|after_or_equal:today', // date:日付を表す数値　after_or_equal:today:今日を含んだ未来日だけを許容
        ];
    }

    // エラーメッセージに関するやつ
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'due_date' => '期限日',
        ];
    }

    public function messages()
    {
        // キーでメッセージが表示されるべきルールを指定する。
        // ドット区切りで左側が項目、右側がルールを意味する。
        return [
            // due_date の after_or_equal ルールに違反した場合は、値に指定されたメッセージを出力するという意味
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
