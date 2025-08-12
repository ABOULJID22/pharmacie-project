<div> 
    @php
        $filePath = $getRecord()->file_path;
        $fileUrl = $filePath ? Storage::url($filePath) : null;
        $extension = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
    @endphp

    @if ($filePath && Storage::exists($filePath))
        @if ($extension === 'pdf')
            <div class="flex justify-center">
                <iframe src="{{ url('/documents/' . basename($filePath)) }}" width="100%" height="800px" style="border: none;" allowfullscreen></iframe>
            </div>
        @elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
            <div class="flex justify-center">

<img src="{{ url('/documents/' . basename($filePath)) }}" alt="Document preview" class="max-w-full h-auto" />            </div>
        @elseif (in_array($extension, ['doc', 'docx', 'xls', 'xlsx']))
            <div class="flex flex-col items-center justify-center space-y-4 p-8 bg-yellow-100 rounded-md">
                <p class="text-lg font-semibold text-yellow-800">
                    Aperçu impossible pour ce type de fichier ({{ strtoupper($extension) }}).
                </p>
                <a href="{{ $fileUrl }}" download
                   class="px-6 py-3 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
                    Télécharger le fichier
                </a>
            </div>
        @else
            <div class="flex flex-col items-center justify-center space-y-4 p-8 bg-gray-100 rounded-md">
                <p class="text-lg text-gray-600">
                    Aperçu non disponible pour ce type de fichier ({{ strtoupper($extension) }}).
                </p>
                <a href="{{ $fileUrl }}" download
                   class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Télécharger le fichier
                </a>
            </div>
        @endif
    @else
        <div class="flex items-center justify-center">
            <div class="w-full h-[800px] dark:bg-gray-800 bg-gray-50 rounded-lg flex flex-col items-center justify-center space-y-4">
                <svg class="w-24 h-24 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-4xl font-bold text-gray-300 dark:text-gray-600">404</div>
                <p class="text-gray-400 dark:text-gray-500">Fichier introuvable ou supprimé.</p>
            </div>
        </div>
    @endif
</div>
