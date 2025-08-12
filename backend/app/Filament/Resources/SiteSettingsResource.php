<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingsResource\Pages;
use App\Filament\Resources\SiteSettingsResource\RelationManagers;
use App\Models\SiteSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteSettingsResource extends Resource
{
    protected static ?string $model = SiteSettings::class;

protected static ?string $navigationIcon = 'heroicon-o-cog';
protected static ?string $navigationLabel = 'Paramètres du site';
protected static ?int $navigationSort = 999; // Affiche en dernier
protected static ?string $navigationGroup = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('logo')
                    ->default(null)
                    ->image()
                    ->visibility('public')
                    ->directory('site-settings')

                    ->nullable(),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('telephone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('facebook')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('youtube')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('instagram')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('x')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('whatsapp')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('image_accueil')
                    ->image(),
                Forms\Components\Textarea::make('text_propos')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title_propos')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('img1_propos')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('img2_propos')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('img3_propos')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('img4_propos')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('video_service')
                    ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov', 'video/webm'])
                    ->visibility('public')
                    ->directory('site-settings')
                    ->default(null),
                Forms\Components\Textarea::make('text_service')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title_service')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('text_contact')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title_contact')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                   ->label('logo'),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                
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

    public static function getNavigationGroup(): ?string
    {
        return __('all.settings');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSettings::route('/create'),
            'edit' => Pages\EditSiteSettings::route('/{record}/edit'),
        ];
    }
}
