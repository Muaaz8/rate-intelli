<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\RateType;
use App\Models\BankPrices;
use App\Models\Bank;
use App\Models\CustomerBank;
use App\Models\BankType;
use App\Models\State;
use App\Models\Filter;
use App\Models\Column;
use App\Models\BankSelectedCity;
use App\Models\CustomPackageBanks;
use App\Models\ActivityLog;
use DB;
use Auth;


class SummaryReport extends Component
{
    public $columns = [];
    public $last_updated = '';
    public $selected_bank = '';
    public $selected_bank_type = [];
    public $my_bank_id = '';
    public $unique = false;
    public $msa_code = "";
    public $selected_custom_filter;

    public function mount(){
        $rt = RateType::orderby('display_order')->get();
        $bankTypes = BankType::where('status','1')->get();
        if($this->selected_bank_type == []){
            $this->fill_type($bankTypes);
        }
        if($this->columns == []){
            $this->fill($rt);
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name." Viewed Summary Report.",
        ]);
    }

    public function render()
    {
        $rt = RateType::orderby('display_order')->get();
        $bankTypes = BankType::where('status','1')->get();
        $msa_codes = $this->getmsacodes();
        $states = $this->getstates();
        $custom_filters = Filter::where('user_id',auth()->user()->id)->get();
        if($this->selected_custom_filter && $this->selected_custom_filter != "all"){
            if($this->selected_custom_filter < 1000){
                $filter = Filter::find($this->selected_custom_filter);
                $banks = unserialize($filter->bank_id);
                $this->msa_code = "";
            }elseif($this->selected_custom_filter == "custom"){
                $banks = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                    ->whereIn('banks.bank_type_id',$this->selected_bank_type)
                    ->where('custom_package_banks.bank_id',auth()->user()->bank_id)
                    ->pluck('customer_selected_bank_id')->toArray();
                $this->msa_code = "";
            }else{
                $this->msa_code = $this->selected_custom_filter;
                $cities = BankSelectedCity::where('bank_id', Auth::user()->bank_id)->where('city_id',$this->msa_code)->pluck('city_id')->toArray();
                $standard_banks_id = Bank::where('cbsa_code', $cities)->whereIn('banks.bank_type_id',$this->selected_bank_type)->pluck('id')->toArray();
                $banks = $standard_banks_id;
            }
        }else{
            $banks = "";
        }
        if($banks == ""){
            $type = DB::table('customer_bank')->where('id',auth()->user()->bank_id)->first();
            if($type->display_reports == 'state'){
                $cities = BankSelectedCity::where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
                if($this->msa_code == "" || $this->msa_code == "all"){
                    $banks = Bank::whereIn('cbsa_code',$cities)->whereIn('bank_type_id',$this->selected_bank_type)->pluck('id')->toArray();
                }else{
                    $banks = Bank::where('cbsa_code',$this->msa_code)->whereIn('bank_type_id',$this->selected_bank_type)->pluck('id')->toArray();
                }
            }elseif($type->display_reports == 'msa'){
                if($this->msa_code == ""){
                    $cities = BankSelectedCity::where('bank_id', $type->id)->pluck('city_id')->toArray();
                    $custom_banks_id = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                        ->whereIn('banks.bank_type_id',$this->selected_bank_type)
                        ->where('custom_package_banks.bank_id',$type->id)
                        ->pluck('customer_selected_bank_id')->toArray();
                    $standard_banks_id = Bank::where('cbsa_code', $cities)->whereIn('banks.bank_type_id',$this->selected_bank_type)->pluck('id')->toArray();
                    $banks = array_merge($standard_banks_id,$custom_banks_id);
                }else{
                    $cities = BankSelectedCity::where('bank_id', Auth::user()->bank_id)->where('city_id',$this->msa_code)->pluck('city_id')->toArray();
                    $standard_banks_id = Bank::where('cbsa_code', $cities)->pluck('id')->toArray();
                    $custom_banks_id = [];
                    $banks = array_merge($standard_banks_id,$custom_banks_id);
                }
            }elseif($type->display_reports == 'custom'){
                $filter = CustomerBank::where('id',auth()->user()->bank_id)->first();
                $banks = CustomPackageBanks::where('bank_id',$filter->id)
                    ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
                    ->whereIn('banks.bank_type_id',$this->selected_bank_type)
                    ->pluck('customer_selected_bank_id')
                    ->toArray();
            }
        }

        foreach ($rt as $key => $value) {
            $data = BankPrices::summary_report($value->id,$this->selected_bank_type,$this->msa_code,$banks);
            $value->data = $data;
        }
        if($this->msa_code != null){
            $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                        BankPrices::join('banks','banks.id','bank_prices.bank_id')
                                            ->where('cbsa_code',$this->msa_code)
                                            ->max('bank_prices.created_at'))->format('m-d-Y');
        }else{
            $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', BankPrices::max('created_at'))->format('m-d-Y');
        }

        $customer_bank = CustomerBank::where('id',auth()->user()->bank_id)->first();
        $this->my_bank_id = Bank::where('name','like','%'.$customer_bank->bank_name.'%')->pluck('id')->first();
        $banks_list = Bank::join('bank_prices','bank_prices.bank_id','banks.id')
            ->whereIn('banks.id',$banks)
            ->select('banks.*')
            ->whereIn('bank_prices.created_at', function ($query) use ($banks) {
                $query->selectRaw('MAX(created_at)')
                    ->from('bank_prices')
                    ->where('is_checked', 1)
                    ->whereIn('bank_id', $banks);
            })
            ->groupBy('banks.id')
            ->orderBy('banks.name','asc')
            ->get();
        return view('livewire.summary-report',['custom_filters'=>$custom_filters,'states'=>$states,'rate_type'=>$rt,'banks_list'=>$banks_list,'bankTypes'=>$bankTypes,'customer_bank'=>$customer_bank,'msa_codes'=>$msa_codes]);
    }

    public function fill($data)
    {
        foreach ($data as $key => $dt) {
            $this->columns[$dt->id] = 1;
        }
    }

    public function check_column($id)
    {
        if($this->columns[$id] == 1){
            $this->columns[$id] = 0;
        }else{
            $this->columns[$id] = 1;
        }
    }

    public function selectAll(){
        foreach ($this->columns as $key => $dt) {
                $this->columns[$key] = 1;
        }
        $this->render();
    }

    public function deselectAll(){
        foreach ($this->columns as $key => $dt) {
                $this->columns[$key] = 0;
        }
        $this->render();
    }

    public function save_filters()
    {
        $user_id = auth()->user()->id;
        if($this->selected_bank == '' && $this->selected_bank_type == '' && $this->columns == []){
            $this->addError('filter_error','No Filter is Selected');
        }else{
            $colum = Column::where('user_id',$user_id)->delete();
            foreach ($this->columns as $key => $value) {
                if($value==1){
                    $colum = Column::Create([
                        'user_id'=>$user_id,
                        'rate_type_id'=>$key,
                    ]);
                }
            }
            $filters = Filter::where('user_id',$user_id)->first();
            if($filters!=null){
                $filters->bank_type_id = $this->selected_bank_type;
                $filters->bank_id = $this->selected_bank;
                $filters->save();
                $this->addError('filter_success','Filters Updated Successfully');
            }else{
                $filters = Filter::Create([
                    'user_id'=>$user_id,
                    'bank_type_id'=>$this->selected_bank_type,
                    'bank_id'=>$this->selected_bank,
                ]);
                $this->addError('filter_success','Filters Added Successfully');
            }
        }
    }

    public function load_filters()
    {
        $user_id = auth()->user()->id;
        $colum = Column::where('user_id',$user_id)->get();
        $filters = Filter::where('user_id',$user_id)->first();
        $states = $this->getstates();
        if($filters!=null)
        {
            $this->deselectAll();
            foreach ($colum as $col) {
                $index = $col->rate_type_id;
                $this->columns[$index] = 1;
            }
            $this->selected_bank_type = $filters->bank_type_id;
            $this->selected_bank = $filters->bank_id;
        }
        else{
            $this->addError('filter_error','No Filter is saved');
        }
    }

    public function clear_filer(){
        $this->selected_bank = '';
        $this->selected_bank_type = [];
    }

    public function fill_type($data)
    {
        foreach ($data as $key => $dt) {
            array_push($this->selected_bank_type,$dt->id);
        }
    }

    public function deselectAllInstituteType(){
        $this->selected_bank_type = [""];
    }

    public function selectAllInstituteType(){
        $this->selected_bank_type = [];
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

    public function getstates()
    {
        $selected_banks = CustomPackageBanks::where('bank_id',auth()->user()->bank_id)
        ->join('banks', 'custom_package_banks.customer_selected_bank_id', '=', 'banks.id')
        ->pluck('banks.state_id')->toArray();
        $states = State::whereIn('id',$selected_banks)->get();
        return $states;
    }
}
