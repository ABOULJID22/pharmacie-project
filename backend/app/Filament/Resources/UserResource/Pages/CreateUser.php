<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['name'] = $data['first_name'] . ' ' . $data['last_name'];

    if (!empty($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    }

    return $data;
}

}
