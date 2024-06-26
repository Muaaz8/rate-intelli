<div>
    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('web-admin'))
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bank Requests</h6>
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush mb-2" id="accordionFlushExample">
                    @forelse ($data as $key => $dt)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="accordion-item">
                                    <div type="button" class="accordion-button collapsed d-flex justify-content-between"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $key }}" aria-expanded="false"
                                        aria-controls="flush-collapse{{ $key }}">
                                        <h6><strong>Bank Name: </strong>{{ $dt->bank_name=="null"?"":$dt->bank_name }}</h6>
                                        @if($dt->amount != null)
                                            <h6><strong>Amount Payable: </strong>{{ $dt->amount==null?"No Payment required":number_format($dt->amount,2) }}</h6>
                                        @endif
                                        @if($dt->cheque_number != null)
                                            <h6><strong>Cheque Number: </strong>{{ $dt->cheque_number=="null"?"No Payment required":$dt->cheque_number }}</h6>
                                        @endif
                                        @if($dt->cheque_image != null)
                                            <span><strong>View Cheque: </strong><a href="{{ env('APP_URL') . 'storage/' . $dt->cheque_image }}"
                                                target="_blank">
                                                <button class="btn btn-primary"> View</button>
                                            </a></span>
                                        @endif

                                        <button class="btn btn-success"
                                            wire:click="approved({{ $dt->id }})">
                                            Approve </button>
                                    </div>
                                    <div id="flush-collapse{{ $key }}" class="accordion-collapse collapse"
                                        aria-labelledby="flush-heading{{ $key }}" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            @if ($dt->display_reports == 'custom')
                                                                <th>Requested Bank</th>
                                                            @else
                                                                <th>Requested States</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($dt->requested as $dtrb)
                                                            <tr>
                                                                <td>{{ $dtrb->name }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center">No Data</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                @if($dt->display_reports == 'msa')
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Requested Bank</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($dt->customBanksRequested as $dtrb)
                                                                    <tr>
                                                                        <td>{{ $dtrb->name }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">No Data</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center"> No Requests </div>
                    @endforelse
                </div>

            </div>
        </div>
    @endif
</div>
