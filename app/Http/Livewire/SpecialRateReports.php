<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SpecializationRates;
use DB;
use Auth;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\BankSelectedCity;
use App\Models\State;
use App\Models\Cities;
use App\Models\Filter;
use App\Models\ActivityLog;
use PDF;

class SpecialRateReports extends Component
{
    public $bank_state_filter = '';
    public $bank_city_filter = '';
    public $selected_bank = '';
    public $selected_custom_filter;

    public function mount(){
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name." Viewed Current Specials Report.",
        ]);
    }
    public function render()
    {
        $customer_bank = CustomerBank::find(Auth::user()->bank_id);
        $custom_filters = Filter::where('user_id',auth()->user()->id)->get();
        if($this->selected_custom_filter && $this->selected_custom_filter != "all"){
            if($this->selected_custom_filter < 1000){
                $filter = Filter::find($this->selected_custom_filter);
                $bank_list = unserialize($filter->bank_id);
                $this->bank_city_filter = "";
            }elseif($this->selected_custom_filter == "custom"){
                $bank_list = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                    ->where('custom_package_banks.bank_id',Auth::user()->bank_id)
                    ->pluck('customer_selected_bank_id')->toArray();
                    $this->bank_city_filter = "";
            }else{
                $this->bank_city_filter = $this->selected_custom_filter;
                $bank_list = "";
            }
        }else{
            $bank_list = "";
        }
        if($bank_list == ""){
            if($customer_bank->display_reports == "state"){
                if($this->bank_city_filter != ""){
                    $city_id = BankSelectedCity::where('bank_id',Auth::user()->bank_id)->where('city_id',$this->bank_city_filter)->pluck('city_id');
                    $bank_ids = Bank::whereIn('cbsa_code',$city_id)->pluck('id');
                }else{
                    $city_id = BankSelectedCity::where('bank_id',Auth::user()->bank_id)->pluck('city_id');
                    $bank_ids = Bank::whereIn('cbsa_code',$city_id)->pluck('id');
                }
            }elseif($customer_bank->display_reports == "custom"){
                $bank_ids = CustomPackageBanks::where('bank_id',Auth::user()->bank_id)->pluck('customer_selected_bank_id');
            }elseif($customer_bank->display_reports == "msa"){
                if($this->bank_city_filter == ""){
                    $cities = BankSelectedCity::where('bank_id', Auth::user()->bank_id)->pluck('city_id')->toArray();
                    $custom_banks_id = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                        ->where('custom_package_banks.bank_id',Auth::user()->bank_id)
                        ->pluck('customer_selected_bank_id')->toArray();
                    $standard_banks_id = Bank::where('cbsa_code', $cities)->pluck('id')->toArray();
                    $bank_ids = array_merge($standard_banks_id,$custom_banks_id);
                }else{
                    $cities = BankSelectedCity::where('bank_id', Auth::user()->bank_id)->where('city_id',$this->bank_city_filter)->pluck('city_id')->toArray();
                    $standard_banks_id = Bank::where('cbsa_code', $cities)->pluck('id')->toArray();
                    $custom_banks_id = [];
                    $bank_ids = array_merge($standard_banks_id,$custom_banks_id);
                }
            }
        }else{
            $bank_ids = $bank_list;
        }

        $specialization_rates = SpecializationRates::join('banks', 'banks.id', '=', 'specialization_rates.bank_id')
            ->whereIn('banks.id', $bank_ids)
            ->select('specialization_rates.*')
            // ->whereRaw('specialization_rates.id = (SELECT MAX(id) FROM specialization_rates)')
            ->whereRaw('specialization_rates.created_at = (SELECT MAX(created_at) FROM specialization_rates)')
            ->orderBy('specialization_rates.rate','desc');

        if(!empty($this->bank_state_filter) && $this->bank_state_filter != 'all'){
            $specialization_rates->where('banks.state_id',$this->bank_state_filter);
        }
        if(!empty($this->bank_city_filter)){
            $specialization_rates->where('banks.cbsa_code',$this->bank_city_filter);
        }
        $specialization_rates = $specialization_rates->get();
        $banks = SpecializationRates::join('banks', 'banks.id', '=', 'specialization_rates.bank_id')
        ->whereIn('banks.id', $bank_ids)
        ->select('banks.*')
        // ->whereRaw('specialization_rates.id = (SELECT MAX(id) FROM specialization_rates)')
        ->whereRaw('specialization_rates.created_at = (SELECT MAX(created_at) FROM specialization_rates)')
        ->groupBy('banks.name')
        ->orderBy('banks.name','asc');
        if(!empty($this->bank_city_filter)){
            $banks->where('banks.cbsa_code',$this->bank_city_filter);
        }
        if(!empty($this->bank_state_filter)){
            $banks->where('banks.state_id',$this->bank_state_filter);
        }
        $banks = $banks->get();

        $bank_states = $this->getStates($bank_ids);
        $bank_cities = $this->getmsacodes();

        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \App\Models\SpecializationRates::max('created_at'))->format('m-d-Y');
        return view('livewire.special-rate-reports', ['date'=>$date, 'specialization_rates'=>$specialization_rates,'bank_states'=>$bank_states,'bank_cities'=>$bank_cities,'banks'=>$banks,'custom_filters'=>$custom_filters]);
    }

    public function getStates($bank_ids){
        $state = DB::table('specialization_rates')
            ->join('banks','banks.id','specialization_rates.bank_id')
            ->join('states','states.id','banks.state_id')
            ->whereIn('banks.id', $bank_ids)
            ->select('states.id','states.name')
            ->groupBy('state_id')
            ->get();
        return $state;
    }

    public function getmsacodes()
    {
        $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
        if($customer_type->display_reports == 'state'){
            $banks_city = DB::table('bank_selected_city')->where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
            $msa_codes = Bank::with('cities')->whereIn('cbsa_code',$banks_city)->groupBy('cbsa_code')->get();
            return $msa_codes;
        }elseif($customer_type->display_reports == 'custom'){
            $msa_codes = Bank::with('cities')->groupBy('city_id')->get();
            return $msa_codes;
        }elseif($customer_type->display_reports == 'msa'){
            $banks_city = DB::table('bank_selected_city')->where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
            $msa_codes = Bank::with('cities')->whereIn('cbsa_code',$banks_city)->groupBy('cbsa_code')->get();
            return $msa_codes;
        }

    }

    public function selectstate($id)
    {
        $this->bank_city_filter = "";
    }

    public function print_report()
    {
        $customer_bank = CustomerBank::find(Auth::user()->bank_id);
        $custom_filters = Filter::where('user_id',auth()->user()->id)->get();
        if($this->selected_custom_filter && $this->selected_custom_filter != "all"){
            if($this->selected_custom_filter < 1000){
                $filter = Filter::find($this->selected_custom_filter);
                $bank_list = unserialize($filter->bank_id);
                $this->bank_city_filter = "";
            }elseif($this->selected_custom_filter == "custom"){
                $bank_list = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                    ->where('custom_package_banks.bank_id',Auth::user()->bank_id)
                    ->pluck('customer_selected_bank_id')->toArray();
                    $this->bank_city_filter = "";
            }else{
                $this->bank_city_filter = $this->selected_custom_filter;
                $standard_banks_id = Bank::where('cbsa_code', $cities)->pluck('id')->toArray();
                $bank_list = $standard_banks_id;
            }
        }else{
            $bank_list = "";
        }
        if($bank_list == ""){
            if($customer_bank->display_reports == "state"){
                if($this->bank_city_filter != ""){
                    $city_id = BankSelectedCity::where('bank_id',Auth::user()->bank_id)->where('city_id',$this->bank_city_filter)->pluck('city_id');
                    $bank_ids = Bank::whereIn('cbsa_code',$city_id)->pluck('id');
                }else{
                    $city_id = BankSelectedCity::where('bank_id',Auth::user()->bank_id)->pluck('city_id');
                    $bank_ids = Bank::whereIn('cbsa_code',$city_id)->pluck('id');
                }
            }elseif($customer_bank->display_reports == "custom"){
                $bank_ids = CustomPackageBanks::where('bank_id',Auth::user()->bank_id)->pluck('customer_selected_bank_id');
            }elseif($customer_bank->display_reports == "msa"){
                $cities = BankSelectedCity::where('bank_id', Auth::user()->bank_id)->pluck('city_id')->toArray();
                $custom_banks_id = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                    ->where('custom_package_banks.bank_id',Auth::user()->bank_id)
                    ->pluck('customer_selected_bank_id')->toArray();
                $standard_banks_id = Bank::where('cbsa_code', $cities)->pluck('id')->toArray();
                $bank_ids = array_merge($standard_banks_id,$custom_banks_id);
            }
        }else{
            $bank_ids = $bank_list;
        }

        $specialization_rates = SpecializationRates::join('banks', 'banks.id', '=', 'specialization_rates.bank_id')
            ->whereIn('banks.id', $bank_ids)
            ->select('specialization_rates.*')
            // ->whereRaw('specialization_rates.id = (SELECT MAX(id) FROM specialization_rates)')
            ->whereRaw('specialization_rates.created_at = (SELECT MAX(created_at) FROM specialization_rates)')
            ->orderBy('specialization_rates.rate','desc');

        if(!empty($this->bank_city_filter)){
            $specialization_rates->where('banks.cbsa_code',$this->bank_city_filter);
        }
        if(!empty($this->bank_state_filter)){
            $banks->where('banks.state_id',$this->bank_state_filter);
        }
        $specialization_rates = $specialization_rates->get();
        if(!empty($this->bank_city_filter)){
            $banks_city = DB::table('bank_selected_city')->where('bank_id',auth()->user()->bank_id)->where('city_id',$this->bank_city_filter)->pluck('city_id')->toArray();
            $msa_codes = Bank::with('cities')->whereIn('cbsa_code',$banks_city)->groupBy('cbsa_code')->get();
        }else{
            $msa_codes = $this->getmsacodes();
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name." Downloaded Current Specials Report PDF.",
        ]);
        $pdf = PDF::loadView('reports.special_report_pdf', compact('specialization_rates','msa_codes'))->set_option("isPhpEnabled", true)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            "Special_Report.pdf"
        );
        $this->render();
    }
}
