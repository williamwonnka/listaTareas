<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus  extends Model
{
    protected $table = 'task_statuses';
    protected $primaryKey = 'id';
    protected $connection = 'MAIN_MYSQL_DB';

    protected $fillable = [
        'name'
    ];

    protected $guarded = [
        'id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id', 'id');
    }
}
