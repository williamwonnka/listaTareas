<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static whereName(string $name)
 * @method static whereStartDate(\Illuminate\Support\Carbon $start_date)
 * @method static whereEndDate(\Illuminate\Support\Carbon $end_date)
 * @method static whereProjectId(int $project_id)
 *
 * @property-read \App\Models\Project $project
 */
class Sprint extends Model
{
    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'sprint_tbl';

    /**
     * The connection to the database that will be used.
     *
     * @var string
     */
    protected $connection = 'MAIN_MYSQL_DB';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that are guarded from mass assignment.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = [
        'project',
    ];

    /**
     * Get the project that owns the sprint.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @var Task[]
     */
    public Collection $tasks;

    public $timestamps = true;
}
