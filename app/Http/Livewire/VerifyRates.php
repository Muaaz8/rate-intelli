<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\StandardReportList;
use App\Models\RateType;
use Livewire\Component;

class VerifyRates extends Component
{
    public $selected_metro_area = "";
    public $data = [];

    public function render()
    {
        $standard_list =  StandardReportList::get();
        if($this->selected_metro_area){
            $rate_types = RateType::orderby('display_order')->get();
            $banks = Bank::where('cbsa_code',$this->selected_metro_area)->pluck('id');

            $this->data = BankPrices::select('bank_prices.*', 'banks.name as bank_name','banks.cbsa_name as cbsa_name','rate_types.name as rate_type_name')
                ->join('banks', 'bank_prices.bank_id', 'banks.id')
                ->join('rate_types', 'bank_prices.rate_type_id', '=', 'rate_types.id')
                ->whereIn('bank_prices.created_at', function ($query) use ($banks) {
                    $query->selectRaw('MAX(created_at)')
                        ->from('bank_prices')
                        ->where('is_checked', 0)
                        ->whereIn('bank_id', $banks);
                })
                ->where('is_checked', 0)
                ->whereIn('bank_id', $banks)
                ->orderBy('current_rate', 'DESC')
                ->get();
        }
        // dd($this->data);
        return view('livewire.verify-rates',compact('standard_list'));
    }

    public function check($id){
        $bankPrice = BankPrices::find($id);
        $bankPrice->is_checked = 1;
        $bankPrice->save();
    }
}
