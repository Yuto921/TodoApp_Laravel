<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// {id} フォルダIDごとのタスクを表示
Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');

// フォルダ作成ページを表示する
Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');

// フォルダ作成処理を実行する
Route::post('/folders/create', 'FolderController@create');

// タスク作成ページを表示する
Route::get('/folders/{id}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');

// タスク作成処理を実行する
Route::post('/folders/{id}/tasks/create', 'TaskController@create');

// タスク編集ページを表示する
Route::get('/folders/{id}/tasks/{tasks_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');

// タスク編集処理を実行する
Route::post('/folders/{id}/tasks/{tasks_id}/edit', 'TaskController@edit');

/*
    name メソッドによるルートの命名は、get だけに定義しています。名前をつけて呼び出せるのは、URLだけ。
*/