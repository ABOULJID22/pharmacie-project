<div class="flex flex-col h-[600px] bg-white dark:bg-gray-800 rounded-lg shadow-sm">
    <!-- Messages List -->
    <div class="flex-1 p-4 space-y-4 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600"
        id="messages-container">
        @foreach ($messages as $message)
            <div class="flex flex-col space-y-2 {{ $message->user_id === auth()->id() ? 'ml-auto' : '' }} max-w-[80%]">
                <!-- Main Message -->
                <div class="flex items-start gap-3 {{ $message->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                    <div class="flex-shrink-0">
                        <div
                            class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-gray-700 bg-gray-100 rounded-full shadow-sm dark:text-gray-300 dark:bg-gray-700">
                            {{ strtoupper(substr($message->user?->name ?? __('all.deleted_user'), 0, 2)) }}
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div
                            class="p-3 {{ $message->user_id === auth()->id()
                                ? 'bg-[#0084ff] text-white rounded-[18px] rounded-tr-[4px]'
                                : 'bg-[#f0f0f0] dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-[18px] rounded-tl-[4px]' }} shadow-sm hover:shadow-md transition-shadow">
                            <p class="text-sm whitespace-pre-line">{{ $message->message }}</p>
                            @if ($message->image_path)
                                <img src="{{ $message->Image_url }}" alt="Message attachment"
                                    class="object-cover mt-2 rounded-lg max-h-48">
                            @endif
                        </div>
                        <div
                            class="flex items-center gap-4 mt-1 {{ $message->user_id === auth()->id() ? 'justify-end' : '' }}">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $message->user?->name ?? __('all.deleted_user') }} •
                                {{ $message->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Message Input -->
    <div class="p-4 bg-gray-100 border-t border-gray-200 rounded-b-lg dark:bg-gray-900 dark:border-gray-700">
        @if ($this->isResolved())
            <div class="text-sm text-center text-gray-500 dark:text-gray-400">
                {{ __('all.resolved_claim_message') }}
            </div>
        @else
            <div class="flex items-end gap-2">
                <div class="flex-1 my-auto">
                    <textarea wire:model="message" rows="1"
                        class="w-full text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full shadow-sm hover:border-gray-300 dark:hover:border-gray-600 focus:border-[#0084ff] focus:ring-1 focus:ring-[#0084ff] transition-colors"
                        placeholder="{{ __('all.type_your_message') }}"
                        @keydown.enter.prevent.stop="$event.shiftKey || $wire.sendMessage()"
                        @keydown.enter.shift.prevent.stop="$event.target.value += '\n'"></textarea>
                </div>
                <div class="flex gap-2 my-auto">
                    <label class="cursor-pointer">
                        <input type="file" wire:model="image" class="hidden" accept="image/*">
                        <div
                            class="p-2 transition-all border border-gray-200 dark:border-gray-700 rounded-full hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-[#0084ff]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </label>
                    <button wire:click='sendMessage' type="button"
                        class="p-2 transition-all border border-gray-200 dark:border-gray-700 rounded-full hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-[#0084ff] focus:outline-none focus:ring-2 focus:ring-[#0084ff] focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>
            </div>
            @if ($image)
                <div class="relative mt-2 w-fit">
                    <img src="{{ $image->temporaryUrl() }}" class="object-cover h-20 rounded-lg" />
                    <button wire:click="$set('image', null)" type="button"
                        class="absolute p-1 text-gray-600 bg-white rounded-full shadow-sm dark:text-gray-300 dark:bg-gray-800 -top-2 -right-2 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
        @endif
    </div>
</div>
@script
    <script>
        const container = document.getElementById('messages-container');

        const scrollToBottom = () => {
            if (container) {
                setTimeout(() => {
                    container.scrollTo({
                        top: container.scrollHeight
                    });
                }, 100);
            }
        };

        scrollToBottom();
        $wire.on('refreshMessages', () => {
            scrollToBottom();
        });
    </script>
@endscript
