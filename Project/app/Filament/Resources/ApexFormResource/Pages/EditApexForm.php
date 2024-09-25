<?php

namespace App\Filament\Resources\ApexFormResource\Pages;

use App\Filament\Resources\ApexFormResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditApexForm extends EditRecord
{
    protected static string $resource = ApexFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Delete Apex')
            ->icon('heroicon-s-trash')->successNotification(
                Notification::make()
                     ->danger()
                     ->title('User Deleted'),
             )
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Apex Updated';
    }
}
