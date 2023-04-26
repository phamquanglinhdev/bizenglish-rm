<?php

namespace App\Repositories;

use App\Models\Partner;

class PartnerRepository extends CrudRepository
{
    public function __construct(Partner $partner)
    {
        $this->model = $partner;
    }
}
