<?php

namespace App\Filament\Resources;

use FilamentPro\Resources\Resource;
use App\Filament\Filters\TextInputFilter;
use App\Filament\Resources\HcQuanResource\Pages;
use App\Filament\Resources\HcQuanResource\RelationManagers;
use App\Models\HcQuan;
use App\Models\HcTinh;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HcQuanResource extends Resource
{
    protected static ?string $model = HcQuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $recordTitleAttribute = 'ten';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->{static::$recordTitleAttribute};
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['ma', 'ten'];
    }

    public static function getLabel(): string
    {
        return __('app.hc_quan');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema(Card::class));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->filters([
                SelectFilter::make('matinh')
                    ->label(__('app.tentinh'))
                    ->searchable()
                    ->options(HcTinh::getDirMatinh())->column('tinh.ma'),
                TextInputFilter::make('ma')
                    ->label(__('app.maquan'))->strict(),
                TextInputFilter::make('ten')
                    ->label(__('app.tenquan')),
                SelectFilter::make('cap')
                    ->label(__('app.cap_hc'))
                    ->options(HcQuan::getDirCap()),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHcQuans::route('/'),
            'create' => Pages\CreateHcQuan::route('/create'),
            'edit' => Pages\EditHcQuan::route('/{record}/edit'),
        ];
    }


    public static function getFormSchema(string $layout = Grid::class): array {
        return [
            TextInput::make('ma')->label(__('app.maquan')),
            TextInput::make('ten')->label(__('app.tenquan')),
            TextInput::make('cap')->label(__('app.cap_hc')),
        ];
    }

    public static function getTableColumns(): array {
        return [
            TextColumn::make('tinh.ma')->label(__('app.matinh'))->searchable()->sortable(),
            TextColumn::make('tinh.ten')->label(__('app.tentinh'))->searchable()->sortable(),
            TextColumn::make('ma')->label(__('app.maquan'))->searchable()->sortable(),
            TextColumn::make('ten')->label(__('app.tenquan'))->searchable()->sortable(),
            TextColumn::make('cap')->label(__('app.tenquan'))->searchable()->sortable(),
            TextColumn::make('phuongs_count')->counts('phuongs')->label(__('app.phuongs_count'))->sortable(),
        ];
    }

//    public static function getEloquentQuery(): Builder
//    {
//        return parent::getEloquentQuery();
//    }
}
