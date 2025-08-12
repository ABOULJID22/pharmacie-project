<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\Document;
use App\Models\User;
use App\Exports\DocumentExport;
use App\Services\DocumentService;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Maatwebsite\Excel\Facades\Excel;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('assign_users')
                ->label(__('all.assign_users'))
                ->icon('heroicon-o-user-plus')
                ->color('info')
                ->visible(fn(Document $record) =>
                    $record->isFinished() &&
                    !$record->isValidated() &&
                    auth()->user()?->role === User::ROLE_ADMIN
                )
                ->form([
                    Forms\Components\Repeater::make('assignments')
                        ->label(false)
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->label(__('all.user'))
                                ->options(function () {
                                    return User::where('is_active', true)
                                        ->whereIn('role', [User::ROLE_PHARMACIEN, User::ROLE_ADMIN])
                                        ->get()
                                        ->pluck('name', 'id_user');
                                })
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->required()
                                ->searchable()
                                ->preload(),

                            Forms\Components\Toggle::make('assigned')
                                ->label(__('all.assigned'))
                                ->distinct()
                                ->inline(false)
                                ->default(false)
                        ])
                        ->columns(2)
                        ->defaultItems(1)
                        ->maxItems(5)
                        ->reorderable(false)
                ])
                ->fillForm(
                    fn(Document $record) => [
                        'assignments' => $record->assignedUsers->map(function ($user) use ($record) {
                            return [
                                'user_id' => $user->id_user,
                                'assigned' => $record->assigned_to === $user->id_user,
                            ];
                        })->toArray()
                    ]
                )
                ->action(function (Document $record, array $data): void {
                    $assignedUser = collect($data['assignments'])
                        ->where('assigned', true)
                        ->first();

                    if ($assignedUser) {
                        $record->assigned_to = $assignedUser['user_id'];
                        $record->save();
                    }

                    $record->assignedUsers()->sync(
                        collect($data['assignments'])->pluck('user_id')
                    );

                    Notification::make()
                        ->success()
                        ->title(__('all.users_assigned_successfully'))
                        ->send();
                }),

            Actions\Action::make('export')
                ->label(__('all.export_journal'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->visible(fn(Document $record) =>
                    $record->isValidated() &&
                    auth()->user()?->role === User::ROLE_ADMIN
                )
                ->action(function (Document $record, DocumentService $documentService) {
                    $export = new DocumentExport($record);
                    return Excel::download($export, 'Journal_of_document_' . $record->nom_fichier . '.xlsx');
                }),
        ];
    }
}
