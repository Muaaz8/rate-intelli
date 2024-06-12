<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\PendingUsers;
use App\Models\Role;
use Hash;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmailVerification;

class AddUsers extends Component
{
    public $name;
    public $email;
    public $role_id;
    public $password;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:pending_users',
        'role_id' => 'required',
        'password' => 'required',
    ];

    public function render()
    {
        $data = User::with('roles')->where('bank_id', null)->get();
        $roles = Role::all();
        return view('livewire.add-users', ['data'=>$data,'roles' => $roles]);
    }

    public function submitForm()
    {
        $this->validate();
        $p_user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'status' => 1,
            'password' => Hash::make($this->password),
        ]);

        $user_role = Role::find($this->role_id);
        $p_user->roles()->attach($user_role);

        $this->clear();
        $this->render();
    }

    public function delete($id){
        User::find($id)->delete();
        $this->render();
    }

    public function clear()
    {
        $this->name = '';
        $this->email = '';
        $this->role_id = '';
        $this->password = '';
    }
}
