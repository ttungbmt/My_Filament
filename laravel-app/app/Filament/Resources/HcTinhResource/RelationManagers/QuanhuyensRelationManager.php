<?php

namespace App\Filament\Resources\HcTinhResource\RelationManagers;

use App\Filament\Resources\HcQuanResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class QuanhuyensRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'quanhuyens';

    protected static ?string $recordTitleAttribute = 'ten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(HcQuanResource::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(HcQuanResource::getTableColumns())
            ->filters([
                //
            ]);
    }
}
