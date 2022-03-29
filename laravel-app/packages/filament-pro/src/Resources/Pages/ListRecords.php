<?php
namespace FilamentPro\Resources\Pages;

use Filament\Tables\Filters\Filter;
use Filament\Forms;

class ListRecords extends \Filament\Resources\Pages\ListRecords
{
    protected function getTableFiltersFormSchema(): array
    {
        return array_map(
            fn (Filter $filter) => Forms\Components\Group::make()
                ->schema($filter->getFormSchema())
                ->columnSpan($filter->getColumnSpan())
                ->columns($filter->getColumns())
                ->statePath($filter->getName()),
            $this->getCachedTableFilters(),
        );
    }
}
