<?php

namespace App\ViewModels\Staff;

class StaffListViewModel
{
    public function __construct(
        private readonly array $staffs
    )
    {
    }

    /**
     * @return array
     */
    public function getStaffs(): array
    {
        return $this->staffs;
    }
}
