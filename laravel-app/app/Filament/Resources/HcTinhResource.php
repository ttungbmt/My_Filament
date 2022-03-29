<?php

namespace App\Filament\Resources;

use App\Filament\Filters\SelectFilter;
use App\Filament\Filters\TextInputFilter;
use App\Filament\Resources\HcTinhResource\Pages;
use Filament\Forms\Components\Grid;
use FilamentPro\Resources\Resource;
use App\Filament\Resources\HcTinhResource\RelationManagers;
use App\Filament\Resources\HcTinhResource\RelationManagers\QuanhuyensRelationManager;
use App\Models\HcTinh;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Actions\LinkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HcTinhResource extends Resource
{
    protected static ?string $model = HcTinh::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $recordTitleAttribute = 'ten';

    public static function getGloballySearchableAttributes(): array
    {
        return ['ma', 'ten'];
    }

    public static function getLabel(): string
    {
        return __('app.hc_tinh');
    }

    public static function form(Form $form): Form
    {
        return $form->schema(
            Grid::make()
                ->schema([
                    TextInput::make('ma')->label(__('app.matinh'))->required(),
                    TextInput::make('ten')->label(__('app.tentinh'))->required(),
                    Select::make('cap')->label(__('app.cap_hc'))->options(HcTinh::getDirCap()),
                ])
                ->columns(1)
                ->inlineLabel(true)
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ma')->label(__('app.matinh'))->searchable()->sortable(),
                TextColumn::make('ten')->label(__('app.tentinh'))->searchable()->sortable(),
                TextColumn::make('cap')->label(__('app.cap_hc'))->searchable()->sortable(),
                TextColumn::make('quans_count')->counts('quans')->label(__('app.quans_count'))->sortable()->visibleFrom('md'),
                TextColumn::make('phuongs_count')->counts('phuongs')->label(__('app.phuongs_count'))->sortable()->visibleFrom('md'),
            ])
            ->defaultSort('ma')
            ->filters([
                TextInputFilter::make('ma')
                    ->label(__('app.matinh'))->strict(),
                TextInputFilter::make('ten')
                    ->label(__('app.tentinh')),
                SelectFilter::make('cap')
                    ->label(__('app.cap_hc'))
                    ->options(HcTinh::getDirCap()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
//            QuanhuyensRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHcTinh::route('/'),
            'edit' => Pages\EditHcTinh::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}
