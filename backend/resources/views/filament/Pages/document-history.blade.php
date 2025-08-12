<x-filament::page>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($this->documents as $document)
            @php
                $filePath = $document->file_path ?? null;
                $extension = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
                $fileName = $filePath ? basename($filePath) : null;
                $fileUrl = $fileName ? url('/documents/' . $fileName) : null;
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex flex-col h-full space-y-4">
                
                {{-- Aperçu avec icône "voir" --}}
                <div class="relative flex justify-center items-center h-40 w-full bg-gray-100 dark:bg-gray-900 rounded overflow-hidden">
                    
                    {{-- Icône "voir" en haut à droite --}}
                    <a href="{{ \App\Filament\Resources\DocumentResource::getUrl('view', ['record' => $document->id_document]) }}"
                       class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-primary-600 transition"
                       title="Voir le document">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>

                    {{-- Aperçu du fichier --}}
                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ $fileUrl }}" alt="Aperçu" class="max-h-full max-w-full object-contain rounded" />
                    @elseif ($extension === 'pdf')
                        <embed src="{{ $fileUrl }}" type="application/pdf" class="w-full h-full rounded" />
                    @elseif (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                        <iframe 
                            src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" 
                            width="100%" 
                            height="160" 
                            frameborder="0" 
                            class="rounded">
                        </iframe>
                    @else
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                        </svg>
                    @endif
                </div>

                {{-- Infos : date et statut uniquement --}}
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    <div>Ajouté le : {{ $document->date_upload->format('d/m/Y H:i') }}</div>
                    <div>Statut : <span class="font-semibold">{{ ucfirst($document->status) }}</span></div>
                </div>

                {{-- SUPPRESSION DU BOUTON "Voir le document" --}}
            </div>
        @endforeach
    </div>
</x-filament::page>
