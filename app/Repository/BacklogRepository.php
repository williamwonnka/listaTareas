<?php

namespace App\Repository;

use App\Models\Sprint;

class BacklogRepository
{

    public function createSprint(mixed $name, mixed $start_date, mixed $end_date, mixed $project_id): Sprint
    {
        $sprint = new Sprint();

        $sprint->name = $name;
        $sprint->start_date = $start_date;
        $sprint->end_date = $end_date;
        $sprint->project_id = $project_id;

        $sprint->save();

        return $sprint->refresh();
    }
}
