<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CustomerBank;
use App\Models\BankSelectedCity;
use App\Models\CustomPackageBanks;
use App\Models\Bank;
use App\Models\Filter;

class CustomizeFilters extends Component
{

    public $name;
    public $bank_list;
    public $bank;
    public $all_banks = [];

    public $custom_banks = [];
    public $selected_banks_name = [];
    public $selectedItems = [];
    public $selectedbanks = [];

    public $update = false;
    public $update_id;

    public function mount(){
        $this->bank = CustomerBank::where('id', auth()->user()->bank_id)->first();
    }

    public function render()
    {
        $data = Filter::where('user_id',auth()->user()->id)->get();
        foreach ($data as $key => $dt) {
            $dt->bank_id = unserialize($dt->bank_id);
            $dt->banks = Bank::whereIn('id',$dt->bank_id)->orderBy('name','asc')->pluck('name');
        }
        $this->bank_list();
        return view('livewire.customize-filters',compact('data'));
    }

    public function bank_list(){
        if ($this->bank->display_reports == "custom") {
            $this->banks_list = CustomPackageBanks::where('bank_id',$this->bank->id)->pluck('customer_selected_bank_id')->toArray();
        } elseif ($this->bank->display_reports == "msa") {
            // $cities = BankSelectedCity::where('bank_id', $this->bank->id)->pluck('city_id')->toArray();
            // $standard_bank_list = Bank::whereIn('cbsa_code', $cities)->pluck('id')->toArray();
            $custom_bank_list = CustomPackageBanks::where('bank_id',$this->bank->id)->pluck('customer_selected_bank_id')->toArray();
            $this->banks_list = $custom_bank_list;
        }
        $this->all_banks = Bank::whereIn('id',$this->banks_list)->orderBy('name','asc')->get();
    }

    public function save_banks(){
        $this->custom_banks = [];
        $this->selected_banks_name = [];
        foreach($this->selectedItems as $id){
            if (in_array($id, $this->custom_banks)) {
                unset($this->custom_banks[array_search($id, $this->custom_banks)]);
                $bank_name_now = Bank::with('states','cities')->where('id',$id)->first()->toArray();
                foreach ($this->selected_banks_name as $index => $item) {
                    if ($item['name'] == $bank_name_now['name']) {
                        $key = $index;
                        break;
                    }
                }
                unset($this->selected_banks_name[$key]);
                $this->selected_banks_name = array_values($this->selected_banks_name);
            } else {
                array_push($this->custom_banks, $id);
                $bank_name_now = Bank::with('states','cities')->where('id',$id)->first()->toArray();
                array_push($this->selected_banks_name,$bank_name_now);
                usort($this->selected_banks_name, function($a, $b) {
                    return strcmp($a["name"], $b["name"]);
                });
            }
            foreach ($this->all_banks as $bank) {
                array_push($this->selectedbanks, $bank->id);
            }
        }
    }

    public function submitForm(){
        if($this->name != ""){
            if(count($this->custom_banks) != 0){
                Filter::create([
                    'user_id' => auth()->user()->id,
                    'state_id' => $this->name,
                    'bank_id' => serialize($this->custom_banks),
                ]);
                $this->clear();
                $this->addError('success', 'Filter Saved Successfully.');
            }else{
                $this->addError('bank', 'Select atleast 1 Bank.');
            }
        }else{
            $this->addError('name', 'Name cannot be Null.');
        }
    }

    public function edit($id){
        $this->update_id = $id;
        $editFilter = Filter::find($id);
        $this->name = $editFilter->state_id;
        $this->selectedItems = unserialize($editFilter->bank_id);
        foreach ($this->selectedItems as $key => $value) {
            $bank_name_now = Bank::with('states','cities')->where('id',$value)->first()->toArray();
            array_push($this->selected_banks_name,$bank_name_now);
            # code...
        }
        usort($this->selected_banks_name, function($a, $b) {
            return strcmp($a["name"], $b["name"]);
        });
        $this->update = true;
    }

    public function updateForm(){
        if($this->update_id){
            if($this->name != ""){
                if(count($this->custom_banks) != 0){
                    Filter::find($this->update_id)->update([
                        'user_id' => auth()->user()->id,
                        'state_id' => $this->name,
                        'bank_id' => serialize($this->custom_banks),
                    ]);
                    $this->clear();
                    $this->addError('success', 'Filter Saved Successfully.');
                }else{
                    $this->addError('bank', 'Select atleast 1 Bank.');
                }
            }else{
                $this->addError('name', 'Name cannot be Null.');
            }
        }
    }

    public function delete($id){
        Filter::find($id)->delete();
    }

    public function clear(){
        $this->name = "";
        $this->selectedbanks = [];
        $this->selected_banks_name = [];
        $this->custom_banks = [];
        $this->selectedItems = [];
        $this->update = false;
        $this->resetErrorBag();
    }
}
