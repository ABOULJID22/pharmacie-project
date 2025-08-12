<x-filament::page>
    <h1 class="text-xl font-bold mb-4">Document: {{ $record->titre }}</h1>

    @php
         $filePath = $record->file ?? $record->nom_fichier;
        $filename = basename($filePath);
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $documentUrl = url('/documents/' . $filename);
        
    @endphp

    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
        <div class="flex justify-center">
            <img src="{{ $documentUrl }}" alt="Aperçu du document" class="w-full max-w-4xl rounded shadow">
        </div>
    @elseif ($ext === 'pdf')
        <iframe src="{{ $documentUrl }}" width="100%" height="600px" class="border rounded shadow"></iframe>
    @else
        <div class="text-center mt-4">
            <p class="mb-2 text-gray-700">🛈 Aperçu non disponible pour ce type de fichier (<strong>{{ strtoupper($ext) }}</strong>).</p>
            <a href="{{ $documentUrl }}" target="_blank" 
               class="text-blue-600 font-semibold underline hover:text-blue-800 transition">
                📄 Télécharger le fichier
            </a>
        </div>
    @endif

    <div class="mt-8 space-y-2 bg-gray-50 p-4 rounded shadow-sm">
        <p><strong>Type :</strong> {{ $record->type }}</p>
        <p><strong>Taille :</strong> {{ $record->file_size }} Ko</p>
        <p><strong>Statut :</strong> {{ $record->status }}</p>
        <p><strong>Date d’upload :</strong> {{ $record->date_upload }}</p>
    </div>
</x-filament::page>
