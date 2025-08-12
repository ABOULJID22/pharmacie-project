<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Document;

class DocumentHistory extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.document-history';
    protected static ?string $title = 'Document History';
    protected static ?string $navigationGroup = 'Gestion de fichiers';
    protected static ?string $navigationLabel = 'Document History';

 public function getTitle(): string
    {
        return __('Document History');
    }

    public static function getNavigationLabel(): string
    {
        return __('Document History');
    }

    public $documents;

public function mount()
{
   $user = auth()->user();

    if ($user && $user->role === 'admin') {
        $this->documents = Document::latest('date_upload')->get();
    } elseif ($user && $user->role === 'pharmacien') {
        $this->documents = Document::where('id_uploader', $user->id_user)
            ->latest('date_upload')
            ->get();
    } else {
        $this->documents = collect(); // Aucun document pour les autres rôles
    }
}
    public function getViewData(): array
    {
        return [
            'documents' => $this->documents,
        ];
    }
    


public static function canAccess(): bool
{
    $user = auth()->user();
    return $user && ($user->role === 'admin' || $user->role === 'pharmacien');
}


    
}
