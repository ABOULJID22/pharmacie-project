<?php

namespace App\Livewire;

use App\Models\FilsDiscussions;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FilsMessages extends Component
{
    use WithFileUploads;

    public ?string $message = '';
    public $image = null;
    public $fils;
    protected $listeners = ['refreshMessages' => '$refresh'];

    public function mount(FilsDiscussions $fils)
    {
        $this->fils = $fils;
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'nullable|string|max:65535',
            'image' => 'nullable|image|max:5120'
        ]);

        $path = null;
        if ($this->image) {
            $path = $this->image->store('messages/images', 'public');
        }

        $msg = new Message([
            'message' => strip_tags(trim($this->message)),
            'user_id' => auth()->id(),
            'id_auteur' => auth()->id(), // ✅ Correction ici
            'image_path' => $path
        ]);

        $this->fils->messages()->save($msg);

        $this->message = '';
        $this->image = null;

        $this->dispatch('refreshMessages');
    }

    public function isResolved()
    {
        return $this->fils->status === 'resolved';
    }

    public function render()
    {
        $messages = $this->fils->messages()->with('user')->latest()->get();

        return view('livewire.fils-messages', [
            'messages' => $messages
        ]);
    }
}
