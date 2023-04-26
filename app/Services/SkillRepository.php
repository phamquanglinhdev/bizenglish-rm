<?php

namespace App\Services;

use App\Models\Skill;
use App\Repositories\CrudRepository;

class SkillRepository extends CrudRepository
{

    public function __construct(Skill $skill)
    {
        $this->model = $skill;
    }
}
