{{-- filepath: resources/views/filament/resources/audit-resource/view.blade.php --}}
<x-filament::page>
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 rounded shadow p-6 space-y-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Détail de l'audit</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Demandeur</dt>
                <dd class="text-gray-900 dark:text-gray-100">{{ $record->demandeur->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Document audité</dt>
                <dd class="text-gray-900 dark:text-gray-100">{{ $record->document->nom_fichier ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Objet</dt>
                <dd class="text-gray-900 dark:text-gray-100">{{ $record->objet }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Statut</dt>
                <dd>
                    @php
                        $colors = [
                            'en_attente' => 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                            'en_cours' => 'bg-yellow-200 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200',
                            'termine' => 'bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-200',
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded {{ $colors[$record->statut] ?? 'bg-gray-200' }}">
                        {{ ucfirst(str_replace('_', ' ', $record->statut)) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Date de la demande</dt>
                <dd class="text-gray-900 dark:text-gray-100">{{ $record->date_demande?->format('d/m/Y H:i') }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Date de réalisation</dt>
                <dd class="text-gray-900 dark:text-gray-100">{{ $record->date_realisation?->format('d/m/Y H:i') ?? '-' }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="font-semibold text-gray-700 dark:text-gray-300">Rapport</dt>
                <dd class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $record->rapport ?: '-' }}</dd>
            </div>
        </dl>
    </div>
</x-filament::page>