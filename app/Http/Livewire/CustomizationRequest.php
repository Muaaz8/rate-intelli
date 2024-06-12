<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\CustomerBank;
use App\Models\BankSelectedCity;
use App\Models\CustomPackageBanks;
use DB;
use Auth;

class CustomizationRequest extends Component
{
    public function render()
    {
        $data = Payment::where('payment_type','partial')->where('status','0')->get();
        foreach($data as $dt){
            $bank = CustomerBank::find($dt->bank_id);
            $dt->display_reports = $bank->display_reports;
            if($dt->bank_name == "null"){
                $dt->bank_name = DB::table('customer_bank')->where('id',$dt->bank_id)->pluck('bank_name')->first();
            }

            if($bank->display_reports == 'custom'){
                $dt->requested = DB::table('temp_custom_bank')->join('banks','banks.id','temp_custom_bank.customer_selected_bank_id')
                    ->where('bank_id',$dt->bank_id)
                    ->select('temp_custom_bank.*','banks.name')
                    ->get();
                // $dt->requested = CustomPackageBanks::where('bank_id',$dt->bank_id)
                // ->join('banks','banks.id','custom_package_banks.customer_selected_bank_id')
                // ->get();
            }elseif($bank->display_reports == 'state'){
                $dt->requested = BankSelectedCity::where('bank_id',$dt->bank_id)
                ->join('banks','banks.cbsa_code','bank_selected_city.city_id')
                ->select('banks.cbsa_name as name')
                ->groupBy('banks.cbsa_code')
                ->get();
            }elseif($bank->display_reports == 'msa'){
                $dt->requested = BankSelectedCity::where('bank_id',$dt->bank_id)
                ->join('banks','banks.cbsa_code','bank_selected_city.city_id')
                ->select('banks.cbsa_name as name')
                ->groupBy('banks.cbsa_code')
                ->get();
                $dt->custom_requested = DB::table('temp_custom_bank')->join('banks','banks.id','temp_custom_bank.customer_selected_bank_id')
                ->where('bank_id',$dt->bank_id)
                ->select('temp_custom_bank.*','banks.name')
                ->get();
            }
        }
        return view('livewire.customization-request',compact('data'));
    }

    public function approved($id){
        $payment = Payment::find($id);
        $request_banks = DB::table('temp_custom_bank')->where('bank_id',$payment->bank_id)->get();
        foreach ($request_banks as $key => $value) {
            if($value->type == "remove"){
                CustomPackageBanks::where('bank_id',$payment->bank_id)
                    ->where('customer_selected_bank_id',$value->customer_selected_bank_id)->delete();
            }else{
                CustomPackageBanks::create([
                    'bank_id' => $payment->bank_id,
                    'customer_selected_bank_id' => $value->customer_selected_bank_id,
                ]);
            }
        }
        $payment->status = "1";
        $payment->save();
        DB::table('temp_custom_bank')->where('bank_id',$payment->bank_id)->delete();

    }
}
