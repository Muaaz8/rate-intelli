<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CustomerBank;
use App\Models\BankSelectedCity;
use App\Models\CustomPackageBanks;
use App\Models\Bank;
use App\Models\State;
use App\Models\BankPrices;
use App\Models\RateType;
use App\Models\Filter;
use App\Models\ActivityLog;
use DB;
use Auth;

class HistoricReport extends Component
{
    public $selected_date = "";
    public $user;
    public $bank;
    public $banks_list;
    public $msa_code;
    public $state_id;
    public $selected_custom_filter;

    public function mount()
    {
        $this->user = auth()->user();
        $this->bank = CustomerBank::where('id', $this->user->bank_id)->first();
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name." Viewed Historic Report.",
        ]);
    }

    public function render()
    {
        $dates = $this->getDates();
        $msa_codes = $this->getmsacodes();
        $states = $this->getstates();
        $custom_filters = Filter::where('user_id',auth()->user()->id)->get();
        if($this->selected_date != ""){
            $rt = RateType::orderby('display_order')->get();
            foreach ($rt as $key => $value) {
                $data = BankPrices::historic_report($value->id,$this->selected_date,$this->banks_list,$this->msa_code);
                $value->data = $data;
            }
            return view('livewire.historic-report', ['custom_filters'=>$custom_filters,'rate_type'=>$rt,'msa_codes'=>$msa_codes,'dates'=>$dates,'states'=>$states]);
        }else{
            return view('livewire.historic-report', compact('custom_filters','dates','msa_codes','states'));
        }
    }

    protected function getDates()
    {
        if (!$this->bank) {
            return [];
        }
        // if($this->selected_custom_filter && $this->selected_custom_filter != "all"){
        //     if($this->selected_custom_filter < 1000){
        //         $filter = Filter::find($this->selected_custom_filter);
        //         $banks = unserialize($filter->bank_id);
        //         $this->msa_code = "";
        //     }elseif($this->selected_custom_filter == "custom"){
        //         $banks = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
        //             ->whereIn('banks.bank_type_id',$this->selected_bank_type)
        //             ->where('custom_package_banks.bank_id',auth()->user()->bank_id)
        //             ->pluck('customer_selected_bank_id')->toArray();
        //         $this->msa_code = "";
        //     }else{
        //         $this->msa_code = $this->selected_custom_filter;
        //         $cities = BankSelectedCity::where('bank_id', Auth::user()->bank_id)->where('city_id',$this->msa_code)->pluck('city_id')->toArray();
        //         $standard_banks_id = Bank::where('cbsa_code', $cities)->whereIn('banks.bank_type_id',$this->selected_bank_type)->pluck('id')->toArray();
        //         $banks = $standard_banks_id;
        //     }
        // }else{
        //     $this->msa_code = "";
        //     $banks = "";
        // }


        if($this->selected_custom_filter && $this->selected_custom_filter != "all"){
            if($this->selected_custom_filter < 1000){
                $filter = Filter::find($this->selected_custom_filter);
                $this->banks_list = unserialize($filter->bank_id);
                $this->msa_code = "";
            }elseif($this->selected_custom_filter == "custom"){
                $this->banks_list = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                    ->where('custom_package_banks.bank_id',auth()->user()->bank_id)
                    ->pluck('customer_selected_bank_id')->toArray();
                $this->msa_code = "";
            }else{
                $this->msa_code = $this->selected_custom_filter;
                $cities = BankSelectedCity::where('bank_id', Auth::user()->bank_id)->where('city_id',$this->msa_code)->pluck('city_id')->toArray();
                $standard_banks_id = Bank::where('cbsa_code', $cities)->pluck('id')->toArray();
                $this->banks_list = $standard_banks_id;
            }
            $dates = BankPrices::whereIn('bank_id', $this->banks_list)->groupBy('created_at')->select('created_at')->get();
        }else{
                $this->banks_list = "";
        }
        if($this->banks_list == ""){
            if ($this->bank->display_reports == "state") {
                if(!empty($this->msa_code) && $this->msa_code != "all" ){
                    $cities = BankSelectedCity::where('bank_id', $this->user->bank_id)->where('city_id',$this->msa_code)->pluck('city_id')->toArray();
                }else{
                    $cities = BankSelectedCity::where('bank_id', $this->user->bank_id)->pluck('city_id')->toArray();
                }
                $this->banks_list = Bank::whereIn('cbsa_code', $cities)->pluck('id')->toArray();
                $dates = BankPrices::whereIn('bank_id', $this->banks_list)->groupBy('created_at')->select('created_at')->get();
            } elseif ($this->bank->display_reports == "custom") {
                if($this->state_id != ""){
                    $this->banks_list = CustomPackageBanks::where('bank_id',$this->bank->id)
                    ->join('banks', 'custom_package_banks.customer_selected_bank_id', '=', 'banks.id')
                    ->where('banks.state_id',$this->state_id)
                    ->pluck('customer_selected_bank_id')->toArray();
                }else{
                    $this->banks_list = CustomPackageBanks::where('bank_id',$this->bank->id)->pluck('customer_selected_bank_id')->toArray();
                }
                $dates = BankPrices::whereIn('bank_id', $this->banks_list)->groupBy('created_at')->select('created_at')->get();
            } elseif ($this->bank->display_reports == "msa") {
                if(!empty($this->msa_code) && $this->msa_code != "all" ){
                    $cities = BankSelectedCity::where('bank_id', $this->user->bank_id)->where('city_id',$this->msa_code)->pluck('city_id')->toArray();
                }else{
                    $cities = BankSelectedCity::where('bank_id', $this->user->bank_id)->pluck('city_id')->toArray();
                }
                $standard_bank_list = Bank::whereIn('cbsa_code', $cities)->pluck('id')->toArray();
                $custom_bank_list = CustomPackageBanks::where('bank_id',$this->bank->id)
                ->join('banks', 'custom_package_banks.customer_selected_bank_id', '=', 'banks.id')
                ->where('banks.state_id',$this->state_id)
                ->pluck('customer_selected_bank_id')->toArray();
                $this->banks_list = array_merge($standard_bank_list,$custom_bank_list);
                $dates = BankPrices::whereIn('bank_id', $this->banks_list)->groupBy('created_at')->select('created_at')->get();
            }
        }

        $formattedDates = $dates->map(function ($item) {
            $date = date('Y-m-d', strtotime($item->created_at));
            $formattedDate = date('F dS, Y', strtotime($item->created_at));
            return [
                'original' => $date,
                'formatted' => $formattedDate,
            ];
        });

        return $formattedDates->unique()->values()->all();
    }

    public function getmsacodes()
    {
        if($this->bank->display_reports == 'state'){
            $banks_city = DB::table('bank_selected_city')->where('bank_id',$this->user->bank_id)->pluck('city_id')->toArray();
            $msa_codes = Bank::with('cities')->whereIn('cbsa_code',$banks_city)->groupBy('cbsa_code')->get();
            return $msa_codes;
        }elseif($this->bank->display_reports == 'custom'){
            $msa_codes = Bank::with('cities')->groupBy('city_id')->get();
            return $msa_codes;
        }elseif($this->bank->display_reports == 'msa'){
            $banks_city = DB::table('bank_selected_city')->where('bank_id',$this->user->bank_id)->pluck('city_id')->toArray();
            $msa_codes = Bank::with('cities')->whereIn('cbsa_code',$banks_city)->groupBy('cbsa_code')->get();
            return $msa_codes;
        }
    }

    public function msa_code_changed(){
        $this->selected_date = "";
    }

    public function getstates()
    {
        $selected_banks = CustomPackageBanks::where('bank_id',auth()->user()->bank_id)
        ->join('banks', 'custom_package_banks.customer_selected_bank_id', '=', 'banks.id')
        ->pluck('banks.state_id')->toArray();
        $states = State::whereIn('id',$selected_banks)->get();
        // $states = Bank::join('states', 'banks.state_id', '=', 'states.id')
        // ->select('states.*')
        // ->groupBy('states.id')
        // ->get();
        return $states;
    }
}
