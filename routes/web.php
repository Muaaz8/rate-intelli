<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Mail\TestMail;
use App\Models\Stories;
use App\Models\State;
use App\Models\Cities;
use App\Models\Packages;
use App\Models\Bank;
use App\Models\User;
use App\Models\Role;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\CustomerBank;
use App\Models\BankSelectedCity;
use App\Models\StandardReportList;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('view/echeck',function(){
    return view('echeck_page');
});

Route::post('post/echeck',[App\Http\Controllers\GeneralController::class,'post_echeck'])->name('post_echeck');

Route::get('/',function(){
    if(!Auth::check()){
        return view('landing_page');
    }else{
        return redirect()->route('login');
    }
});
Route::get('/',function(){
    // $states = State::where('country_id',233)->get();
    // $cities = Cities::where('country_id',233)->get();
    $packages = Packages::get();
    $standard_report_list = StandardReportList::where('status','1')->get();
    return view('home_page',compact('packages','standard_report_list'));
});

Route::get('/home', function () {
    if(Auth::check()){
        $user = Auth::user();
        $smpa = BankSelectedCity::join('banks','banks.cbsa_code','bank_selected_city.city_id')
            ->where('bank_id',$user->bank_id)
            ->select('bank_selected_city.*','banks.cbsa_code','banks.cbsa_name')
            ->groupby('banks.cbsa_code')
            ->get();
        return view('welcome',compact('smpa'));
    }else{
        return redirect()->route('login');
    }
})->name('home');
Route::middleware(['packages'])->group(function () {
});

Route::get('/Survey/form', function () {
    $states = State::where('country_id',233)->get();
    $cities = Cities::where('country_id',233)->get();
    return view('surveyForm',['states'=>$states, 'cities'=>$cities]);
})->name('survey_form');

Route::get('/signin', function () {
    return view('landing_page');
})->name('/signin');

Route::get('/signup', function () {
    return view('landing_page');
})->name('signup');

Route::get('/about_page', function () {
    return view('about_page');
})->name('about_page');


Route::get('/customerPackage/{id}', function ($id) {
    return view('customer_bank.customer_package',compact('id'));
})->name('customer_package');

Route::get('/invoice/{id}/{type}', function ($id,$type) {
    return view('customer_bank.invoice',compact('id','type'));
})->name('invoice');

Route::get('/payment/{id}/{type}', function ($id,$type) {
    return view('customer_bank.payment',compact('id','type'));
})->name('payment');

Route::get('/interesting_stories', function () {
    $stories = Stories::where('status','1')->get();
    return view('interesting_stories',['stories'=>$stories]);
})->name('interesting_stories');

Route::get('/view_feedback', function () {
    return view('view_feedback');
})->name('view_feedback');

Route::post('/post_feedback', function (Request $request) {
    DB::table('contact_us')->insert([
        'name'=> $request->name,
        'email'=> $request->email,
        'message'=> $request->message,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return redirect()->back()->with('success','Thank you for the feedback.');
})->name('post_feedback');

Route::middleware(['activity_log'])->group(function () {
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout')->middleware('activity_log');
});
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/update/prices/{id}', [App\Http\Controllers\GeneralController::class,'update_price']);
Route::post('/update/prices', [App\Http\Controllers\GeneralController::class,'post_update_price'])->name('update_price');
Route::get('/role/permissions', [App\Http\Controllers\RolesController::class,'role_permission']);
Route::resource('role', App\Http\Controllers\RolesController::class);
Route::get('/abc', [App\Http\Controllers\HomeController::class, 'index'])->name('abc');
Route::get('/roles', [App\Http\Controllers\PermissionController::class,'Permission']);
Route::get('/add_permisiion/{permissoon}', [App\Http\Controllers\PermissionController::class,'add_permisiion']);
Route::get('/manage/users', [App\Http\Controllers\RolesController::class,'manage_users']);
Route::get('/add/users', [App\Http\Controllers\RolesController::class,'add_users']);
Route::get('/manage/banks', [App\Http\Controllers\GeneralController::class,'manage_banks']);
Route::get('/add/bank/rates', [App\Http\Controllers\GeneralController::class,'add_bank_rates']);
Route::get('/manage/rate/types', [App\Http\Controllers\GeneralController::class,'manage_rate_types']);
Route::get('/add/customer/bank', [App\Http\Controllers\GeneralController::class,'add_customer_bank']);
Route::get('/view/customer/bank/admin', [App\Http\Controllers\GeneralController::class,'customer_bank_admin']);
Route::get('/customer/bank/user', [App\Http\Controllers\GeneralController::class,'customer_bank_user']);
Route::get('/view/detailed/customer/bank/{id}', [App\Http\Controllers\GeneralController::class,'view_detailed_customer_bank']);
Route::get('/view/bank/reports', [App\Http\Controllers\GeneralController::class,'view_bank_reports']);
Route::get('/view/detailed/reports', [App\Http\Controllers\GeneralController::class,'view_detailed_reports']);
Route::get('/view/special/reports', [App\Http\Controllers\GeneralController::class,'view_speical_reports']);
Route::get('/bank/type', [App\Http\Controllers\GeneralController::class,'bank_type']);
Route::get('/manage/stories', [App\Http\Controllers\GeneralController::class,'manage_stories']);
Route::get('/manage/charity', [App\Http\Controllers\GeneralController::class,'manage_charity']);
Route::get('/view/seperate/reports', [App\Http\Controllers\GeneralController::class,'seperate_reports']);
Route::get('/view/summary/reports', [App\Http\Controllers\GeneralController::class,'summary_reports']);
Route::get('/view/historic/reports', [App\Http\Controllers\GeneralController::class,'historic_reports']);
Route::get('/view/bank/request', [App\Http\Controllers\GeneralController::class,'bank_request']);
Route::get('/view/registered/bank', [App\Http\Controllers\GeneralController::class,'view_registered_bank']);
//Route::get('/managee/charity', App\Http\Livewire\ManageCharity::class);
Route::get('/manage/packages', [App\Http\Controllers\GeneralController::class,'manage_packages']);
Route::get('/standard/metropolitan/area', [App\Http\Controllers\GeneralController::class,'standard_metropolitan_area']);
Route::get('/customize/packages', [App\Http\Controllers\GeneralController::class,'customize_packages']);
Route::get('/customize/filters', [App\Http\Controllers\GeneralController::class,'customize_filters']);
Route::get('/view/customization/requests', [App\Http\Controllers\GeneralController::class,'view_customization_requests']);
Route::get('/view/my/profile', [App\Http\Controllers\GeneralController::class,'view_customization_requests']);
Route::get('/view/my/profile', [App\Http\Controllers\GeneralController::class,'view_my_profile']);
Route::get('/check/rates', [App\Http\Controllers\GeneralController::class,'check_rates']);
Route::get('/verify/rates', [App\Http\Controllers\GeneralController::class,'verify_rates']);

Route::get('/verify/{code}', [App\Http\Controllers\PermissionController::class,'verify_email']);
Route::get('/user/password/reset/{id}', [App\Http\Controllers\PermissionController::class,'password_reset'])->name('user_password_reset');
Route::post('/user/password/reset', [App\Http\Controllers\PermissionController::class,'password_update'])->name('password_update');

Route::post('/bank/login', [App\Http\Controllers\GeneralController::class,'bank_login'])->name('bank_login');
Route::get('/otp/apply/login/{id}', [App\Http\Controllers\GeneralController::class,'otp_apply'])->name('otp_apply');
Route::post('/verify/login', [App\Http\Controllers\GeneralController::class,'verify_login'])->name('verify_login');
Route::get('/activity/logs', [App\Http\Controllers\GeneralController::class,'activity_logs'])->name('activity_logs');



Route::get('/email',function(){
    Mail::to("moaz.muhammad@yopmail.com")->send(new TestMail());
});


Route::get('/mhlChart/{value}', [App\Http\Controllers\GeneralController::class,'mhlChart']);
Route::get('/mamChart/{value}', [App\Http\Controllers\GeneralController::class,'mamChart']);
Route::get('/mhlChartNonCD/{value}', [App\Http\Controllers\GeneralController::class,'mhlChartNonCD']);
Route::get('/mamChartNonCD/{value}', [App\Http\Controllers\GeneralController::class,'mamChartNonCD']);

Route::get('/getLabels', [App\Http\Controllers\GeneralController::class,'getLabels']);
Route::get('/getNonCDLabels', [App\Http\Controllers\GeneralController::class,'getNonCDLabels']);


Route::get('/add_packages',[App\Http\Controllers\GeneralController::class,'add_packages']);
Route::post('/bank_request_submit',[App\Http\Controllers\GeneralController::class,'bank_request_submit'])->name('bank_request_submit');

Route::get('/flush_cache',[App\Http\Controllers\GeneralController::class,'flush_cache']);

Route::get('/replace_names',function(){
    $filePath = public_path('Replacements.xlsx');
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    // Remove the header row if needed
    $headerRow = array_shift($rows);

    $data = [];
    foreach ($rows as $row) {
        $data[] = array_combine($headerRow, $row);
    }
    // Data here ok
    foreach ($data as $dt) {
        if($dt['Website'] != null){
            $banks = Bank::where('name',$dt['Website'])->get();
            if(count($banks) > 0){
                foreach($banks as $bank){
                    if ($dt['Client Requirement'] != null) {
                        $bank->name = $dt['Client Requirement'];
                        $bank->save();
                    }
                }
            }
        }
    }
});

Route::get('/add_existing_customers',function(){
    $filePath = public_path('Intelli-Rate.xlsx');
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    // Remove the header row if needed
    $headerRow = array_shift($rows);

    $data = [];
    foreach ($rows as $row) {
        $data[] = array_combine($headerRow, $row);
    }
    // Data here ok
    DB::transaction(function () use ($data){
        foreach ($data as $dt) {
            $user_exist = User::where('email',$dt['Email Address'])->first();
            if(!$user_exist){
                $state_id = State::where('state_code',$dt['State'])->pluck('id')->first();
                $city_id = Cities::where('name',$dt['City'])->pluck('id')->first();

                $customer_bank = CustomerBank::create([
                    'bank_name' => $dt['Organization Name'],
                    'bank_email' => " ",
                    'bank_phone_numebr' => $dt['Phone Number'],
                    'website' => $dt['Website'],
                    'msa_code' => " ",
                    'state' => $state_id,
                    'display_reports' => "state",
                    'city_id' => $city_id,
                    'zip_code' => $dt['Zip'],
                    'cbsa_code' => " ",
                    'cbsa_name' => " ",
                    'billing_address' => $dt['Billing Address'],
                ]);
                $user = User::create([
                    'name' => $dt['First Name'],
                    'last_name' => $dt['Last Name'],
                    'email' => $dt['Email Address'],
                    'password' => bcrypt($dt['Direct Phone Number']),
                    'status' => null,
                    'phone_number' => $dt['Direct Phone Number'],
                    'bank_id' => $customer_bank->id,
                    'designation' => $dt['Job Title'],
                ]);

                $user_role = Role::where('slug', 'bank-admin')->first();
                $user->roles()->attach($user_role);
                $cbsa_code = Bank::where('cbsa_name','like','%'.$dt['Standard Package Metro Areas'].'%')->first();
                BankSelectedCity::create([
                    'bank_id' => $customer_bank->id,
                    'city_id' => $cbsa_code->cbsa_code,
                ]);
                $contract = Contract::create([
                    'contract_start' => date('Y-m-d', strtotime($dt['Package Expiry Date'] . '- 1 year' )),
                    'contract_end' => date('Y-m-d', strtotime($dt['Package Expiry Date'] )),
                    'charges' => $dt['Last Paid Amount'],
                    'bank_id' => $customer_bank->id,
                ]);
                if($dt['Last Payment Date'] != 'waiting'){
                    $dt['Last Payment Date'] = date('Y-m-d', strtotime($dt['Last Payment Date']));
                    $pay = Payment::create([
                        'bank_id' => $customer_bank->id,
                        'cheque_number' => null,
                        'cheque_image' => null,
                        'amount' => $dt['Last Paid Amount'],
                        'bank_name' => $customer_bank->bank_name,
                        'status' => "1",
                        'payment_type' => 'complete',
                        'created_at' => $dt['Last Payment Date'],
                        'updated_at' => $dt['Last Payment Date'],
                    ]);
                }else{
                    $dt['Last Payment Date'] = date('Y-m-d', strtotime($dt['Last Payment Date']));
                    $pay = Payment::create([
                        'bank_id' => $customer_bank->id,
                        'cheque_number' => null,
                        'cheque_image' => null,
                        'amount' => $dt['Last Paid Amount'],
                        'bank_name' => $customer_bank->bank_name,
                        'status' => "0",
                        'payment_type' => 'complete',
                        'created_at' => $dt['Last Payment Date'],
                        'updated_at' => $dt['Last Payment Date'],
                    ]);
                }
            }else{
                $cbsa_code = Bank::where('cbsa_name','like','%'.$dt['Standard Package Metro Areas'].'%')->first();
                $selectedExist = BankSelectedCity::where('bank_id',$user_exist->bank_id)->where('city_id',$cbsa_code->cbsa_code)->first();
                if(!$selectedExist){
                    BankSelectedCity::create([
                        'bank_id' => $user_exist->bank_id,
                        'city_id' => $cbsa_code->cbsa_code,
                    ]);
                }
            }
        }
    });

    dd("done");
});
