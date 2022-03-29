<?php

namespace App\Filament\Resources\HcTinhResource\Pages;

use App\Filament\Resources\HcTinhResource;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;

class EditHcTinh extends EditRecord
{
    protected static string $resource = HcTinhResource::class;

//    protected function getRedirectUrl(): string
//    {
//        return $this->getResource()::getUrl('index');
//    }

//    protected function getFormActions(): array
//    {
//        $actions = parent::getFormActions();
//
//        array_splice($actions, 1, 0, [
//            ButtonAction::make('saveAndClose')->label('Save & Close')->action('saveAndClose')
//        ]);
//
//        return $actions;
//    }

    public function saveAndClose(): void
    {
//        $this->save(false);
//        $this->redirect($this->getResource()::getUrl('index'));
    }
}
