<?php

namespace App\Filament\Resources\ApexFormResource\Pages;

use App\Filament\Resources\ApexFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApexForms extends ListRecords
{
    protected static string $resource = ApexFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Apex')
            ->icon('heroicon-s-plus-circle'),
        ];

    }
}
