<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BancAnalytics Corporation Invoice</title>
    <style>

        *{
            margin: 0;
            padding: 0;
        }

    .invoice {
    width: 100%;
    max-width: 830px;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .header {
    background: #20304b;
    color: #fff;
    width: 100%;
    position: relative;
  }

  .color_blue{
    font-style: italic;
    margin: 10px 0px;
  }

  .heading_class {
    position: absolute;
    top: -19px;
    left: 95px;
    padding: 3px;
    background-color: white;
    color: #0c182c;
    font-size: 2.4rem;
    font-weight: 600;
    text-align: right;
}

  .header h1{
      font-style: italic;
  }

  .client-details,
  .services,
  .message {
    padding-left: 15px;
    padding-right: 15px;
    padding-bottom: 5px;
    padding-top: 5px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  table, th, td {
    border: 1px solid #ddd;
  }


  th, td {
    padding: 8px;
    text-align: left;
  }
  .first_table th{
      width: 40%;
  }

  .details_blow_text{
    color: red;
    text-align: center;
    font-style: italic;
    font-size: 12px;
    margin-bottom: 0;
  }

  .details_blow_text_blue{
    color: blue;
    text-align: center;
    font-size: 12px;
  }

  .border_none{
    border: none;
  }

  .detached_blow_line{
    width: 80%;
    height: 2px;
    background-color: #333399;
    text-align: center;
    margin: auto auto;
  }

  .margin_0{
    margin: 2px 0px;
  }

  .align_center{
    text-align: center !important;
  }

  .align_right{
    text-align: right !important;
  }

  .align_left{
    text-align: left !important;
  }

  .w_66{
    display: inline-block;
    width: 66%;
  }

  .w_50{
    display: inline-block;
    width: 49%;
  }

  .w_60{
    display: inline-block;
    width: 60%;
  }

  .w_20{
    display: inline-block;
    width: 17%;
    margin-left: 100px;
    margin-bottom: 0px;
  }

  .w_100{
    width: 100%;
  }

  .mt_10{
    margin-top: 20px !important;
  }

  .mb_10{
    margin-bottom: 20px !important;
  }

  .p_0{
    margin-bottom: 0px;
  }
  .m_0{
    margin-bottom: 0px;
    padding-right: 5px;
  }

  .fs_18{
    font-size: 14px;
    padding-top: 3px;
    padding-bottom: 3px;
    padding-right: 10px;
  }

  .fs_20{
    font-size: 19px;
  }

  </style>
</head>

<body>
    <div class="invoice">

        <div class="logo w_100 align_left">
            <span class="w_66"></span>
            <img height="120px" width="230px" src="{{asset('assets/logo/logo-1.png')}}" alt="Intelli-Rate by BancAnalytics">
        </div>

        <div class="services">
            <div class="header">
            <span class="align_center heading_class p_0">INVOICE</span>
            <p class="align_right w_100 m_0 fs_18">Invoice No.  IR-{{ str_pad($reports->id, 5, '0', STR_PAD_LEFT); }}</p>
            </div>
            </div>




        <div class="services mt_10 mb_10 fs_20">
            <p class="margin_0 w_100 "><span class="w_50">{{ $bank->bank_name }}</span> <span
                    class="w_50 align_right">{{ date('m-d-Y') }}</span> </p>
            <p class="margin_0">{{ $user->name." ".$user->last_name }}</p>
            @if ($bank->billing_address != null)
            <p class="margin_0">{{ $bank->billing_address }}</p>
            @endif
            <p class="margin_0">{{ $bank->cities->name }}, {{ $bank->states->name }} {{ $bank->zip_code }}</p>
        </div>


        <div class="services">

            <hr>

            <table class="first_table">
                <tbody>

                    <tr>
                        <th>Product Type</th>
                        <td>Intelli-Rate Report</td>
                    </tr>

                    <tr>
                        <th>Product Description </th>
                        @if ($bank->display_reports == 'state')
                        <td>Standard Deposit Rate Survey
                            @php
                            $cbsa__ = \App\Models\BankSelectedCity::where('bank_selected_city.bank_id',$bank->id)
                            ->join('banks','bank_selected_city.city_id','banks.cbsa_code')
                            ->select('bank_selected_city.*','banks.cbsa_name')
                            ->groupBy('bank_selected_city.city_id')
                            ->get();
                            @endphp
                            <ul>
                                @foreach ($cbsa__ as $item)
                                <li>{{ $item->cbsa_name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        @elseif($bank->display_reports == 'custom')
                            <td>Custom Deposit Rate Survey</td>
                        @elseif($bank->display_reports == 'msa')
                            <td>Standard & Custom Deposit Rate Survey</td>
                        @endif
                    </tr>


                    <tr>
                        <th>Order/Renewal Date</th>
                        <td>{{ date("m-d-Y") }}
                        </td>
                    </tr>

                    <tr>
                        <th>Start Date </th>
                        @if ($reports->contract_start == "0000-00-00")
                            <td>---</td>
                        @else
                            <td>{{ date("m-d-Y", strtotime($reports->contract_start)) }}</td>
                        @endif

                    </tr>

                    <tr>
                        <th>Term (in months) </th>
                         @if ($reports->contract_start == "0000-00-00")
                            <td>---</td>
                        @else
                            @php
                                $toDate = \Carbon\Carbon::parse($reports->contract_start);
                                $fromDate = \Carbon\Carbon::parse($reports->contract_end);
                            @endphp
                            <td>{{ $fromDate->diffInMonths($toDate,true); }}</td>
                        @endif

                    </tr>

                    <tr>
                        <th>End Date </th>
                        @if ($reports->contract_end == "0000-00-00")
                            <td>---</td>
                        @else
                            <td>{{ date("m-d-Y", strtotime($reports->contract_end)) }}</td>
                        @endif

                    </tr>

                    <tr>
                        <th>Price </th>
                        <td>${{ number_format($reports->charges) }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>



        <p class="details_blow_text mt_10">Please make checks payable to: BancAnalytics Corporation</p>
        <p class="details_blow_text_blue mb_10">(Detach bottom portion of invoice to include with payment)
        </p>

        <p class="detached_blow_line"></p>

        <div class="services ">

            <table class="mb_10">
                <tbody>
                    <tr>

                        <td class="border_none">
                            <img class="margin_0" src="{{asset('assets/logo/logo-1.png')}}" width="200px" height="80px" alt="Intelli-Rate by BancAnalytics">
                            <p class="margin_0 p_0 fs_18">12430 Tesson Ferry Road, <br>
                                Suite #241, <br>
                                St. Louis, MO 63128, <br>
                                support@bancanalytics.com
                            </p>
                        </td>

                        <td class="align_right border_none">
                            <p class="margin_0"><strong>Invoice No:</strong> IR-{{ str_pad($reports->id, 5, '0', STR_PAD_LEFT); }}</p>
                            <p class="margin_0"><strong>Product Type:</strong>Intelli-Rate Report</p>
                            @if ($bank->display_reports == 'state')
                              <p class="margin_0"><strong>Product Desc.</strong>Standard Deposit Rate Survey</p>
                            @elseif($bank->display_reports == 'custom')
                              <p class="margin_0"><strong>Product Desc.</strong>Custom Deposit Rate Survey</p>
                            @elseif($bank->display_reports == 'msa')
                              <p class="margin_0"><strong>Product Desc.</strong>Standard & Custom Deposit Rate Survey</p>
                            @endif
                            @if ($reports->contract_start == "0000-00-00")
                                <p><strong>Terms(Mos.)</strong> ___ </p>
                            @else
                                <p><strong>Terms(Mos.)</strong> {{ $fromDate->diffInMonths($toDate); }}</p>
                            @endif
                        </td>

                    </tr>

                    <tr class="mt_10 ">
                        <td class="border_none">
                            <p class="margin_0">{{ $bank->bank_name }}
                            </p>
                            @if ($bank->billing_address != null)
                                <p class="margin_0"> {{ $bank->billing_address }}</p>
                            @endif
                            <p class="margin_0">{{ $bank->cities->name }}, {{ $bank->states->name }} {{ $bank->zip_code }}</p>
                        </td>


                        <td class="border_none align_right">
                            <p class="margin_0"><strong>Amount Enclosed:</strong>__________</p>
                            <p class="margin_0"><strong>Check Number:</strong>__________</p>

                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
</body>

</html>
