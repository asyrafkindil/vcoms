<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component
{
    public $createUserModal;
    public $editUserModal;
    public $deleteUserModal;
    public $alertModal;

    public $users;

    public $name;
    public $email;
    public $phone;
    public $password;

    public $selected_user;

    protected $rules = [
        'selected_user.name' => 'required',
        'selected_user.email' => 'required|email|unique:users,email',
        'selected_user.phone' => 'required',
    ];

    public function render()
    {
        $this->users = User::role('Admin')->get();
        return view('livewire.user.index');
    }

    public function create()
    {
        $this->createUserModal = true;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
    }

    public function save()
    {
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required'],
            'password' => ['required', 'min:8'],
        ]);

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->password = Hash::make($this->password);
        $user->save();
        $user->assignRole('Admin');

        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->createUserModal = false;
    }

    public function editUser($user_id)
    {
        $this->selected_user = User::find($user_id);
        $this->editUserModal = true;
    }

    public function updateUser()
    {
        $this->validate([
            'selected_user.name' => 'required',
            'selected_user.email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->selected_user->id),],
            'selected_user.phone' => 'required',
        ]);

        if (!empty($this->password)) {
            $this->selected_user->password = Hash::make($this->password);
        }
        $this->selected_user->save();
        $this->editUserModal = false;
    }

    public function deleteUser($user_id)
    {
        $this->selected_user = User::find($user_id);
        $this->deleteUserModal = true;
    }

    public function proceedToDelete()
    {
        $this->selected_user->delete();
        $this->deleteUserModal = false;
    }
}
