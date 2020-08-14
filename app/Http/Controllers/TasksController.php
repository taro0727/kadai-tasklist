<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;

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
        
        if(\Auth::check()){
        $user = \Auth::user();

        // ユーザの投稿一覧を作成日時の降順で取得
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
        //タスク一覧ビューでそれを表示
       
            return view('tasks.index',[
            'tasks'=> $tasks,
        ]);
        }
        
        else{
             return view('tasks.welcome');
        }    
        
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

          $task = new Task;    
        //タスク作成
        // $task->user_idに\Auth::id()を入れてあげる
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
        ]);
        $request->user()->tasks()->create([
        'user_id' => \Auth::id(),
        'status' => $request->status,
        'content' => $request->content,
        ]);
        
        
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
        
            if(\Auth::id() === $task->user_id){
            return view('tasks.show',[
            'task' => $task,
            ]);
            }
        
        return redirect('/');
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
        
            if(\Auth::id()=== $task->user_id){
            return view('tasks.edit',[
            'task'=> $task,
            ]);
            }
        

        return redirect('/');
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
        if(\Auth::id() === $task->user_id) {
        $request->user()->tasks()->create([
        'user_id' => \Auth::id(),
        'status' => $request->status,
        'content' => $request->content,
        ]);
        }
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
        if (\Auth::id() === $task->user_id) {
        $task->delete();
        }
        
        // トップページへリダイレクト
        return redirect('/');
    }
}
