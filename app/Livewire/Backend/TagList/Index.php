<?php

namespace App\Livewire\Backend\TagList;

use App\Models\TagList;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public string $message = '';

    public int $actionId;

    public string $search = '';

    public function render(): View
    {
        $list = TagList::where('name', 'like', '%'.$this->search.'%')->paginate(10);

        return view('livewire.backend.tag-list.index', ['list' => $list])->layout('layouts.admin');
    }
}
