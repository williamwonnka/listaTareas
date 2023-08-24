<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User  extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $connection = 'MAIN_MYSQL_DB';

    protected $fillable = [
        'username',
        'password',
        'name',
        'lastname'
    ];

    protected $guarded = [
        'id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(CommentsByTask::class, 'user_id', 'id');
    }
}
