<?php

namespace App\Filament\Resources\SiteSettingsResource\Pages;

use App\Filament\Resources\SiteSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\SiteSettings;
class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingsResource::class;

    protected function getHeaderActions(): array
    {
        // Affiche le bouton "Créer" seulement s'il n'y a aucune donnée
        if (SiteSettings::count() === 0) {
            return [
                Actions\CreateAction::make(),
            ];
        }
        return [];
    }
}
