<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    /* protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Crée d'abord le record (le fichier est uploadé par Filament)
        $record = parent::handleRecordCreation($data);

        // Génère l'URL publique du fichier stocké
        $url = Storage::disk('public')->url('documents/' . $record->nom_fichier);

        // Mets à jour le champ url_storage dans la base
        $record->url_storage = $url;
        $record->save();

        return $record;
    } */
}
