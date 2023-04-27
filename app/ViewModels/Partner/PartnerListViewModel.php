<?php

namespace App\ViewModels\Partner;

class PartnerListViewModel
{
    public function __construct(
        private readonly array $partners
    )
    {
    }

    /**
     * @return array
     */
    public function getPartners(): array
    {
        return $this->partners;
    }
}
