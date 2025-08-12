<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Document;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Filament\Tables;
use Filament\Pages\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Facades\Storage;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    // Actions en haut (bouton Upload avec vérifications)
   protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make()
            ->label(__('all.upload_document'))
            ->icon('heroicon-o-arrow-up-tray')
            ->createAnother(false)
            ->before(function (Actions\CreateAction $action, $data) {
                $client = User::find($data['user_id'] ?? auth()->id());
                $tenant = $client ? $client->tenant : null; // plus getCurrentFilterTenant()

                $fileSize = isset($data['file_path']) ? Storage::size($data['file_path']) : 0;

                if (!$tenant || !$tenant->canAddInvoice($fileSize)) {
                    Notification::make()
                        ->warning()
                        ->title(__('all.invoice_limit_reached'))
                        ->body(__('all.invoice_limit_reached_body'))
                        ->persistent()
                        ->actions([
                            NotificationAction::make('support')
                                ->button()
                                ->color('success')
                                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                                ->url(config('app.website.contact.whatsapp'), shouldOpenInNewTab: true),
                        ])
                        ->send();

                    if (isset($data['file_path'])) {
                        Storage::delete($data['file_path']);
                    }

                    $action->halt();
                }
                if (!$client || !$client->getActivePeriod() || empty($client->getActivePeriod()?->plans)) {
                    Notification::make()
                        ->warning()
                        ->title(__('all.no_active_period_or_plan'))
                        ->body(__('all.no_active_period_or_plan_message_body'))
                        ->persistent()
                        ->send();
                    $action->halt();
                }
            })
            ->visible(true),  // toujours visible (ou ajoute ta propre condition ici)
    ];
}


    // Tabs sans usage de moderation_status
    public function getTabs(): array
    {
        $baseQuery = Document::query();

        $clientId = auth()->user()->client_id ?? null;
        if ($clientId) {
            $baseQuery->where('user_id', $clientId);
        }

        return [
           /*  'all' => Tab::make(__('all.all_documents'))
                ->badge(fn() => $baseQuery->count()), */
            // Puisque tu veux éviter moderation_status, supprime les autres tabs :
            // Tu peux créer d'autres filtres si tu veux, basés sur d'autres colonnes.
        ];
    }

    // Colonnes du tableau
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nom_fichier')->label(__('all.name'))->searchable(),
            Tables\Columns\TextColumn::make('type')->label(__('all.type'))->searchable(),
            Tables\Columns\TextColumn::make('file_size')->label(__('all.size_ko'))->sortable(),
            Tables\Columns\TextColumn::make('pages_count')->label('Pages')->sortable(),
            // Suppression de la colonne moderation_status :
            // Tables\Columns\TextColumn::make('moderation_status')->label('Statut')->badge()->sortable(),
            Tables\Columns\TextColumn::make('created_at')->label(__('all.date'))->dateTime()->sortable(),
            Tables\Columns\TextColumn::make('uploader.name')->label(__('all.uploader'))->sortable()->searchable(),
        ];
    }

    // Actions du tableau (voir, éditer, télécharger)
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            Tables\Actions\ViewAction::make()->label(__('all.view')),
            Tables\Actions\Action::make('download')
                ->label(__('all.download'))
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn ($record) => response()->download(storage_path('app/public/documents/' . $record->nom_fichier)))
                ->color('success'),
        ];
    }

     protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\DocumentResource\Widgets\DocumentStatsOverview::class,
        ];
    }

    // Actions en masse
    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\DeleteBulkAction::make(),
        ];
    }

    // Requête personnalisée (ex : filtrage par uploader pour pharmacien)
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        if (auth()->user()->role === 'pharmacien') {
            $query->where('id_uploader', auth()->id());
        }

        return $query;
    }
}
