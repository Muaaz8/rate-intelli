<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="d-flex font-weight-bold justify-content-between m-0 text-primary">APY Rankings Report &nbsp;&nbsp;
                (Last Updated On: {{ $last_updated }}) updated on weekly basis</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @if ($customer_type->display_reports == 'custom')
                    <div class="col-md-3 mb-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_custom_filter">
                            <option value="">Select Filters</option>
                            @forelse ($custom_filters as $cf)
                                <option value="{{ $cf->id }}">{{ $cf->state_id }}</option>
                            @empty
                                <option value="">Custom Report</option>
                            @endforelse
                            <option value="all">All Data</option>
                        </select>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white; float:right;"
                            wire:click="print_report">Generate PDF</button>
                    </div>
                    <div class="col-md-2">
                        <div class="dropdown d-flex mb-2">
                            <button class="btn dropdown-toggle" style="background-color:#4e73df; color:white;"
                                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Columns
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" style="background:gray;"
                                aria-labelledby="dropdownMenuButton1">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($reports as $rt)
                                    <li>
                                        <div class="form-check ml-1" style="color:white;">
                                            @if ($columns[$rt->id] == 1)
                                                <input class="form-check-input" type="checkbox" value="" checked
                                                    wire:click="check_column({{ $rt->id }})">
                                                {{ $rt->name }}
                                                @php
                                                    $count++;
                                                @endphp
                                            @else
                                                <input class="form-check-input" type="checkbox" value=""
                                                    wire:click="check_column({{ $rt->id }})">
                                                {{ $rt->name }}
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                                <div class="text-center">
                                    @if ($count == count($reports))
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="deselectAll">
                                            Deselect All
                                        </button>
                                    @else
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="selectAll">
                                            Select All
                                        </button>
                                    @endif
                                </div>
                            </ul>
                        </div>
                    </div>
                @endif
                @if ($customer_type->display_reports == 'state')
                    <div class="col-md-6 col-lg-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="msa_code">
                            <option value="">Select Metropolitan Area</option>
                            @foreach ($msa_codes as $code)
                                <option value="{{ $code->cbsa_code }}">{{ $code->cbsa_name }}</option>
                            @endforeach
                            <option value="all">All Data</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_bank">
                            <option value="">Select Institution</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 col-lg-2">
                        <button class="btn" style="background-color:#4e73df; color:white; float:left;"
                            wire:click="print_report">Generate PDF</button>
                    </div>
                    <div class="col-4 col-lg-2">
                        <div class="dropdown d-flex mb-2">

                            <button class="btn dropdown-toggle px-1" style="background-color:#4e73df; color:white;"
                                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Institution Types
                            </button>

                            <ul class="dropdown-menu dropdown-menu-dark" style="background:gray;"
                                aria-labelledby="dropdownMenuButton1">
                                @foreach ($bankTypes as $bt)
                                    <li>
                                        <div class="form-check ml-1" style="color:white;">
                                            <input class="form-check-input" type="checkbox" value="{{ $bt->id }}"
                                                checked wire:model='selected_bank_type' {{-- wire:click="change_ins_type({{ $bt->id }})" --}}>
                                            {{ $bt->name }}
                                        </div>
                                    </li>
                                @endforeach
                                <div class="text-center">
                                    @if (count($bankTypes) == count($selected_bank_type))
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="deselectAllInstituteType">
                                            Deselect All
                                        </button>
                                    @else
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="selectAllInstituteType">
                                            Select All
                                        </button>
                                    @endif
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2">
                        <div class="dropdown d-flex mb-2">
                            <button class="btn dropdown-toggle" style="background-color:#4e73df; color:white;"
                                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Columns
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" style="background:gray;"
                                aria-labelledby="dropdownMenuButton1">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($reports as $rt)
                                    <li>
                                        <div class="form-check ml-1" style="color:white;">
                                            @if ($columns[$rt->id] == 1)
                                                <input class="form-check-input" type="checkbox" value=""
                                                    checked wire:click="check_column({{ $rt->id }})" id="{{ $rt->name }}">
                                                <label for="{{ $rt->name }}" style="margin-top:0px; !important">{{ $rt->name }}</label>
                                                @php
                                                    $count++;
                                                @endphp
                                            @else
                                                <input class="form-check-input" type="checkbox" value=""
                                                    wire:click="check_column({{ $rt->id }})" id="{{ $rt->name }}">
                                                <label for="{{ $rt->name }}" style="margin-top:0px; !important">{{ $rt->name }}</label>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                                <div class="text-center">
                                    @if ($count == count($reports))
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="deselectAll">
                                            Deselect All
                                        </button>
                                    @else
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="selectAll">
                                            Select All
                                        </button>
                                    @endif
                                </div>
                            </ul>
                        </div>
                    </div>

                    {{-- <div class="col-md-12 col-lg-5">
                        <button class="btn" style="background-color:#4e73df; color:white;width:max-content;" wire:click="save_filters">Save Filters</button>

                        <button class="btn" style="background-color:#4e73df; color:white;width:max-content;" wire:click="load_filters">Apply Filters</button>

                        <button class="btn" style="background-color:#4e73df; color:white;width:max-content;" wire:click="clear()">Clear Filters</button>
                    </div> --}}
                @endif
                @if ($customer_type->display_reports == 'msa')
                    <div class="col-md-6 col-lg-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_custom_filter">
                            <option value="">Select Filters</option>
                            @foreach ($msa_codes as $code)
                                <option value="{{ $code->cbsa_code }}">{{ $code->cbsa_name }} (Standard)</option>
                            @endforeach
                            @forelse ($custom_filters as $cf)
                                <option value="{{ $cf->id }}">{{ $cf->state_id }}</option>
                            @empty
                                <option value="custom">Custom Report</option>
                            @endforelse
                            <option value="all">All Data</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_bank">
                            <option value="">Select Institution</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 col-lg-2">
                        <button class="btn" style="background-color:#4e73df; color:white; float:left;"
                            wire:click="print_report">Generate PDF</button>
                    </div>
                    <div class="col-4 col-lg-2">
                        <div class="dropdown d-flex mb-2">
                            <button class="btn dropdown-toggle px-1" style="background-color:#4e73df; color:white;"
                                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Select Institution Types
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" style="background:gray;"
                                aria-labelledby="dropdownMenuButton1">
                                @foreach ($bankTypes as $bt)
                                    <li>
                                        <div class="form-check ml-1" style="color:white;">
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ $bt->id }}" checked wire:model='selected_bank_type'
                                                {{-- wire:click="change_ins_type({{ $bt->id }})" --}}>
                                            {{ $bt->name }}
                                        </div>
                                    </li>
                                @endforeach
                                <div class="text-center">
                                    @if (count($bankTypes) == count($selected_bank_type))
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="deselectAllInstituteType">
                                            Deselect All
                                        </button>
                                    @else
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="selectAllInstituteType">
                                            Select All
                                        </button>
                                    @endif
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2">
                        <div class="dropdown d-flex mb-2">
                            <button class="btn dropdown-toggle" style="background-color:#4e73df; color:white;"
                                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Select Columns
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" style="background:gray;"
                                aria-labelledby="dropdownMenuButton1">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($reports as $rt)
                                    <li>
                                        <div class="form-check ml-1" style="color:white;">
                                            @if ($columns[$rt->id] == 1)
                                                <input class="form-check-input" type="checkbox" value=""
                                                    checked wire:click="check_column({{ $rt->id }})">
                                                {{ $rt->name }}
                                                @php
                                                    $count++;
                                                @endphp
                                            @else
                                                <input class="form-check-input" type="checkbox" value=""
                                                    wire:click="check_column({{ $rt->id }})">
                                                {{ $rt->name }}
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                                <div class="text-center">
                                    @if ($count == count($reports))
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="deselectAll">
                                            Deselect All
                                        </button>
                                    @else
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                            wire:click="selectAll">
                                            Select All
                                        </button>
                                    @endif
                                </div>
                            </ul>
                        </div>
                    </div>
                @endif
                @error('filter_error')
                    <div class="mt-3 text-center">
                        <span class="alert alert-danger" role="alert">{{ $message }}</span>
                    </div>
                @enderror
                @error('filter_success')
                    <div class="mt-3 text-center">
                        <span class="alert alert-success" role="alert">{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="text-center">
                <div wire:loading.delay>
                    <div class="spinner-border text-danger" role="status"></div>
                    <br>
                    <span class="text-danger">Loading...</span>
                </div>
            </div>
            <div class="row" wire:loading.class="invisible">
                @foreach ($reports as $key => $rt)
                    @if ($columns[$rt->id] == 1)
                        <div class="col-md-6 mt-3 p-2" wire:key="{{ $rt->id }}">
                            <div class="table-responsive table__font_style">
                                <h4 class="m-1 font-weight-bold text-primary" style="text-align:center;">
                                    {{ $rt->name }}</h4>
                                <div class="table-wrapper">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="first-col" style="text-align:center;">Rank</th>
                                                <th class="first-col" style="text-align:center;">Institution Name</th>
                                                <th class="first-col" style="text-align:center;">Previous APY</th>
                                                <th class="first-col" style="text-align:center;">Current APY</th>
                                                <th class="first-col" style="text-align:center;">Changes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($rt['banks'] as $key1 => $bank)
                                                @if ($bank != null)
                                                    @if ($selected_bank == $bank['bank_id'])
                                                        <tr style="background-color: #e8e7e7;">
                                                            <td>{{ ++$key1 }}</td>
                                                            @if ($bank['bank_id'] == $my_bank_id)
                                                                <td style="text-align: left; color:#9d4201!important;">
                                                                    {{ $bank['bank_name'] }}</td>
                                                            @else
                                                                <td style="text-align: left;">{{ $bank['bank_name'] }}
                                                                </td>
                                                            @endif
                                                            @if ($bank['current_rate'] > $bank['previous_rate'])
                                                                <td class="text-success" style="text-align:center;">
                                                                    {{ number_format($bank['previous_rate'], 2) }}</td>
                                                                <td class="text-success" style="text-align:center;">
                                                                    {{ number_format($bank['current_rate'], 2) }}</td>
                                                                <td class="text-success" style="text-align:center;">
                                                                    {{ number_format($bank['change'], 2) }} <i
                                                                        class="fa fa-arrow-up" aria-hidden="true"></i>
                                                                </td>
                                                            @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                                                <td class="text-dark" style="text-align:center;">
                                                                    {{ number_format($bank['previous_rate'], 2) }}</td>
                                                                <td class="text-dark" style="text-align:center;">
                                                                    {{ number_format($bank['current_rate'], 2) }}</td>
                                                                <td class="text-dark" style="text-align:center;">
                                                                </td>
                                                            @else
                                                                <td class="text-danger" style="text-align:center;">
                                                                    {{ number_format($bank['previous_rate'], 2) }}</td>
                                                                <td class="text-danger" style="text-align:center;">
                                                                    {{ number_format($bank['current_rate'], 2) }}</td>
                                                                <td class="text-danger" style="text-align:center;">
                                                                    {{ number_format(abs($bank['change']), 2) }} <i
                                                                        class="fa fa-arrow-down"
                                                                        aria-hidden="true"></i></td>
                                                            @endif
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>{{ ++$key1 }}</td>
                                                            @if ($bank['bank_id'] == $my_bank_id)
                                                                <td style="text-align: left; color:#9d4201!important;">
                                                                    {{ $bank['bank_name'] }}</td>
                                                                @if ($bank['current_rate'] > $bank['previous_rate'])
                                                                    <td class="text-success"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                        {{ number_format($bank['previous_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-success"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                        {{ number_format($bank['current_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-success"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                        {{ number_format($bank['change'], 2) }} <i
                                                                            class="fa fa-arrow-up"
                                                                            aria-hidden="true"></i></td>
                                                                @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                                                    <td class="text-dark"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                        {{ number_format($bank['previous_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-dark"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                        {{ number_format($bank['current_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-dark"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                    </td>
                                                                @else
                                                                    <td class="text-danger"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                        {{ number_format($bank['previous_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-danger"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                        {{ number_format($bank['current_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-danger"
                                                                        style="text-align:center; color:#9d4201!important;">
                                                                        {{ number_format(abs($bank['change']), 2) }} <i
                                                                            class="fa fa-arrow-down"
                                                                            aria-hidden="true"></i></td>
                                                                @endif
                                                            @else
                                                                <td style="text-align: left;">{{ $bank['bank_name'] }}</td>
                                                                @if ($bank['current_rate'] > $bank['previous_rate'])
                                                                    <td class="text-success"
                                                                        style="text-align:center;">
                                                                        {{ number_format($bank['previous_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-success"
                                                                        style="text-align:center;">
                                                                        {{ number_format($bank['current_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-success"
                                                                        style="text-align:center;">
                                                                        {{ number_format($bank['change'], 2) }} <i
                                                                            class="fa fa-arrow-up"
                                                                            aria-hidden="true"></i></td>
                                                                @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                                                    <td class="text-dark" style="text-align:center;">
                                                                        {{ number_format($bank['previous_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-dark" style="text-align:center;">
                                                                        {{ number_format($bank['current_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-dark" style="text-align:center;">
                                                                    </td>
                                                                @else
                                                                    <td class="text-danger"
                                                                        style="text-align:center;">
                                                                        {{ number_format($bank['previous_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-danger"
                                                                        style="text-align:center;">
                                                                        {{ number_format($bank['current_rate'], 2) }}
                                                                    </td>
                                                                    <td class="text-danger"
                                                                        style="text-align:center;">
                                                                        {{ number_format(abs($bank['change']), 2) }} <i
                                                                            class="fa fa-arrow-down"
                                                                            aria-hidden="true"></i></td>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    @endif
                                                @else
                                                    <tr>
                                                        <td style="text-align:center;"> </td>
                                                        <td style="text-align:center;"> </td>
                                                        <td style="text-align:center;"> </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align:center;">Prior</th>
                                                <th style="text-align:center;">Current</th>
                                                <th style="text-align:center;">Change</th>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="text-align:center;">Highest APY</td>
                                                @if ($results[$key]['c_max'] - $results[$key]['p_max'] == '0')
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['p_max'], 2) }}</td>
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['c_max'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-dark"> </td>
                                                @elseif ($results[$key]['c_max'] - $results[$key]['p_max'] > '0')
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['p_max'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_max'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_max'] - $results[$key]['p_max'], 2) }}
                                                        <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                                @else
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['p_max'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['c_max'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format(abs($results[$key]['c_max'] - $results[$key]['p_max']), 2) }}
                                                        <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="text-align:center;">Median</td>
                                                @if ($results[$key]['c_med'] - $results[$key]['p_med'] == '0')
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['p_med'], 2) }}</td>
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['c_med'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-dark"> </td>
                                                @elseif ($results[$key]['c_med'] - $results[$key]['p_med'] > '0')
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['p_med'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_med'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_med'] - $results[$key]['p_med'], 2) }}
                                                        <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                                @else
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['p_med'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['c_med'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format(abs($results[$key]['c_med'] - $results[$key]['p_med']), 2) }}
                                                        <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="text-align:center;">Lowest APY</td>
                                                @if ($results[$key]['c_min'] - $results[$key]['p_min'] == '0')
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['p_min'], 2) }}</td>
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['c_min'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-dark"> </td>
                                                @elseif ($results[$key]['c_min'] - $results[$key]['p_min'] > '0')
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['p_min'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_min'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_min'] - $results[$key]['p_min'], 2) }}
                                                        <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                                @else
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['p_min'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['c_min'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format(abs($results[$key]['c_min'] - $results[$key]['p_min']), 2) }}
                                                        <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="text-align:center;">Average</td>
                                                @if ($results[$key]['c_avg'] - $results[$key]['p_avg'] == '0')
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['p_avg'], 2) }}</td>
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['c_avg'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-dark"> </td>
                                                @elseif ($results[$key]['c_avg'] - $results[$key]['p_avg'] > '0')
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['p_avg'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_avg'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_avg'] - $results[$key]['p_avg'], 2) }}
                                                        <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                                @else
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['p_avg'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['c_avg'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format(abs($results[$key]['c_avg'] - $results[$key]['p_avg']), 2) }}
                                                        <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="text-align:center;">Mode</td>
                                                @if ($results[$key]['c_mode'] - $results[$key]['p_mode'] == '0')
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['p_mode'], 2) }}</td>
                                                    <td style="text-align:center;">
                                                        {{ number_format($results[$key]['c_mode'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-dark"> </td>
                                                @elseif ($results[$key]['c_mode'] - $results[$key]['p_mode'] > '0')
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['p_mode'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_mode'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-success">
                                                        {{ number_format($results[$key]['c_mode'] - $results[$key]['p_mode'], 2) }}
                                                        <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                                @else
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['p_mode'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format($results[$key]['c_mode'], 2) }}</td>
                                                    <td style="text-align:center;" class="text-danger">
                                                        {{ number_format(abs($results[$key]['c_mode'] - $results[$key]['p_mode']), 2) }}
                                                        <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                                @endif
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
