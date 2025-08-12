<div class="min-h-screen p-8 bg-white dark:bg-gray-900 flex flex-col gap-8">

    <!-- Infos audit et rapport -->
    <div class="flex flex-col gap-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                Audit : <span class="text-indigo-600 dark:text-indigo-400">{{ $audit->objet }}</span>
            </h2>
            <div class="flex flex-wrap items-center gap-6 text-base text-gray-600 dark:text-gray-300 mt-2">
                <span><strong>Demandeur :</strong> {{ $audit->demandeur->name }}</span>
                <span><strong>Date :</strong> {{ $audit->date_demande->format('d/m/Y H:i') }}</span>
                <span>
                    <strong>Statut :</strong>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                        @if($audit->statut === 'en_attente') bg-yellow-100 text-yellow-800
                        @elseif($audit->statut === 'en_cours') bg-blue-100 text-blue-800
                        @elseif($audit->statut === 'termine') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $audit->statut)) }}
                    </span>
                </span>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">Rapport</h3>
            <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100 whitespace-pre-line min-h-[120px]">
                {{ $audit->rapport ?? 'Pas de rapport disponible' }}
            </div>
        </div>
    </div>

    <!-- Documents en bas -->
    <div class="w-full flex flex-col gap-4 bg-gray-50 dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-800">
        <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">Documents</h3>
        <div class="flex flex-col gap-3">
            @php
                $allDocuments = collect([$audit->document])->concat($documents)->unique('id_document')->filter();
            @endphp

            @forelse($allDocuments as $document)
                @php
                    $filePath = $document->file_path ?? null;
                    $extension = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
                    $urlView = \App\Filament\Resources\DocumentResource::getUrl('view', ['record' => $document->id_document]);
                @endphp
                <a href="{{ $urlView }}" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-50 dark:hover:bg-indigo-900 transition border border-gray-200 dark:border-gray-700" title="Voir le document {{ $document->nom_fichier ?? '' }}">
                    @include('filament.partials.document-icon', ['extension' => $extension, 'iconClasses' => 'w-8 h-8 flex-shrink-0'])
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-gray-900 dark:text-gray-100 font-medium truncate">{{ $document->nom_fichier ?? 'Document' }}</span>
                        <small class="text-gray-500 dark:text-gray-400">{{ $document->date_upload ? $document->date_upload->format('d/m/Y') : '' }}</small>
                    </div>
                </a>
            @empty
                <span class="text-gray-500">Aucun document</span>
            @endforelse
        </div>
    </div>
</div>