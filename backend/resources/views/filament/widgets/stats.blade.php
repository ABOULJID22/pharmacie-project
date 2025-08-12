{{-- filepath: resources/views/filament/widgets/stats.blade.php --}}
<x-filament::widget>
    <x-filament::card>
        <div class="flex flex-col items-center justify-center space-y-2">
            <div class="text-2xl font-bold">
                Utilisateurs inscrits
            </div>
            <div class="text-5xl font-extrabold text-primary-600">
                {{ $users }}
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>