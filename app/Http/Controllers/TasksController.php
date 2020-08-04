<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //一覧表示
    public function index()
    {
        //タスク一覧を取得
        $tasks = Task::all();
        
        //タスク一覧ビューでそれを表示
        return view('tasks.index',[
            'tasks'=> $tasks,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //新規作成
    public function create()
    {
        $task = new Task;
        
        //タスク作成ビューを表示
        return view('tasks.create',[
            'task' => $task,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //新規登録処理
    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
            ]);
            
        //タスク作成
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        //トップページへのリダイレクト
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //idの値でタスク検索、取得
        $task = Task::findOrFail($id);
        
        //タスク詳細ビューで結果表示
        return view('tasks.show',[
            'task' => $task,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //idの値でタスクを検索、取得
        $task = Task::findOrFail($id);
        
        //タスク編集ビューで結果表示
        return view('tasks.edit',[
            'task'=> $task,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
            ]);
            
        //idの値でタスクを検索、取得
        $task = Task::findOrFail($id);
        //タスク更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        //トップページへリダイレクト
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //idの値でタスク検索、取得
        $task = Task::findOrFail($id);
        
        //削除処理
        $task->delete();
        
        //トップページへリダイレクト
        return redirect('/');
    }
}
