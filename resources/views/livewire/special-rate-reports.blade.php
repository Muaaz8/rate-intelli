<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Current Specials Report &nbsp;&nbsp; (Last Updated On: {{ $date }}) updated on weekly basis</h6>
        </div>
        <div class="text-center my-3" wire:loading.delay>
            <div>
                <div class="spinner-border text-danger" role="status">
                </div>
                <br>
                <span class="text-danger">Loading...</span>
            </div>
        </div>
        <div class="card-body" wire:loading.remove>
            <div class="row">
                @php
                    $bank = \app\Models\CustomerBank::where('id',Auth::user()->bank_id)->first();
                @endphp
                @if($bank->display_reports == 'state')
                    <div class="col-md-4">
                        {{-- <label for="state">Select State</label> --}}
                        <select class="form-select form-control mb-3" aria-label="Default select example" wire:model="bank_city_filter">
                            <option value="">Select Metropolitan Area</option>
                            @foreach ($bank_cities as $bank)
                            <option value="{{ $bank->cbsa_code }}">{{ $bank->cbsa_name }}</option>
                            @endforeach
                            <option value="all">All Data</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select form-control mb-3" aria-label="Default select example" wire:model="selected_bank">
                            <option value="">Select Institute</option>
                            @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        {{-- <label for="download"> Download Special Report</label> --}}
                        <button class="btn btn-primary" wire:click="print_report">Download PDF</button>
                    </div>
                @elseif($bank->display_reports == 'custom')
                    <div class="col-md-4">
                        <select class="form-select form-control mb-3" id="city" aria-label="Default select example" wire:model="selected_custom_filter">
                            <option value="">Select State</option>
                            @forelse ($custom_filters as $cf)
                                <option value="{{ $cf->id }}">{{ $cf->state_id }}</option>
                            @empty
                                <option value="">Custom Report</option>
                            @endforelse
                            <option value="">All Data</option>
                        </select>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" wire:click="print_report">Download PDF</button>
                    </div>
                @elseif($bank->display_reports == 'msa')
                    <div class="col-md-4">
                        <select class="form-select form-control" aria-label="Default select example" wire:model="selected_custom_filter">
                            <option value="">Select Filters</option>
                            @foreach ($bank_cities as $bank)
                                <option value="{{ $bank->cbsa_code }}">{{ $bank->cbsa_name }} (Standard)</option>
                            @endforeach
                            @forelse ($custom_filters as $cf)
                                <option value="{{ $cf->id }}">{{ $cf->state_id }}</option>
                            @empty
                                <option value="custom">Custom Report</option>
                            @endforelse
                            <option value="all">All Data</option>
                        </select>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-primary" wire:click="print_report">Download PDF</button>
                    </div>
                @endif
            </div>
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Institution Name</th>
                            <th>APY</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($specialization_rates as $key => $dt)
                            @if ( $dt->bank_id == $this->selected_bank)
                                <tr style="background-color: #e8e7e7;">
                                    <td>{{ ++$key }}</td>
                                    <td style="text-align: left;">{{ $dt->bank->name }}</td>
                                    <td>{{ number_format($dt->rate,2) }}</td>
                                    <td style="text-align: left;">{{ $dt->description }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td style="text-align: left;">{{ $dt->bank->name }}</td>
                                    <td>{{ number_format($dt->rate,2) }}</td>
                                    <td style="text-align: left;">{{ $dt->description }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4*" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
