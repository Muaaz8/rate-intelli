<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Activity Log</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                    <input type="date" class="form-control mr-2" wire:model.defer="date">
                    <input type="search" class="form-control mr-2" wire:model.defer="search" placeholder="Search By Bank Name...">
                    <button class="btn btn-primary" wire:click="render">Search</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Bank Name</th>
                            <th>Activity</th>
                            <th>Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->user->name }}</td>
                                <td>{{ $dt->user->banks?$dt->user->banks->bank_name:$dt->user->roles[0]->name }}</td>
                                <td>{{ $dt->activity }}</td>
                                <td>{{ date('m-d-Y H:i:s', strtotime($dt->created_at)) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $data->links('livewire::bootstrap') }}
            </div>
        </div>
    </div>
</div>
