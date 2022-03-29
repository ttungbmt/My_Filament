<?php

namespace App\Filament\Filters;

use Filament\Forms\Components\Concerns\CanSpanColumns;
use Filament\Forms\Concerns\HasColumns;

class Filter extends \Filament\Tables\Filters\Filter
{
    use CanSpanColumns;
    use HasColumns;
}
