<?php

namespace App\Filament\Resources\HcTinhResource\Pages;

use App\Filament\Resources\HcTinhResource;
use FilamentPro\Resources\Pages\ManageRecords;

class ManageHcTinh extends ManageRecords
{
    protected static string $resource = HcTinhResource::class;

    protected function getCreateFormSchema(): array
    {
        return $this->getResourceForm(columns: 2)->getSchema();
    }

    protected function getEditFormSchema(): array
    {
        return $this->getCreateFormSchema();
    }

}
