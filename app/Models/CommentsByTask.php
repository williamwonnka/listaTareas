<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentsByTask  extends Model
{
    protected $table = 'comments_by_task';
    protected $primaryKey = 'id';
    protected $connection = 'MAIN_MYSQL_DB';

    protected $fillable = [
        'task_id',
        'content',
        'user_id'
    ];

    protected $guarded = [
        'id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
