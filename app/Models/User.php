<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * \App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CommentsByTask> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @property  int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $lastname
 * @mixin \Eloquent
 */
class User extends Model
{
    use HasFactory;

    protected $table = 'users';
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
