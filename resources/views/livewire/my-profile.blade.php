<div>
    @if ($update)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Details</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="col-4">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" class="form-control @error('first_name') is-invalid @enderror" wire:model="first_name"
                        placeholder="First Name....">
                </div>
                <div class="col-4">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" class="form-control @error('last_name') is-invalid @enderror" wire:model="last_name"
                        placeholder="Last Name....">
                </div>
                <div class="col-4">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" wire:model="email"
                        placeholder="Email....">
                </div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div class="col-4">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" class="form-control mr-2 @error('phone_number') is-invalid @enderror" wire:model="phone_number"
                        placeholder="Phone Number....">
                </div>
                <div class="col-4">
                    <label for="title">Title</label>
                    <input type="text" id="title" class="form-control mr-2 @error('title') is-invalid @enderror" wire:model="title"
                        placeholder="Title....">
                </div>
                <div class="col-4">
                </div>
            </div>
            @if (auth()->user()->hasRole('bank-admin'))
                <div class="d-flex justify-content-between mb-2">
                    <div class="col-4">
                        <label for="ins_name">Institution Name</label>
                        <input type="text" id="ins_name" class="form-control mr-2 @error('ins_name') is-invalid @enderror" wire:model="ins_name"
                            placeholder="Institution Name....">
                    </div>
                    <div class="col-4">
                        <label for="ins_phone_number">Institution Phone Number</label>
                        <input type="text" id="ins_phone_number" class="form-control mr-2 @error('ins_phone_number') is-invalid @enderror" wire:model="ins_phone_number"
                            placeholder="Institution Phone Number....">
                    </div>
                    <div class="col-4">
                        <label for="ins_website">Website</label>
                        <input type="text" id="ins_website" class="form-control mr-2 @error('ins_website') is-invalid @enderror" wire:model="ins_website"
                            placeholder="Website....">
                    </div>
                </div>
            @endif
            <div class="d-flex justify-content-center mb-4">
                <button type="submit" wire:click="update" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer Bank Details</h6>
        </div>
        <div class="card-body">
            <div>
                <div class="float-right fa-2x">
                    <i class="fa-solid fa-pen-to-square" wire:click="edit({{ $user->id }})"></i>
                </div>
                <h3 class="font-weight-bold text-primary">User Details</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span><strong>First Name: </strong>
                                {{ $user->name }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Last Name: </strong>
                                {{ $user->last_name }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Email: </strong>
                                {{ $user->email }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span><strong>Phone Number: </strong>
                                {{ $user->phone_number }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Title: </strong>
                                {{ $user->designation }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <hr>

            <div>
                <h3 class="font-weight-bold text-primary">Institute Details</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span><strong>Institute Name: </strong>
                                {{ $customerBank->bank_name }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Institute Phone Number: </strong>
                                {{ $customerBank->bank_phone_numebr }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span><strong>Website: </strong>
                                {{ $customerBank->website }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>State: </strong>
                                {{ $customerBank->states->name }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Display Report Type: </strong>
                                @if ($customerBank->display_reports == "state")
                                    <td>Standard Metropolitan Report</td>
                                @elseif ($customerBank->display_reports == "custom")
                                    <td>Custom Report</td>
                                @elseif ($customerBank->display_reports == "msa")
                                    <td>Standard Metropolitan & Custom Report</td>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            @if (auth()->user()->hasRole('bank-admin'))
                <div>
                    <h3 class="font-weight-bold text-primary">Contract Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <span><strong>Contract Start Date: </strong>
                                    {{ date('m-d-Y', strtotime($customerBank->contract->contract_start)) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <span><strong>Contract End Date: </strong>
                                    {{ date('m-d-Y', strtotime($customerBank->contract->contract_end)) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <span><strong>Contract Charges: </strong>
                                    {{ number_format($customerBank->contract->charges, 2) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            @endif

            <hr>

            <div>
                <h3 class="font-weight-bold text-primary">Selected Bank Details</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                @if ($customerBank->display_reports == "custom")
                                    <th>Bank Name</th>
                                    <th>CBSA</th>
                                @else
                                    <th>Metropolitan Area</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customerBank->selected_banks as $dt)
                                <tr>
                                @if ($customerBank->display_reports == "custom")
                                    <td>{{ $dt->name }}</td>
                                    <td>{{ $dt->cbsa_name }}</td>
                                @else
                                    <td>{{ $dt->city_name }}</td>
                                @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if (isset($customerBank->custom_banks))
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>CBSA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customerBank->custom_banks as $dt)
                                    <tr>
                                        <td>{{ $dt->name }}</td>
                                        <td>{{ $dt->cbsa_name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <hr>

            @if (auth()->user()->hasRole('bank-admin'))
                <div>
                    <h3 class="font-weight-bold text-primary">Payment Details</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customerBank->payment as $pay)
                                    <tr>
                                        <td>{{ $pay->amount }}</td>
                                        <td>{{ $pay->status == "1" ?"Approved":"Not Approved Yet" }}</td>
                                        <td>{{ date("m-d-Y",strtotime($pay->created_at)) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Payment yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
