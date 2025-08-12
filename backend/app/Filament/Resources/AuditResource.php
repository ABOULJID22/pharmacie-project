<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditResource\Pages;
use App\Models\Audit;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters;
use Filament\Tables\Actions;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteBulkAction;


class AuditResource extends Resource
{
    protected static ?string $model = Audit::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Gestion des audits';
    protected static ?string $label = 'Audit';
    protected static ?string $pluralLabel = 'Audits';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_demandeur')
                    ->label('Demandeur')
                    ->relationship('demandeur', 'name')
                    ->searchable()
                    ->default(auth()->id())
                    ->required()
                    ->helperText('Sélectionnez le demandeur de l’audit'),

                Forms\Components\Select::make('id_document')
                    ->label('Document audité')
                    ->options(
                            \App\Models\Document::where('id_uploader', auth()->id())->pluck('nom_fichier', 'id_document')
    )                    ->searchable()
                    ->required()
                    ->helperText('Sélectionnez le document concerné par cet audit'),

                Forms\Components\TextInput::make('objet')
                    ->label('Objet de l’audit')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('statut')
                    ->label('Statut')
                    ->options([
                        'en_attente' => 'En attente',
                        'en_cours' => 'En cours',
                        'termine' => 'Terminé',
                    ])
                    ->required()
                    ->helperText('Statut actuel de l’audit'),

                Forms\Components\Textarea::make('rapport')
                    ->label('Rapport')
                    ->rows(6)
                    ->columnSpanFull()
                    ->helperText('Rédigez ici le rapport d’audit (optionnel)'),

                Forms\Components\DateTimePicker::make('date_demande')
                    ->label('Date de la demande')
                    ->default(now())
                    ->required(),

                Forms\Components\DateTimePicker::make('date_realisation')
                    ->label('Date de réalisation')
                    ->nullable()
                    ->disabled(fn () => auth()->user()->role !== 'admin')
                    ->visible(fn () => in_array(auth()->user()->role, ['admin', 'conseiller'])),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('demandeur.name')
                    ->label('Demandeur')
                    ->default(auth()->user()->name)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('document.nom_fichier')
                    ->label('Document audité')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('objet')
                    ->label('Objet')
                    ->searchable()
                    ->limit(30),

Tables\Columns\BadgeColumn::make('statut')
    ->label('Statut')

    ->colors([
        'en_attente' => 'secondary',
        'en_cours' => 'warning',
        'termine' => 'success',
    ])
    ->formatStateUsing(fn (string $state): string => match ($state) {
        'en_attente' => 'En attente',
        'en_cours' => 'En cours',
        'termine' => 'Terminé',
        default => ucfirst($state),
    })
    ->default('en_attente')
    ->sortable(),

                Tables\Columns\TextColumn::make('date_demande')
                    ->label('Date de demande')
                    ->dateTime('d/m/Y H:i')
                    ->default(now())
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_realisation')
                    ->label('Date de réalisation')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->disabled(fn () => auth()->user()->role !== 'admin'),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('statut')
                    ->label('Statut')
                    ->options([
                        'en_attente' => 'En attente',
                        'en_cours' => 'En cours',
                        'termine' => 'Terminé',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('date_demande', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Ajoute ici un RelationManager si besoin
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAudits::route('/'),
            'create' => Pages\CreateAudit::route('/create'),
            'edit' => Pages\EditAudit::route('/{record}/edit'),
            'view' => Pages\ViewAudit::route('/{record}'),
        ];
    }

    

public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();

    // Admins et conseillers peuvent tout voir
    if (in_array(auth()->user()->role, ['admin', 'conseiller'])) {
        return $query;
    }

    // Les autres voient uniquement les audits où ils sont demandeurs
    return $query->where('id_demandeur', auth()->id());
}

}