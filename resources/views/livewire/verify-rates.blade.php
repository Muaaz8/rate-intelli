<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Verifable Rates</h6>
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
            </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Bank Name</th>
                        <th>Rate Type</th>
                        <th>Previous APY</th>
                        <th>Current APY</th>
                        <th>Change</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $dt)
                        <tr>
                            <td>{{ date("m-d-Y",strtotime($dt->created_at)) }}</td>
                            <td>{{ $dt->bank_name }}</td>
                            <td>{{ $dt->rate_type_name }}</td>
                            <td>{{ $dt->previous_rate }}</td>
                            <td>{{ $dt->current_rate }}</td>
                            <td>{{ $dt->change == 0 ? "": $dt->change}}</td>
                            <td class="text-center">
                                @if ($dt->is_checked == 0)
                                    <button type="button" class="btn btn-success" wire:click="check({{ $dt->id }})">Check</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
