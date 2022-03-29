<?php

namespace App\Filament\Resources\HcPhuongResource\Pages;

use FilamentPro\Resources\Pages\ListRecords;
use App\Filament\Resources\HcPhuongResource;

class ListHcPhuongs extends ListRecords
{
    protected static string $resource = HcPhuongResource::class;

    protected function getTableFiltersFormColumns(): int {
        return 2;
    }
}
