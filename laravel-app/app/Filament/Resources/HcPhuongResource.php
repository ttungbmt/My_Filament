<?php

namespace App\Filament\Resources;

use FilamentPro\Resources\Resource;
use App\Filament\Filters\Filter;
use App\Filament\Filters\SelectFilter;
use App\Filament\Filters\TextInputFilter;
use App\Filament\Resources\HcPhuongResource\Pages;
use App\Models\HcPhuong;
use App\Models\HcQuan;
use App\Models\HcTinh;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class HcPhuongResource extends Resource
{
    protected static ?string $model = HcPhuong::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $recordTitleAttribute = 'ten';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['ma', 'ten'];
    }

    public static function getLabel(): string
    {
        return __('app.hc_phuong');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('ma_tp')->label(__('app.hc_tinh'))
                    ->options(fn() => HcTinh::getDirMatinh())
                    ->reactive()
                    ->searchable()
                    ->required(),
                Select::make('ma_qh')->label(__('app.hc_quan'))
                    ->options(fn(Closure $get) => HcQuan::getDirQuanByTinh($get('ma_tp')))
                    ->disabled(fn(Closure $get) => blank($get('ma_tp')))
                    ->searchable()
                    ->required(),
                TextInput::make('ma')->label(__('app.maphuong'))->required(),
                TextInput::make('ten')->label(__('app.tenphuong'))->required(),
                Select::make('cap')->label(__('app.cap_hc'))
                    ->label(__('app.cap_hc'))
                    ->options(HcPhuong::getDirCap())->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quan.tinh.ten')->label(__('app.tentinh'))->searchable()->sortable(),
                TextColumn::make('quan.ten')->label(__('app.tenquan'))->searchable()->sortable(),
                TextColumn::make('ma')->label(__('app.maphuong'))->searchable()->sortable(),
                TextColumn::make('ten')->label(__('app.tenphuong'))->searchable()->sortable(),
                TextColumn::make('cap')->label(__('app.cap_hc'))->searchable()->sortable(),
            ])
            ->filters([
                Filter::make('hanhchinh')->form([
                    Select::make('ma_tp')->label(__('app.hc_tinh'))->options(HcTinh::getDirMatinh())->reactive(),
                    Select::make('ma_qh')->label(__('app.hc_quan'))
                        ->options(fn (Closure $get) => HcQuan::getDirQuanByTinh($get('ma_tp')))
                        ->disabled(fn(Closure $get) => blank($get('ma_tp'))),
                ]) ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['ma_tp'],
                            fn (Builder $query, $value): Builder => $query->where('ma_tp', $value),
//                            fn (Builder $query, $value): Builder => $query->whereRelation('tinh', $query->getModel()->tinh()->getQualifiedForeignKeyName(), $value),
                        )
                        ->when(
                            $data['ma_qh'],
                            fn (Builder $query, $value): Builder => $query->where('ma_qh', $value),
                        );
                })->columnSpan(2)->columns(2),
                TextInputFilter::make('ma')
                    ->label(__('app.maphuong'))->strict(),
                TextInputFilter::make('ten')
                    ->label(__('app.tenphuong')),
                SelectFilter::make('cap')
                    ->label(__('app.cap_hc'))
                    ->options(HcPhuong::getDirCap())
                ->columnSpan(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHcPhuongs::route('/'),
            'create' => Pages\CreateHcPhuong::route('/create'),
            'edit' => Pages\EditHcPhuong::route('/{record}/edit'),
        ];
    }
}
