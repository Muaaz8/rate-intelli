<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\CustomerBank;
use App\Models\CustomPackageBanks;
use App\Models\BankSelectedCity;
use App\Models\User;
use App\Models\State;
use App\Models\Role;
use App\Models\Filter;
use App\Models\Column;
use App\Models\RateType;
use App\Models\ActivityLog;
use App\Models\BankType;
use DB;
use PDF;

class SeperateReport extends Component
{

    public $columns = [];
    public $reports;
    public $results;
    public $msa_code = "";
    public $last_updated = "";
    public $selected_bank = "";
    public $selected_bank_type = [];
    public $my_bank_id = "";
    public $unique = false;
    public $selected_custom_filter;


    public function mount(){
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name." Viewed APY Ranking Report.",
        ]);
    }

    public function render()
    {
        $rt = RateType::orderby('display_order')->get();
        $customer_type = CustomerBank::where('id',auth()->user()->bank_id)->first();
        $states = $this->getstates();
        $msa_codes = $this->getmsacodes();
        $bankTypes = BankType::where('status','1')->get();
        $custom_filters = Filter::where('user_id',auth()->user()->id)->get();
        if($this->selected_bank_type == [])
        {
            $this->fill_type($bankTypes);
        }
        if($this->selected_custom_filter && $this->selected_custom_filter != "all"){
            if($this->selected_custom_filter < 1000){
                $filter = Filter::find($this->selected_custom_filter);
                $bank_list = unserialize($filter->bank_id);
                $this->msa_code = "";
            }elseif($this->selected_custom_filter == "custom"){
                $bank_list = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                ->where('custom_package_banks.bank_id',auth()->user()->bank_id);
                if (!empty($selectedBankType)) {
                    $bank_list->whereIn('banks.bank_type_id', $selectedBankType);
                }
                $bank_list = $bank_list->pluck('customer_selected_bank_id')->toArray();
                $this->msa_code = "";
            }else{
                $this->msa_code = $this->selected_custom_filter;
                $bank_list = "";
            }
        }else{
            $bank_list = "";
        }
        if($this->msa_code != null){
            $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                        BankPrices::join('banks','banks.id','bank_prices.bank_id')
                                            ->where('cbsa_code',$this->msa_code)
                                            ->max('bank_prices.created_at'))->format('m-d-Y');
        }else{
            $this->last_updated = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', BankPrices::max('created_at'))->format('m-d-Y');
        }
        if($bank_list != ""){
            $response = BankPrices::SeperateReports('all','0',$this->selected_bank_type,$bank_list);
            $this->reports = $response['rate_types'];
            $this->results = BankPrices::get_min_max_func('all','all','0',$this->selected_bank_type);
        }elseif($bank_list == ""){
            if ($this->msa_code != "" && $this->msa_code!='all') {
                $response = BankPrices::SeperateReports('msa',$this->msa_code,$this->selected_bank_type,$bank_list);
                $this->reports = $response['rate_types'];
                $this->results = BankPrices::get_min_max_func('msa','all',$this->msa_code,$this->selected_bank_type);
            }else {
                $response = BankPrices::SeperateReports('all','0',$this->selected_bank_type,$bank_list);
                $this->reports = $response['rate_types'];
                $this->results = BankPrices::get_min_max_func('all','all','0',$this->selected_bank_type);
            }
        }
        if($this->columns == [])
        {
            $this->fill($rt);
        }
        $banks = $response['show_banks'];
        $my_bank_name = CustomerBank::where('id',auth()->user()->bank_id)->pluck('bank_name')->first();
        $this->my_bank_id = Bank::where('name','like','%'.$my_bank_name.'%')->pluck('id')->first();
        return view('livewire.seperate-report',['customer_type'=>$customer_type,'states'=>$states,'msa_codes'=>$msa_codes,'bankTypes'=>$bankTypes,'banks'=>$banks,'custom_filters'=>$custom_filters]);
    }

    public function fill($data)
    {
        foreach ($data as $key => $dt) {
            $this->columns[$dt->id] = 1;
        }
    }

    public function fill_type($data)
    {
        foreach ($data as $key => $dt) {
            array_push($this->selected_bank_type,$dt->id);
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

    public function getstates()
    {
        $selected_banks = CustomPackageBanks::where('bank_id',auth()->user()->bank_id)
        ->join('banks', 'custom_package_banks.customer_selected_bank_id', '=', 'banks.id')
        ->pluck('banks.state_id')->toArray();
        $states = State::whereIn('id',$selected_banks)->get();
        return $states;
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

    public function selectAll(){
        foreach ($this->columns as $key => $dt) {
            if($this->columns[$key] == 0){
                $this->columns[$key] = 1;
            }
        }
        $this->render();
    }

    public function deselectAll(){
        foreach ($this->columns as $key => $dt) {
            if($this->columns[$key] == 1){
                $this->columns[$key] = 0;
            }
        }
    }

    public function deselectAllInstituteType(){
        $this->selected_bank_type = [""];
    }

    public function selectAllInstituteType(){
        $this->selected_bank_type = [];
    }

    public function print_report()
    {
        $rt = RateType::orderby('display_order')->get();
        if($this->selected_custom_filter && $this->selected_custom_filter != "all"){
            if($this->selected_custom_filter < 1000){
                $filter = Filter::find($this->selected_custom_filter);
                $bank_list = unserialize($filter->bank_id);
                $this->msa_code = "";
            }elseif($this->selected_custom_filter == "custom"){
                $bank_list = Bank::join('custom_package_banks', 'custom_package_banks.bank_id', 'banks.id')
                ->where('custom_package_banks.bank_id',auth()->user()->bank_id);
                if (!empty($selectedBankType)) {
                    $bank_list->whereIn('banks.bank_type_id', $selectedBankType);
                }
                $bank_list = $bank_list->pluck('customer_selected_bank_id')->toArray();
                $this->msa_code = "";
            }else{
                $this->msa_code = $this->selected_custom_filter;
                $bank_list = "";
            }
        }else{
            $bank_list = "";
        }
        if($bank_list != ""){
            $response = BankPrices::SeperateReports('all','0',$this->selected_bank_type,$bank_list);
            $reports = $response['rate_types'];
            $results = BankPrices::get_min_max_func('all','all','0',$this->selected_bank_type);
        }elseif($bank_list == ""){
            if ($this->msa_code != "" && $this->msa_code!='all') {
                $response = BankPrices::SeperateReports('msa',$this->msa_code,$this->selected_bank_type,$bank_list);
                $reports = $response['rate_types'];
                $results = BankPrices::get_min_max_func('msa','all',$this->msa_code,$this->selected_bank_type);
            }else {
                $response = BankPrices::SeperateReports('all','0',$this->selected_bank_type,$bank_list);
                $reports = $response['rate_types'];
                $results = BankPrices::get_min_max_func('all','all','0',$this->selected_bank_type);
            }
        }
        if($this->columns == []){
            $this->fill($rt);
        }
        $columns = $this->columns;
        if($this->msa_code == ""){
            $msa_codes = $this->getmsacodes();
        }else{
            $banks_city = DB::table('bank_selected_city')->where('bank_id',auth()->user()->bank_id)->pluck('city_id')->toArray();
            $msa_codes = Bank::with('cities')->whereIn('cbsa_code',$banks_city)->where('cbsa_code',$this->msa_code)->groupBy('cbsa_code')->get();
        }
        $my_bank_name = CustomerBank::where('id',auth()->user()->bank_id)->pluck('bank_name')->first();
        $own_bank = Bank::where('name','like','%'.$my_bank_name.'%')->pluck('id')->first();

        $pdf = PDF::loadView('reports.seperate_report_pdf', compact('reports','results','columns','msa_codes','own_bank'))
            ->set_option("isPhpEnabled", true)
            ->setPaper('a4')
            ->output();

        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \App\Models\BankPrices::max('created_at'))->format('m-d-Y');
        if ($this->msa_code != '' && $this->msa_code!='all') {
            $bank = Bank::where('cbsa_code',$this->msa_code)->first();
            $filename = $bank->cbsa_name."_".$date;
        }else{
            $filename = "Separate_Report"."_".$date;
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => auth()->user()->name." Downloaded APY Ranking Report PDF.",
        ]);
        return response()->streamDownload(
            function () use ($pdf, $msa_codes) {
                print($pdf);
            },
            $filename.".pdf"
        );
        $this->render();
    }

    public function clear()
    {
        $this->msa_code = "";
        $this->selected_bank_type = [];
        $this->selected_bank = "";
    }

    public function selectstate($id)
    {
        $this->msa_code = "";
    }

    public function save_filters()
    {
        $user_id = auth()->user()->id;
        if($this->msa_code == '' && $this->selected_bank_type == '' && $this->selected_bank == '' && $this->columns == []){
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
                $filters->city_id = $this->msa_code;
                $filters->bank_type_id = json_encode($this->selected_bank_type);
                $filters->bank_id = $this->selected_bank;
                $filters->save();
                $this->addError('filter_success','Filters Updated Successfully');
            }else{
                $filters = Filter::Create([
                    'user_id'=>$user_id,
                    'city_id'=>$this->msa_code,
                    'bank_type_id'=>json_encode($this->selected_bank_type),
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
        if($filters!=null)
        {
            $this->deselectAll();
            foreach ($colum as $col) {
                $index = $col->rate_type_id;
                $this->columns[$index] = 1;
            }
            $this->msa_code = $filters->city_id;
            $this->selected_bank_type = json_decode($filters->bank_type_id);
            $this->selected_bank = $filters->bank_id;
        }
        else{
            $this->addError('filter_error','No Filter is saved');
        }
    }
}
