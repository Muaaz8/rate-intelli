<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Check Rates</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <select class="form-select form-control" aria-label="Default select example" wire:model="selected_metro_area">
                        <option value="">Select Metropolitan Area</option>
                        @foreach ($standard_list as $sl)
                            <option value="{{ $sl->city_id }}">{{ $sl->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <select class="form-select form-control" aria-label="Default select example" wire:model="selected_bank_id">
                        <option value="">Select Institution</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Rate Type</th>
                        <th>Previous APY</th>
                        <th>Current APY</th>
                        <th>Change</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bank_prices as $dt)
                        <tr>
                            <td>{{ date("m-d-Y",strtotime($dt->created_at)) }}</td>
                            <td>{{ $dt->rate_type_name }}</td>
                            <td>{{ $dt->previous_rate }}</td>
                            @if ($update && $update_id == $dt->id)
                                <td>
                                    <div class="d-flex">
                                        <input type="text" class="form-control mr-2" wire:model="current_apy">
                                        <button class="btn btn-primary mr-2"wire:click="saveEdit" >Save</button>
                                        <button class="btn btn-danger mr-2" wire:click="cancelEdit">Cancel</button>
                                    </div>
                                </td>
                            @else
                                <td>{{ $dt->current_rate }}</td>
                            @endif
                            <td>{{ $dt->change == 0 ? "": $dt->change}}</td>
                            <td class="text-center">
                                @if ($dt->is_checked == 0)
                                    <button type="button" class="btn btn-success" wire:click="check({{ $dt->id }})">Check</button>
                                @endif
                                <button type="button" class="btn" wire:click="edit({{ $dt->id }})"><span
                                        class="bi bi-pencil-square"></span></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Check Rates (Specials)</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <select class="form-select form-control" aria-label="Default select example" wire:model="special_selected_metro_area">
                        <option value="">Select Metropolitan Area</option>
                        @foreach ($standard_list as $sl)
                            <option value="{{ $sl->city_id }}">{{ $sl->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Institution Name</th>
                        <th>Description</th>
                        <th>APY</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($special_bank_prices as $dt)
                        <tr>
                            <td>{{ date("m-d-Y",strtotime($dt->created_at)) }}</td>
                            <td>{{ $dt->bank_name }}</td>
                            @if ($special_update && $special_update_id == $dt->id)
                                <td>
                                    <div class="d-flex">
                                        <input type="text" class="form-control mr-2" wire:model="special_description">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <input type="text" class="form-control mr-2" wire:model="special_apy">
                                        <button class="btn btn-primary mr-2"wire:click="saveEdit_speical" >Save</button>
                                        <button class="btn btn-danger mr-2" wire:click="cancelEdit_speical">Cancel</button>
                                    </div>
                                </td>
                            @else
                                <td>{{ $dt->description }}</td>
                                <td>{{ $dt->rate }}</td>
                            @endif
                            <td class="text-center">
                                <button type="button" class="btn" wire:click="edit_speical({{ $dt->id }})"><span
                                        class="bi bi-pencil-square"></span></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
