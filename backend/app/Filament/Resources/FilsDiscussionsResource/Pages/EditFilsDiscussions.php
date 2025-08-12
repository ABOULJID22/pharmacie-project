<?php

namespace App\Filament\Resources\FilsDiscussionsResource\Pages;

use App\Filament\Resources\FilsDiscussionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFilsDiscussions extends EditRecord
{
    protected static string $resource = FilsDiscussionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
