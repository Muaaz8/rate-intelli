<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cities;
use App\Models\Bank;
use App\Models\BankPrices;
use App\Models\StandardReportList;
use App\Models\SpecializationRates;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use DB;

class StandardMetropolitanArea extends Component
{
    use WithPagination;

    public $name;
    public $city_id = "";

    public $update = false;
    public $update_id;


    public function render()
    {
        $cities = Bank::select('cbsa_name', 'cbsa_code')
            ->orderBy('cbsa_name', 'ASC')
            ->groupBy('cbsa_name', 'cbsa_code')
            ->get();
        $data = StandardReportList::with('cbsa')->paginate(10);
        return view('livewire.standard-metropolitan-area',['cities'=>$cities,'data'=>$data]);
    }

    public function submitForm()
    {
        if($this->name!='' && $this->city_id != '')
        {
            $check = StandardReportList::where('name',$this->name)->where('city_id',$this->city_id)->first();
            if($check == null)
            {
                StandardReportList::create([
                    'name' => $this->name,
                    'city_id' => $this->city_id,
                    'status' => "1",
                ]);
                $this->clear();
            }else{
                $this->addError('report', 'Report Already Exists');
            }
        }else{
            $this->addError('report', 'Name or City Can\'t be Empty');
        }
    }

    public function delete($id){
        StandardReportList::find($id)->delete();
    }

    public function edit($id){
        $this->update_id = $id;
        $this->update = true;
        $this->name = StandardReportList::find($id)->name;
        $this->city_id = StandardReportList::find($id)->city_id;
    }

    public function update(){
        if($this->name!='' && $this->city_id != '')
        {
            StandardReportList::find($this->update_id)->update([
                'name' => $this->name,
                'city_id' => $this->city_id,
                'status' => "1",
            ]);
        }else{
            $this->addError('update_name', 'Name or City can\'t be Empty');
        }
        $this->cancel();
        $this->render();
    }

    public function downloadBanks($id){
        $cbsa_code = StandardReportList::find($id)->city_id;

        $banks = Bank::where('cbsa_code',$cbsa_code)->get();
        foreach($banks as $key => $bank){
            $bank->rates = BankPrices::whereIn('bank_prices.created_at',function($query) use ($bank){
                $query->selectRaw('MAX(created_at)')
                    ->from('bank_prices')
                    ->where('bank_id', $bank->id)
                    ->where('is_checked', 1);
            })
            ->where('bank_id', $bank->id)
            ->where('is_checked', 1)
            ->get();
        }
        // $banks = Bank::join('bank_prices','bank_prices.bank_id','banks.id')
        //     ->where('banks.cbsa_code',$cbsa_code)
        //     ->whereIn('bank_prices.created_at', function ($query) {
        //         $query->selectRaw('MAX(created_at)')
        //             ->from('bank_prices')
        //             ->where('is_checked', 1)
        //             ->groupBy('rate_type_id')
        //             ->groupBy('bank_id');
        //     })
        //     ->orderBy('banks.name')
        //     ->groupBy('banks.name')
        //     ->select('banks.name')
        //     ->get();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Id');
        $activeWorksheet->setCellValue('B1', 'Bank Name');
        $activeWorksheet->setCellValue('C1', 'Phone Number');
        $activeWorksheet->setCellValue('D1', 'Website');
        $activeWorksheet->setCellValue('E1', '3-Month CD');
        $activeWorksheet->setCellValue('F1', '6-Month CD');
        $activeWorksheet->setCellValue('G1', '9-Month CD');
        $activeWorksheet->setCellValue('H1', '1-Year CD');
        $activeWorksheet->setCellValue('I1', '18-Month CD');
        $activeWorksheet->setCellValue('J1', '2-Year CD');
        $activeWorksheet->setCellValue('K1', '3-Year CD');
        $activeWorksheet->setCellValue('L1', '4-Year CD');
        $activeWorksheet->setCellValue('M1', '5-Year CD');
        $activeWorksheet->setCellValue('N1', 'Savings');
        $activeWorksheet->setCellValue('O1', '$10,000 Money Market');
        $activeWorksheet->setCellValue('P1', '$25,000 Money Market');
        $activeWorksheet->setCellValue('Q1', '$50,000 Money Market');
        $activeWorksheet->setCellValue('R1', 'Date (mm/dd/YYYY)');
        $number = 2;
        foreach ($banks as $key => $bank) {
            $activeWorksheet->setCellValue('A'.$number, $bank->id);
            $activeWorksheet->setCellValue('B'.$number, $bank->name);
            $activeWorksheet->setCellValue('C'.$number, $bank->phone_number);
            $activeWorksheet->setCellValue('D'.$number, $bank->website);
            $columnMap = [
                1 => 'E',
                2 => 'F',
                14 => 'G',
                3 => 'H',
                4 => 'I',
                5 => 'J',
                6 => 'K',
                7 => 'L',
                8 => 'M',
                9 => 'N',
                10 => 'O',
                11 => 'P',
                12 => 'Q'
            ];
            foreach ($bank->rates as $rate) {
                $columnLetter = $columnMap[$rate->rate_type_id] ?? null;
                if ($columnLetter !== null) {
                    $activeWorksheet->setCellValue($columnLetter.$number, $rate->current_rate);
                }
            }
            // foreach ($bank->rates as $key => $rate) {
            //     if(!isset($i) || $i > 79){
            //         $i = 67;
            //     }
            //     if($rate->rate_type_id == 1){
            //         $activeWorksheet->setCellValue('E'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 2){
            //         $activeWorksheet->setCellValue('F'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 14){
            //         $activeWorksheet->setCellValue('G'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 3){
            //         $activeWorksheet->setCellValue('H'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 4){
            //         $activeWorksheet->setCellValue('I'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 5){
            //         $activeWorksheet->setCellValue('J'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 6){
            //         $activeWorksheet->setCellValue('K'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 7){
            //         $activeWorksheet->setCellValue('L'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 8){
            //         $activeWorksheet->setCellValue('M'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 9){
            //         $activeWorksheet->setCellValue('N'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 10){
            //         $activeWorksheet->setCellValue('O'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 11){
            //         $activeWorksheet->setCellValue('P'.$number, $rate->current_rate);
            //     }elseif($rate->rate_type_id == 12){
            //         $activeWorksheet->setCellValue('Q'.$number, $rate->current_rate);
            //     }
            //     $i++;
            // }
            $number++;
        }
        $writer = new Xlsx($spreadsheet);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="Added_Rates_Banks.xlsx"',
        ];

        $callback = function () use ($writer) {
            $writer->save('php://output');
        };

        return Response::stream($callback, 200, $headers);
    }

    public function downloadSpecialsBanks($id){
        $cbsa_code = StandardReportList::find($id)->city_id;

        $banks = Bank::where('cbsa_code', $cbsa_code)->pluck('id');

        $specialization_rates = Bank::leftJoin('specialization_rates', function ($join) {
                $join->on('banks.id', '=', 'specialization_rates.bank_id')
                    ->whereRaw('specialization_rates.created_at = (SELECT MAX(created_at) FROM specialization_rates AS sr WHERE sr.bank_id = specialization_rates.bank_id)');
            })
            ->whereIn('banks.id', $banks)
            ->select('banks.id as banks_id','banks.name','specialization_rates.*')
            ->orderBy('specialization_rates.rate', 'desc')
            ->get();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Id');
        $activeWorksheet->setCellValue('B1', 'Bank Name');
        $activeWorksheet->setCellValue('C1', 'Description');
        $activeWorksheet->setCellValue('D1', 'Rate');
        $number = 2;
        foreach ($specialization_rates as $key => $sr) {
            $activeWorksheet->setCellValue('A'.$number, $sr->banks_id);
            $activeWorksheet->setCellValue('B'.$number, $sr->name);
            $activeWorksheet->setCellValue('C'.$number, $sr->description);
            $activeWorksheet->setCellValue('D'.$number, $sr->rate);
            $number++;
        }
        $writer = new Xlsx($spreadsheet);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="Added_Specials_Banks.xlsx"',
        ];

        $callback = function () use ($writer) {
            $writer->save('php://output');
        };

        return Response::stream($callback, 200, $headers);
    }

    public function cancel(){
        $this->update = false;
        $this->name = '';
        $this->city_id = '';
        $this->update_id = '';
    }


    public function clear(){
        $this->name = '';
        $this->city_id = '';
    }
}
