<?php

namespace App\Http\Livewire\Customer;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public $users;

    public function render()
    {
        $this->users = User::role(['Customer'])->get();
        return view('livewire.customer.index');
    }
}
