<?php

namespace App\Filament\Pages;

use App\Models\Audit;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms;
use Filament\Notifications\Notification;

class AuditsEnAttente extends Page implements HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static string $view = 'filament.pages.audits-en-attente';
    protected static ?string $title = 'Audits en attente';
    protected static ?string $navigationLabel = 'Audits en attente';
    protected static ?string $navigationGroup = 'Gestion des audits';

    // Table query
    protected function getTableQuery(): Builder
    {
        $query = Audit::query()->where('statut', 'en_attente');

        if (!in_array(Auth::user()->role, ['admin', 'conseiller'])) {
            $query->where('id_demandeur', Auth::id());
        }

        return $query->with(['demandeur', 'document'])->orderByDesc('date_demande');
    }

    // Table columns
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('demandeur.name')
                ->label('Demandeur')
                ->sortable()
                ->searchable()
                ->toggleable()
                ->wrap(),

            Tables\Columns\TextColumn::make('document.nom_fichier')
                ->label('Document audité')
                ->sortable()
                ->searchable()
                ->toggleable()
                ->wrap(),

            Tables\Columns\TextColumn::make('objet')
                ->label('Objet')
                ->searchable()
                ->limit(30)
                ->wrap(),

            Tables\Columns\BadgeColumn::make('statut')
                ->label('Statut')
                ->colors([
                    'secondary' => 'en_attente',
                    'warning' => 'en_cours',
                    'success' => 'termine',
                ])
                ->formatStateUsing(fn ($state) => match ($state) {
                    'en_attente' => 'En attente',
                    'en_cours' => 'En cours',
                    'termine' => 'Terminé',
                    default => $state,
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('rapport')
                ->label('Rapport')
                ->limit(40)
                ->toggleable(),

            Tables\Columns\TextColumn::make('reponse')
                ->label('Réponse')
                ->limit(40)
                ->toggleable(),

            Tables\Columns\TextColumn::make('date_demande')
                ->label('Date de demande')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
        ];
    }

    // Actions sur chaque ligne
    protected function getTableActions(): array
    {
        return [
           /*  Tables\Actions\ViewAction::make()
                ->label('Voir')
                ->icon('heroicon-o-eye')
                ->modalHeading('Détails de l\'audit')
                ->mountUsing(fn ($livewire, Audit $record) => $livewire->fill([
                    'audit' => $record->load('document'),
                ]))
                ->modalContent(function (Audit $record) {
                    return view('filament.partials.audit-view', ['audit' => $record]);
                }), */

                Tables\Actions\ViewAction::make()
    ->label('Voir')
    ->icon('heroicon-o-eye')
    ->modalHeading('Détails de l\'audit')
    ->mountUsing(fn ($livewire, Audit $record) => $livewire->fill([
        'audit' => $record->load(['document', 'demandeur']),
    ]))
    ->modalContent(function (Audit $record) {
        // Récupère tous les documents du même demandeur (ou adapte selon ta logique)
        $documents = $record->demandeur
            ? \App\Models\Document::where('id_uploader', $record->demandeur->id_user)->get()
            : collect();

        return view('filament.partials.audit-view', [
            'audit' => $record,
            'documents' => $documents,
        ]);
    }),

            Tables\Actions\Action::make('repondre')
                ->label('Répondre')
                ->icon('heroicon-o-eye-slash')
                ->form([
                    Forms\Components\Textarea::make('reponse')
                        ->label('Réponse')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (Audit $record, array $data) {
                    $record->reponse = $data['reponse'];
                    $record->statut = 'termine';
                    $record->save();

                    Notification::make()
                        ->success()
                        ->title('Réponse enregistrée')
                        ->body('Le statut a été mis à "Terminé".')
                        ->send();
                }),
        ];
    }

    // Bulk actions (optionnel)
    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\DeleteBulkAction::make()
                ->label('Supprimer'),
        ];
    }

    // Filtres (optionnel)
    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('statut')
                ->label('Statut')
                ->options([
                    'en_attente' => 'En attente',
                    'en_cours' => 'En cours',
                    'termine' => 'Terminé',
                ]),
        ];
    }
}
