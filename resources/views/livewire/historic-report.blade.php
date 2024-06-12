<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Historic Report</span></h6>

        </div>
        <div class="card-body">
            <div class="row">
                @if ($bank->display_reports == "state")
                    <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="msa_code" wire:change="msa_code_changed">
                            <option value="">Select Metropolitan Area</option>
                            @foreach ($msa_codes as $code)
                                <option value="{{ $code->cbsa_code }}">{{ $code->cbsa_name }}</option>
                            @endforeach
                            <option value="all">All Metropolitan Areas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_date">
                            <option value="">Select Date</option>
                            @foreach ($dates as $date)
                                <option value="{{ $date['original'] }}">{{ $date['formatted'] }}</option>
                            @endforeach
                        </select>
                    </div>
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
                @endif
                @if ($bank->display_reports == "custom")
                    <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_date">
                            <option value="">Select Date</option>
                            @foreach ($dates as $date)
                                <option value="{{ $date['original'] }}">{{ $date['formatted'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example" wire:model="state_id">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($bank->display_reports == "msa")
                    <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example" wire:model="selected_custom_filter">
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
                    <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_date">
                            <option value="">Select Date</option>
                            @foreach ($dates as $date)
                                <option value="{{ $date['original'] }}">{{ $date['formatted'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="text-center">
                <div wire:loading.delay>
                    <div class="spinner-border text-danger" role="status">
                    </div>
                    <br>
                    <span class="text-danger">Loading...</span>
                </div>
            </div>
            <div class="table-responsive table__font_style mt-3" wire:loading.class="invisible">
                <div class="table-wrapper" style="height: 85vh;  overflow: auto;">
                    @if ($selected_date != "")
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead style="position: sticky;top: 0; color: #373737; background: #fafafa">
                                <tr>
                                    <th scope="col">Rank</th>
                                    @foreach ($rate_type as $rt)
                                        <th scope="col">{{ $rt->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $maxItems = 0;
                                    foreach ($rate_type as $rt) {
                                            $maxItems = count($rt['data']);
                                    }
                                @endphp

                                @php
                                    $count = 1;
                                @endphp
                                @for ($i = 0; $i < $maxItems; $i++)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        @foreach ($rate_type as $key => $rt)
                                            @if (isset($rt['data'][$i]))
                                            {{-- @if ($rt['data'][$i]->bank_id != $my_bank_id)
                                                @if ($rt['data'][$i]->bank_id != $selected_bank)
                                                    <td
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;Last Updated: {{date('m-d-Y',strtotime(explode(' ',$rt['data'][$i]->created_at)[0]))}}">
                                                        {{ $rt['data'][$i]->bank_name }}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @else
                                                    <td
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;"
                                                        class="grey_background">{{ $rt['data'][$i]->bank_name }}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @endif
                                            @else --}}
                                                {{-- @if ($rt['data'][$i]->bank_id != $selected_bank)
                                                    <td style="color:#9d4201!important;"
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;Last Updated: {{date('m-d-Y',strtotime(explode(' ',$rt['data'][$i]->created_at)[0]))}}">
                                                        {{ $rt['data'][$i]->bank_name }}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @else --}}
                                                    <td title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;">
                                                            {{ $rt['data'][$i]->bank_name }}
                                                            ({{ number_format($rt['data'][$i]->current_rate,2) }})
                                                    </td>
                                                {{-- @endif --}}
                                            {{-- @endif --}}
                                            @else
                                                <td> </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    @php
                                    $count++;
                                    @endphp
                                @endfor
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .grey_background{
        background: rgb(233, 233, 233) !important;
        color: black;
    }
</style>
