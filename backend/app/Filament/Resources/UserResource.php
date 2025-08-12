<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('last_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    /* ->required() */
                    ->placeholder('********')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phone_2')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('address')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('postal_code')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('job_title')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\FileUpload::make('avatar_url')
                    ->default(null),
                Forms\Components\DateTimePicker::make('last_login_at'),
                Forms\Components\Select::make('role')
                    ->required()
                    -> options([
                        'admin' => 'Admin',
                        'pharmacien' => 'Pharmacien',
                        'conseiller' => 'Conseiller',
                    ]),
                Forms\Components\DateTimePicker::make('email_verified_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\ImageColumn::make('avatar_url')
                    ->searchable()
                    ->circular() // optionnel, pour un rendu rond
                    ->height(40)
                    ->label('Avatar')
                    ->width(40),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
        
                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }


// À placer dans ta UserResource ou UserResource\Pages\ViewUser
public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
{
    return $infolist
        ->schema([
            \Filament\Infolists\Components\Section::make()
                ->schema([
                    \Filament\Infolists\Components\Grid::make(2)
                        ->schema([
                            // Section informations personnelles
                            \Filament\Infolists\Components\Section::make('Informations personnelles')
                                ->columns(4)
                                ->schema([
                                    \Filament\Infolists\Components\ImageEntry::make('avatar_url')
                                        ->label('Avatar')
                                        ->circular()
                                        ->disk('public') // ou 's3' si tu utilises S3
                                        ->defaultImageUrl(fn() => asset('images/website/user-placeholder.png'))
                                        ->columnSpan(1),
                                    \Filament\Infolists\Components\Grid::make(2)
                                        ->columnSpan(3)
                                        ->columns(3)
                                        ->schema([
                                            \Filament\Infolists\Components\TextEntry::make('first_name')->label('Prénom'),
                                            \Filament\Infolists\Components\TextEntry::make('last_name')->label('Nom'),
                                            \Filament\Infolists\Components\TextEntry::make('job_title')->label('Poste'),
                                            \Filament\Infolists\Components\TextEntry::make('city')->label('Ville'),
                                            \Filament\Infolists\Components\TextEntry::make('postal_code')->label('Code postal'),
                                            \Filament\Infolists\Components\TextEntry::make('country')->label('Pays'),
                                            \Filament\Infolists\Components\TextEntry::make('address')->label('Adresse')->columnSpan(3),
                                        ]),
                                ]),

                            // Section informations de contact
                            \Filament\Infolists\Components\Section::make('Informations de contact')
                                ->columnSpanFull()
                                ->schema([
                                    \Filament\Infolists\Components\Grid::make(2)
                                        ->schema([
                                            \Filament\Infolists\Components\TextEntry::make('phone')->label('Téléphone mobile'),
                                            \Filament\Infolists\Components\TextEntry::make('phone_2')->label('Téléphone bureau'),
                                            \Filament\Infolists\Components\TextEntry::make('email')->label('Email'),
                                        ]),
                                ]),

                            // Section informations initiales
                            \Filament\Infolists\Components\Section::make('Informations initiales')
                                ->columnSpanFull()
                                ->schema([
                                    \Filament\Infolists\Components\Grid::make(2)
                                        ->schema([
                                            \Filament\Infolists\Components\TextEntry::make('role')
                                                ->label('Rôle')
                                                ->badge()
                                                ->formatStateUsing(fn($state) => __($state))
                                                ->color(fn($state) => match ($state) {
                                                    'admin' => 'success',
                                                    'client' => 'info',
                                                    default => 'secondary',
                                                }),
                                            \Filament\Infolists\Components\TextEntry::make('is_active')
                                                ->label('Statut')
                                                ->badge()
                                                ->formatStateUsing(fn($state) => $state ? 'Actif' : 'Inactif')
                                                ->color(fn($state) => $state ? 'success' : 'danger'),
                                        ]),
                                ]),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
}

  public static function canAccess(): bool
{
    $user = auth()->user();
    if (!$user) {
        return false;
    }
    return $user->role === 'admin';
}

}
