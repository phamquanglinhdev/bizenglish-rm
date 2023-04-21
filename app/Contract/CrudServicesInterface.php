<?php

namespace App\Contract;

interface CrudServicesInterface
{
    public function setupListOperation();

    public function setupFilterOperation();

    public function setupCreateOperation();

    public function setupEditOperation($id);
}
