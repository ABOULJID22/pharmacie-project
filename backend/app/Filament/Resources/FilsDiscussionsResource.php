<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FilsDiscussionsResource\Pages;
use App\Filament\Resources\FilsDiscussionsResource\RelationManagers;
use App\Models\FilsDiscussions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// use App\Enums\FilsDiscussionsStatus;  <-- supprimé

use Illuminate\Support\Facades\Auth;


class FilsDiscussionsResource extends Resource
{
    protected static ?string $model = FilsDiscussions::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sujet')
                    ->label('Sujet')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('id_createur')
                    ->label('Créateur')
                    ->relationship('createur', 'name')
                    ->required(),

                Forms\Components\Select::make('id_participant')
                    ->label('Participant')
                    ->relationship('participant', 'name')
                    ->required(),

                Forms\Components\DateTimePicker::make('date_creation')
                    ->label('Date de création')
                    ->default(now())
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('id_fils')->label('ID')->sortable(),
                 Tables\Columns\TextColumn::make('sujet')->label('Sujet')->searchable()->sortable(),
                 Tables\Columns\TextColumn::make('createur.name')->label('Créateur')->sortable(),
                 Tables\Columns\TextColumn::make('participant.name')->label('Participant')->sortable(),
                 Tables\Columns\TextColumn::make('date_creation')->label('Date de création')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button(),

                Tables\Actions\Action::make('messages')
                    ->label(__('messages'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->modalContent(fn(FilsDiscussions $record) => view('filament.resources.fils-resource.fils-messages', [
                        'ownerRecord' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalWidth('6xl')
                    ->button(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('progress')
                        ->label(__('all.mark_in_progress'))
                        ->icon('heroicon-o-play')
                        ->color('info')
                        ->action(fn(FilsDiscussions $record) => $record->markInProgress())
                        ->visible(
                            fn(FilsDiscussions $record) =>
                                $record->status !== 'resolved' &&
                                $record->status !== 'in_progress'
                        ),

                    Tables\Actions\Action::make('resolve')
                        ->label(__('all.resolve'))
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->form([
                            Forms\Components\Textarea::make('resolution_notes')
                                ->label(__('all.resolution_notes'))
                                ->required()
                                ->maxLength(65535),
                        ])
                        ->action(function (FilsDiscussions $record, array $data): void {
                            $record->resolve(auth()->user(), $data['resolution_notes']);
                        })
                        ->visible(fn(FilsDiscussions $record) => !$record->isResolved()),

                    Tables\Actions\EditAction::make(),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilsDiscussions::route('/'),
            'create' => Pages\CreateFilsDiscussions::route('/create'),
            'edit' => Pages\EditFilsDiscussions::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
{
    $userId = Auth::id();

    return parent::getEloquentQuery()
        ->with(['createur', 'participant'])
        ->where(function (Builder $query) use ($userId) {
            $query->where('id_createur', $userId)
                  ->orWhere('id_participant', $userId);
        });
}

}
