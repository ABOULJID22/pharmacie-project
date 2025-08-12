<?php

namespace App\Filament\Resources\DocumentResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\Document;

class DocumentCards extends Widget
{
    protected static string $view = 'filament.resources.document-resource.widgets.document-cards';

    // Récupérer les documents directement dans une propriété calculée (getter)
    public function getDocumentsProperty()
    {
        return Document::latest()->take(6)->get();
    }
}
