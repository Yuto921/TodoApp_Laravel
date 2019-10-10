<?php

namespace App\Http\Controllers;

use App\Folder; // App は Folder.php(Model) の namespace App; からきている
use App\Task; // TaskModel
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask; // requestファイルのCreateTask.phpを読み込む
use App\Http\Requests\EditTask;


class TaskController extends Controller
{
    // タスクを表示
    public function index(int $id)
    {
        // 全てのフォルダを取得する
        $folders = Folder::all();

        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得する getメソッドで値を取得する
        // $tasks = Task::where('folder_id', $current_folder->id)->get();

        // リレーション後の書き方 (選ばれたフォルダに紐づくタスク取得) Folderモデルのtask()メソッドを参照
        $tasks = $current_folder->tasks()->get();

            // 引数を三つ与えると、イコール以外の比較も可能
            // Tasks::where('folder_id', '=', $current_folder->id)->get();

        // 1引数=ファイル名 2引数=渡すデータ(配列)
        return view('tasks/index',[
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(int $id)
    {
        return view('tasks/create',[
            'folder_id' => $id
        ]);
    }

    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        // リレーションを活かしたデータの保存方法
        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    public function showEditForm(int $id, int $task_id)
    {
        // 編集対象のタスクデータを取得
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request)
    {
        // 1 リクエストされた ID でタスクデータを取得
        $task = Task::find($task_id);

        // 2 編集対象のタスクデータに入力値を詰めて save
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        // 3 編集対象のタスクが属するタスク一覧画面へリダイレクト
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}









// アクセサ　モデルクラスが本来持つデータを加工した値を、さらにモデルクラスのプロパティであるかのように参照できる機能
// アクセサの使いどころは、モデルが持つ属性データ（テーブルで言うところの各カラムの値）を加工した値を取得したいときです
/* ( 例 )
class Person extends Model
{
    // モデルクラスに get〇〇Attributeという決まったフォーマットのメソッドを用意
    public function getGenderTextAttribute()
    {
        // テーブルのカラムの値は、attribute配列に入っている
        switch($this->attributes['gender']) {
            case 1:
                return 'male';
            case 2:
                return 'female';
            default:
                return '??';
        }
    }
}
*/

/*
$this->attributes['gender']
これで gender カラムの値を取得しています。
Laravel ではモデルクラスの属性データ（テーブルで言うところの各カラムの値）は
それぞれがクラスのプロパティで管理されているのではなく、
$attributes という一つのプロパティで
配列として管理されている。

$folder->title とクラスのプロパティのように
タイトルを取得していたが、これは PHP のマジックメソッド __get() を利用しています。
本当は Folder クラスには title というプロパティは存在しません（定義しなかった）。
モデルクラスは、存在しないプロパティを参照されると 
$attributes からプロパティ名と一致するキーの値が返すように実装されているのです。
*/
