<?php

namespace App\Filament\Resources\AuditResource\Pages;

use App\Filament\Resources\AuditResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Pages\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class ViewAudit extends ViewRecord
{
    protected static string $resource = AuditResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informations générales')
                    ->description('Détails du demandeur et du document audité')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('demandeur.name')->label('Nom du demandeur'),
                                TextEntry::make('document.nom_fichier')->label('Document audité'),
                            ]),
                    ]),

                Section::make('Détails de l’audit')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('objet')->label('Objet de l’audit'),
                                TextEntry::make('statut')->label('Statut'),
                                TextEntry::make('date_demande')->label('Date de la demande')->dateTime('d/m/Y H:i'),
                                TextEntry::make('date_realisation')->label('Date de réalisation')->dateTime('d/m/Y H:i')->hidden(fn () => !in_array(auth()->user()->role, ['admin', 'conseiller'])),
                            ]),
                    ]),

                Section::make('Rapport')
                    ->schema([
                        TextEntry::make('rapport')->label('Contenu du rapport')->markdown(),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Tu peux ajouter un bouton d’édition si besoin :
            Action::make('Modifier')
                ->url($this->getResource()::getUrl('edit', ['record' => $this->record]))
                ->visible(fn () => auth()->user()->role === 'admin'),
        ];
    }
}
