<div class="p-4 bg-white shadow rounded space-y-4">
    <div class="h-64 overflow-y-auto border p-2 rounded">
        @foreach ($messages as $message)
            <div class="@if($message->id_auteur === auth()->id()) text-right @else text-left @endif">
                <div class="inline-block px-3 py-2 rounded 
                    @if($message->id_auteur === auth()->id()) bg-blue-500 text-white @else bg-gray-200 @endif">
                    <div class="text-sm">
                        {{ $message->contenu }}
                    </div>
                    <div class="text-xs text-gray-600 mt-1">
                        {{ $message->date_envoi->format('H:i') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage" class="flex gap-2">
        <input type="text" wire:model.defer="contenu" class="w-full border rounded px-3 py-1" placeholder="Écris un message...">
        <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Envoyer</button>
    </form>
</div>
