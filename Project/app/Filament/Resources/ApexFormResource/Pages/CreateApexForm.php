<?php

namespace App\Filament\Resources\ApexFormResource\Pages;

use App\Filament\Resources\ApexFormResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateApexForm extends CreateRecord
{
    protected static string $resource = ApexFormResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function handleRecordCreation(array $data): Model
    {
        $data['status'] = 2;
        $apex = static::getModel()::create($data);    
        return $apex;
    }
}
