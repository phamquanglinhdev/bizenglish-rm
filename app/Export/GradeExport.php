<?php

namespace App\Export;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class GradeExport implements FromCollection
{
    private array $data;

    public function __construct($array)
    {
        $this->data = $array;
    }

    /**
     * @inheritDoc
     */
    public function collection(): Collection
    {
        return Collection::make($this->data);
    }
}
