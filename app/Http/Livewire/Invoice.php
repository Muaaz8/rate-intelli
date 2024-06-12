<?php

namespace App\Http\Livewire;

use PDF;
use App\Models\CustomerBank;
use App\Models\Contract;
use App\Models\User;
use Livewire\Component;
use App\Models\Payment;
use Auth;

class Invoice extends Component
{
    public $type = '';
    public $bank = '';
    public $pdt = '';
    public $pdf;
    public $tandc = false;

    public function mount($id,$type)
    {
        $this->type = $type;
        $this->bank = CustomerBank::findOrFail($id);
    }

    public function render()
    {
        $reports = Contract::where('bank_id', $this->bank->id)->orderBy('id','desc')->first();
        $bank = $this->bank;
        $user = User::where('bank_id', $this->bank->id)->first();
        return view('livewire.invoice',compact('reports','bank','user'));
    }

    public function download(){
        $reports = Contract::where('bank_id', $this->bank->id)->orderBy('id','desc')->first();
        $bank = $this->bank;
        $user = User::where('bank_id', $this->bank->id)->first();
        $this->pdf = PDF::loadView('reports.invoice_PDF', compact('reports','bank','user'))->output();
        return response()->streamDownload(
            fn () => print($this->pdf),
            "Invoice.pdf"
        );
    }

    public function next(){
        if($this->tandc){
            $contract = Contract::where('bank_id',$this->bank->id)->orderby('id','desc')->first();
            if($contract != null){
                if(date('Y-m-d') > $contract->contract_end){
                    $contract = Contract::create([
                        'contract_start' => date('Y-m-d'),
                        'contract_end' => date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 year')),
                        'charges' => $contract->charges,
                        'bank_id' => $this->bank->id,
                    ]);
                }
                $pay = Payment::create([
                    'bank_id' => $this->bank->id,
                    'cheque_number' => null,
                    'cheque_image' => null,
                    'amount' => $contract->charges,
                    'bank_name' => $this->bank->bank_name,
                    'status' => "0",
                    'payment_type' => $this->type,
                ]);
            }
            if(!Auth::check()){
                return redirect(url('/signin'));
            }else{
                return redirect(url('/home'));
            }
        }
    }
}
