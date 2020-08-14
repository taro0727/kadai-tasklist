<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // fillableにstatusも含める
    protected $fillable = ['content','status'];
    
    /**
     * このタスク所有ユーザ
     */
    public function user()
    {
        return $this->belomgsTo(User::class);
    }
    //
    protected $table ='tasks';
}
