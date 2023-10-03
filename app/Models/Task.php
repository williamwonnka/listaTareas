<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $connection = 'MAIN_MYSQL_DB';

    protected $fillable = [
        'name',
        'details',
        'user_id',
        'status_id',
        'sprint_id'
    ];

    protected $guarded = [
        'id'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(CommentsByTask::class, 'task_id', 'id');
    }
}
