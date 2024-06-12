<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\StandardReportList;
use App\Models\SpecializationRates;
use Livewire\Component;

class CheckRates extends Component
{
    public $selected_metro_area = "";
    public $selected_bank_id = "";

    public $special_selected_metro_area = "";

    public $banks = [];
    public $bank_prices = [];

    public $special_banks = [];
    public $special_bank_prices = [];

    public $update = false;
    public $update_id = "";
    public $current_apy = "";

    public $special_update = false;
    public $special_update_id = "";
    public $special_description = "";
    public $special_apy = "";

    public function render()
    {
        $standard_list =  StandardReportList::get();
        if($this->selected_metro_area){
            $this->banks = Bank::where('cbsa_code',$this->selected_metro_area)->orderBy('name','asc')->get();
        }
        if($this->selected_bank_id){
            $this->bank_prices = BankPrices::BankPricesWithType($this->selected_bank_id);
        }

        if($this->special_selected_metro_area){
            $this->special_banks = Bank::where('cbsa_code',$this->special_selected_metro_area)->pluck('id');
            $this->special_bank_prices = SpecializationRates::join('banks', 'banks.id', '=', 'specialization_rates.bank_id')
            ->whereIn('banks.id', $this->special_banks)
            ->select('specialization_rates.*','banks.name as bank_name')
            // ->whereRaw('specialization_rates.id = (SELECT MAX(id) FROM specialization_rates)')
            ->whereRaw('specialization_rates.created_at = (SELECT MAX(created_at) FROM specialization_rates)')
            ->orderBy('specialization_rates.rate','desc')->get();
        }
        return view('livewire.check-rates',compact('standard_list'));
    }

    public function check($id){
        $bankPrice = BankPrices::find($id);
        $bankPrice->is_checked = 1;
        $bankPrice->save();
    }
    public function edit($id){
        $bankPrice = BankPrices::find($id);
        $this->update = true;
        $this->update_id = $id;
        $this->current_apy = $bankPrice->current_rate;
    }

    public function cancelEdit(){
        $this->update = false;
        $this->update_id = "";
        $this->current_apy = "";
    }

    public function saveEdit(){
        $bankPrice = BankPrices::find($this->update_id);
        $bankPrice->current_rate = $this->current_apy;
        $bankPrice->change = $this->current_apy-$bankPrice->previous_rate;
        $bankPrice->is_checked = 0;
        $bankPrice->save();
        $this->update = false;
        $this->update_id = "";
        $this->current_apy = "";
    }

    public function edit_speical($id){
        $bankPrice = SpecializationRates::find($id);
        $this->special_update = true;
        $this->special_update_id = $id;
        $this->special_description = $bankPrice->description;
        $this->special_apy = $bankPrice->rate;
    }

    public function cancelEdit_speical(){
        $this->special_update = false;
        $this->special_update_id = "";
        $this->special_description = "";
        $this->special_apy = "";
    }

    public function saveEdit_speical(){
        $bankPrice = SpecializationRates::find($this->special_update_id);
        $bankPrice->rate = $this->special_apy;
        $bankPrice->description = $this->special_description;
        $bankPrice->save();
        $this->special_update = false;
        $this->special_update_id = "";
        $this->special_apy = "";
    }
}
