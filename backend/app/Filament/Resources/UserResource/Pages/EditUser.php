<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables;


class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
{
    // On ne met à jour que les champs fournis, et on enlève ceux qui sont vides comme password
    $updateData = [];

    if (!empty($data['role'])) {
        $updateData['role'] = $data['role'];
    }

    if (!empty($data['password'])) {
        $updateData['password'] = bcrypt($data['password']);
    }

    if (array_key_exists('is_active', $data)) {
        $updateData['is_active'] = $data['is_active'];
    }
    if (!empty($data['first_name'])) {
        $updateData['first_name'] = $data['first_name'];
    }
    if (!empty($data['last_name'])) {
        $updateData['last_name'] = $data['last_name'];
    }
    if (!empty($data['email'])) {
        $updateData['email'] = $data['email'];
    }
    if (!empty($data['phone'])) {
        $updateData['phone'] = $data['phone'];
    }
    if (!empty($data['phone_2'])) {
        $updateData['phone_2'] = $data['phone_2'];
    }
    if (!empty($data['address'])) {
        $updateData['address'] = $data['address'];
    }
    if (!empty($data['city'])) {
        $updateData['city'] = $data['city'];
    }
    if (!empty($data['postal_code'])) {
        $updateData['postal_code'] = $data['postal_code'];
    }
    if (!empty($data['country'])) {
        $updateData['country'] = $data['country'];
    }
    if (!empty($data['job_title'])) {
        $updateData['job_title'] = $data['job_title'];
    }
    if (!empty($data['avatar_url'])) {
        $updateData['avatar_url'] = $data['avatar_url'];
    }
    if (!empty($data['last_login_at'])) {
        $updateData['last_login_at'] = $data['last_login_at'];
    }
    if (!empty($data['email_verified_at'])) {
        $updateData['email_verified_at'] = $data['email_verified_at'];
    }
    if (!empty($data['created_at'])) {
        $updateData['created_at'] = $data['created_at'];
    }
    if (!empty($data['updated_at'])) {
        $updateData['updated_at'] = $data['updated_at'];
    }
    
    return $updateData;
}
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
