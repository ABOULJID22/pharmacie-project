<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as ExcelIOFactory;
use Filament\Tables\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Tables\Columns\SelectColumn;

use Filament\Tables\Columns\ImageColumn;
class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationLabel = 'Documents';
    protected static ?string $pluralLabel = 'Documents';
    protected static ?string $navigationGroup = 'Gestion de fichiers';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('file_path')
                ->label('Document')
                ->disk(config('filesystems.default'))
                ->directory('documents')
                ->storeFileNamesIn('nom_fichier')
                ->acceptedFileTypes([
                    'application/pdf',
                    'application/msword',
                    'image/*',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ])
                ->required()
                ->openable()
                ->downloadable()
                ->maxSize(100240) // 100 Mo
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    return $file->getClientOriginalName();
                })
                ->afterStateUpdated(function ($state, $component, callable $set) {
                    if (!($state instanceof TemporaryUploadedFile)) {
                        return;
                    }

                    $set('nom_fichier', $state->getClientOriginalName());
                    $set('type', strtolower($state->getClientOriginalExtension()));
                    $set('file_size', round($state->getSize() / 1024, 2));

                    // Détecter nombre de pages / feuilles
                    $pagesCount = self::detectDocumentPages($state->getRealPath(), $state->getClientOriginalExtension());
                    $set('pages_count', $pagesCount);
                }),

            Forms\Components\TextInput::make('nom_fichier')
                ->label('Nom du fichier')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('type')
                ->label('Type')
                ->readonly()
                ->helperText('Exemple: pdf, docx, xlsx, jpg...'),

            Forms\Components\TextInput::make('file_size')
                ->label('Taille (en Ko)')
                ->numeric()
                ->readonly(),

            

            Forms\Components\Select::make('status')
                ->label('Statut')
                ->options([
                    'brouillon' => 'Brouillon',
                    'valide' => 'Valide',
                    'archive' => 'Archive',
                ])
                ->default('brouillon')
                ->disabled(fn () => auth()->user()->role !== 'admin'),

            Forms\Components\DateTimePicker::make('date_upload')
                ->label('Date de téléversement')
                ->required()
                ->default(now()),

                Forms\Components\Hidden::make('id_uploader')->default(Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

               Tables\Columns\TextColumn::make('nom_fichier')
                ->label('Aperçu')
                ->formatStateUsing(function ($state, $record) {
                    $url = Storage::disk('public')->url('documents/' . $record->nom_fichier);
                    $ext = strtolower(pathinfo($record->nom_fichier, PATHINFO_EXTENSION));

                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                        // Afficher image preview
                        return '<img src="' . $url . '" alt="Preview" style="max-width:100px; max-height:100px; object-fit:contain;">';
                    }

                    if ($ext === 'pdf') {
                        // Afficher icône PDF cliquable
                        return '<a href="' . $url . '" target="_blank" style="color:#E53E3E; font-weight:bold; text-decoration:none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;vertical-align:middle;" fill="currentColor" viewBox="0 0 24 24"><path d="M6 2h9a2 2 0 0 1 2 2v1h-1V4H6v16h7v-1h1v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Zm9 3v2h2v13H7V5h8Zm-7 4v1h5v-1H8Zm0 3v1h5v-1H8Zm0 3v1h3v-1H8Z"/></svg> PDF</a>';
                    }

                    // Pour les autres fichiers, afficher une icône fichier générique cliquable
                    return '<a href="' . $url . '" target="_blank" style="color:#3182ce; font-weight:bold; text-decoration:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;vertical-align:middle;" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.105.895 2 2 2h12a2 2 0 0 0 2-2V8l-6-6Z"/></svg> Fichier</a>';
                })
                ->html()  // Indique que la sortie est du HTML
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('nom_fichier')->label('Nom')->searchable(),
                Tables\Columns\TextColumn::make('type')->label('Type')->searchable(),
                Tables\Columns\TextColumn::make('file_size')->label('Taille (Ko)')->sortable(),
                Tables\Columns\SelectColumn::make('status')
                        ->label('Statut')
                        ->sortable()
                        ->options([
                            'brouillon' => 'Brouillon',
                            'valide' => 'Valide',
                            'archive' => 'Archive',
                        ])
                        ->disabled(fn () => auth()->user()->role !== 'admin'),
                Tables\Columns\TextColumn::make('date_upload')->label('Date')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('uploader.name')->label('Uploader')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])




            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'brouillon' => 'Brouillon',
                        'valide' => 'Valide',
                        'archive' => 'Archive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()->label('Voir'),
                Tables\Actions\Action::make('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Document $record) {
                        return response()->download(
                            storage_path('app/public/documents/' . $record->nom_fichier)
                        );
                    })
                    ->color('success'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
{
    $query = parent::getEloquentQuery();

    if (auth()->user()->role === 'pharmacien') {
        return $query->where('id_uploader', auth()->id());
    }

    return $query;
}



public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Components\Grid::make(2)
                ->schema([
                    Components\Section::make(__('Détails du document'))
                        ->schema([
                            Components\TextEntry::make('nom_fichier')
                                ->label('Nom du fichier'),
                            Components\TextEntry::make('type')
                                ->label('Type'),
                            Components\TextEntry::make('file_size')
                                ->label('Taille du fichier (en octets)'),
                            Components\TextEntry::make('pages_count')
                                ->label('Nombre de pages'),
                            Components\TextEntry::make('status')
                                ->label('Statut'),
                            Components\TextEntry::make('date_upload')
                                ->label('Date de téléversement')
                                ->dateTime(),
                            Components\TextEntry::make('uploader.name')
                                ->label('Téléversé par')
                                ->placeholder('Non défini'),
                        ])
                        ->columns(2),

                   /*  Components\Section::make(__('Partages'))
                        ->schema([
                            Components\ViewEntry::make('partages')
                                ->view('filament.infolist.entries.partages-documents')
                                ->hiddenLabel()
                                ->state(fn($record) => $record),
                        ]), */
                ]),

            Components\Section::make(__('all.file_preview'))
                ->headerActions([
                    Components\Actions\Action::make('downloadDocument')
                        ->label('all.download_document')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn($record) => $record->file_path)
                        ->color('info')
                        ->openUrlInNewTab(),
                ])
                ->schema([
                    Components\ViewEntry::make('file_path')
                        ->view('filament.infolist.entries.document-preview')
                        ->hiddenLabel(),
                ]),
        ]);
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
            'view' => Pages\ViewDocument::route('/{record}'),
        ];
    }

    /**
     * 🔍 Détecte le nombre de pages ou feuilles d’un document.
     * @param string $filePath Le chemin complet vers le fichier temporaire (local).
     * @param string $extension L’extension du fichier.
     * @return int|null Nombre de pages, feuilles, sections ou null si impossible.
     */
    private static function detectDocumentPages(string $filePath, string $extension): ?int
    {
        $extension = strtolower($extension);

        try {
            if ($extension === 'pdf') {
                $parser = new PdfParser();
                $pdf = $parser->parseFile($filePath);
                return count($pdf->getPages());
            }

            if (in_array($extension, ['doc', 'docx'])) {
                $phpWord = WordIOFactory::load($filePath);
                if (!$phpWord) {
                    return null;
                }
                // Le nombre de sections peut être une approximation du nombre de pages
                return count($phpWord->getSections());
            }

            if (in_array($extension, ['xls', 'xlsx'])) {
                $spreadsheet = ExcelIOFactory::load($filePath);
                if (!$spreadsheet) {
                    return null;
                }
                return count($spreadsheet->getSheetNames());
            }

            // Pour les images ou autres, on ne calcule pas ou pas applicable
            return null;
        } catch (\Throwable $e) {
            // En cas d'erreur, retourner null
            return null;
        }
    }
}
