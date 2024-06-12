<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\Payment;
use App\Models\BankSelectedCity;
use App\Models\User;
use App\Models\ActivityLog;

class MyProfile extends Component
{
    public $user;
    public $update = false;
    public $customerBank;

    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $title;

    public $ins_name;
    public $ins_phone_number;
    public $ins_website;

    public function mount(){
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name." Viewed their profile.",
        ]);
    }

    public function render()
    {
        $this->user = User::find(auth()->user()->id);
        $id = auth()->user()->bank_id;
        $this->customerBank = CustomerBank::with(['contract'])->findOrFail($id);
        if($this->customerBank->display_reports == "custom"){
            $this->customerBank->selected_banks = CustomPackageBanks::join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->join('states','banks.state_id','states.id')
                ->join('cities','banks.city_id','cities.id')
                ->where('bank_id',$id)
                ->select('banks.*','states.name as state_name','cities.name as city_name')
                ->get();
        }elseif($this->customerBank->display_reports == "state"){
            $this->customerBank->selected_banks = BankSelectedCity::where('bank_id', $this->customerBank->id)
            ->join('banks','bank_selected_city.city_id','banks.cbsa_code')
            ->select('bank_selected_city.*','banks.cbsa_name as city_name')
            ->groupBy('banks.cbsa_code')
            ->get();
        }elseif($this->customerBank->display_reports == "msa"){
            $this->customerBank->custom_banks = CustomPackageBanks::join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
                ->join('states','banks.state_id','states.id')
                ->join('cities','banks.city_id','cities.id')
                ->where('bank_id',$id)
                ->select('banks.*','states.name as state_name','cities.name as city_name')
                ->get();
            $this->customerBank->selected_banks = BankSelectedCity::where('bank_id', $this->customerBank->id)
            ->join('banks','bank_selected_city.city_id','banks.cbsa_code')
            ->select('bank_selected_city.*','banks.cbsa_name as city_name')
            ->groupBy('banks.cbsa_code')
            ->get();
        }
        $this->customerBank->payment = Payment::where('bank_id',$id)->get();

        return view('livewire.my-profile');
    }

    public function edit($id){
        $user = User::find($id);
        $bank = CustomerBank::find($user->bank_id);
        $this->first_name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->title = $user->designation;

        $this->ins_name = $bank->bank_name;
        $this->ins_phone_number = $bank->bank_phone_numebr;
        $this->ins_website = $bank->website;
        $this->update = true;
    }

    public function update(){
        $user = User::find(auth()->user()->id);
        $bank = CustomerBank::find($user->bank_id);


        $user->name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;
        $user->designation = $this->title;
        $user->save();

        $bank->bank_name = $this->ins_name;
        $bank->bank_phone_numebr = $this->ins_phone_number;
        $bank->website = $this->ins_website;
        $bank->save();

        $this->update = false;

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name." Edited their profile.",
        ]);
    }
}
