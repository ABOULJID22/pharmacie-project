<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($this->getDocuments() as $document)
                <div class="bg-white shadow rounded-lg p-4 border">
                    <h2 class="text-lg font-semibold mb-2">{{ $document->nom_fichier }}</h2>
                    <p><strong>Type:</strong> {{ $document->type }}</p>
                    <p><strong>Taille:</strong> {{ $document->file_size }} Ko</p>
                    <p><strong>Statut:</strong> <span class="inline-flex px-2 py-1 text-sm font-semibold text-white rounded-full {{ $document->status === 'validé' ? 'bg-green-500' : ($document->status === 'brouillon' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                        {{ $document->status }}
                    </span></p>
                    <p><strong>Uploader:</strong> {{ $document->uploader->name }}</p>

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('filament.admin.resources.documents.edit', ['record' => $document]) }}"
                           class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">Modifier</a>

                        <form method="POST"
                              action="{{ route('filament.admin.resources.documents.destroy', ['record' => $document]) }}"
                              onsubmit="return confirm('Supprimer ce document ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                Supprimer
                            </button>
                        </form>

                        <a href="{{ route('download.document', ['filename' => $document->nom_fichier]) }}"
                           class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                            Télécharger
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>
