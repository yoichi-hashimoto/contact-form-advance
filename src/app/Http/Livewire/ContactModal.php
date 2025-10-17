<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;

class ContactModal extends Component
{
    
    public bool $open = false;
    public ?Contact $contact = null;

    protected $listeners = [
        'openModal' => 'open',
    ];

    public function open(int $id):void
    {
        $this->contact = Contact::FindOrFail($id);
        $this->open = true;
    }

    public function close():void
    {
        $this->open = false;
    }

    public function delete():void
    {
        if ($this->contact) {
            $this->contact->delete();
            $this->close();
        }
        $this->close();
        session()->flash('success', '削除しました。');
    }

    public function render()
    {
        return view('livewire.contact-modal');
    }
}
