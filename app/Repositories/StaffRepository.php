<?php

namespace App\Repositories;

use App\Models\Staff;

class StaffRepository extends CrudRepository
{
    public function __construct(Staff $staff)
    {
        $this->model = $staff;
    }



}
