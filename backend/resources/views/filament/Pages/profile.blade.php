<x-filament::page>
    <div class="max-w-xl mx-auto rounded shadow p-6 space-y-6 bg-white dark:bg-gray-900 transition-colors">
        <div class="flex items-center space-x-4">
            <img src="{{ $user->avatar_url ?? asset('images/website/user-placeholder.png') }}"
                 class="w-20 h-20 rounded-full object-cover border border-gray-200 dark:border-gray-700" alt="Avatar">
            <div>
                <div class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $user->first_name }} {{ $user->last_name }}
                </div>
                <div class="text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                <div class="text-sm text-gray-400 dark:text-gray-500">{{ ucfirst($user->role) }}</div>
            </div>
        </div>
        <div>
            <p><strong class="text-gray-700 dark:text-gray-300">Ville :</strong> <span class="text-gray-800 dark:text-gray-200">{{ $user->city }}</span></p>
            <p><strong class="text-gray-700 dark:text-gray-300">Téléphone :</strong> <span class="text-gray-800 dark:text-gray-200">{{ $user->phone }}</span></p>
            <p><strong class="text-gray-700 dark:text-gray-300">Adresse :</strong> <span class="text-gray-800 dark:text-gray-200">{{ $user->address }}</span></p>
            <p><strong class="text-gray-700 dark:text-gray-300">Statut :</strong>
                <span class="{{ $user->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </p>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Profil professionnel</h2>
            <p><strong class="text-gray-700 dark:text-gray-300">Poste :</strong> <span class="text-gray-800 dark:text-gray-200">{{ $user->job_title ?? 'Non renseigné' }}</span></p>
            <p><strong class="text-gray-700 dark:text-gray-300">Entreprise :</strong> <span class="text-gray-800 dark:text-gray-200">{{ $user->company ?? 'Non renseignée' }}</span></p>
            <p><strong class="text-gray-700 dark:text-gray-300">Bio :</strong> <span class="text-gray-800 dark:text-gray-200">{{ $user->bio ?? 'Aucune biographie.' }}</span></p>
        </div>
        <div class="flex justify-end">
            <button
                x-data
                x-on:click="$store.darkMode.toggle()"
                class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 transition"
                type="button"
            >
                {{ __('Basculer le mode sombre') }}
            </button>
        </div>
    </div>
</x-filament::page>