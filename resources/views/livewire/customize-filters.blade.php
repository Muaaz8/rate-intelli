<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Filters</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <input type="text" class="form-control mr-2 @error('name') is-invalid @enderror" wire:model="name"
                    placeholder="Name....">
            </div>
            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-between">
                    <label for="bank_name_city" class="form-label">Institution
                        Name,
                        State,
                        City
                    </label>
                </div>
                <div class="mt-2">
                    <div class="row">
                        <div class="bank_select_divv p-2">
                            @if (count($this->all_banks) != 0)
                                @php $count = 0; @endphp
                                @foreach ($this->all_banks as $bank)
                                    <div class="form-check">
                                        <input style="position: block;!important"
                                            type="checkbox" value="{{ $bank->id }}"
                                            id="defaultCheck{{ $bank->id }}"
                                            wire:model.defer="selectedItems"
                                            >
                                        <label for="defaultCheck{{ $bank->id }}">
                                            {{ $bank->name }} <span
                                                class="state_city_span">
                                                ({{ $bank->states->name }},
                                                &nbsp;{{ $bank->cities->name }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-6 d-flex align-items-start pt-5 justify-content-start">
                            @if (count($selected_banks_name) != 0)
                                <ul class="width__100 order__list">
                                    @forelse ($selected_banks_name as $item)
                                        <li class=""><b>{{ $item['name'] }}</b>
                                            ({{ $item['states']['name'] }},{{ $item['cities']['name'] }})
                                        </li>
                                    @empty
                                    @endforelse
                                    <div class="d-flex justify-content-center m-2">
                                        <button class="btn btn-danger" wire:click="clear()"> Clear </button>
                                    </div>
                                </ul>
                            @endif
                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="d-flex justify-content-center m-2">
                        <button class="btn btn-primary" wire:click="save_banks">Save</button>
                    </div>
                </div>
            </div>
            @error('name')
                <div class="my-4 text-center">
                    <span class="alert alert-danger">{{$message}}</span>
                </div>
            @enderror
            @error('bank')
                <div class="my-4 text-center">
                    <span class="alert alert-danger">{{$message}}</span>
                </div>
            @enderror
            @error('success')
                <div class="my-4 text-center">
                    <span class="alert alert-success">{{$message}}</span>
                </div>
            @enderror
            <div class="d-flex justify-content-center mb-4">
                @if ($update)
                    <button type="submit" wire:click="updateForm" class="btn btn-primary m-1">Update</button>
                    <button type="submit" wire:click="clear" class="btn btn-danger m-1">Cancel</button>
                @else
                    <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button>
                @endif
            </div>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="accordion" id="accordionFlushExample">
            <div class="accordion-item">
                <div class="card-header py-3" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-6">
                            <h6 class="m-0 font-weight-bold text-primary">Filter List</h6>
                        </div>
                    </div>
                </div>
                <div id="flush-collapseOne" class="accordion-collapse collapse show card-body"
                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="container">
                    </div>
                    <div class="table-responsive">

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Filter Name</th>
                                    <th>Banks Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $dt)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $dt->state_id }}</td>
                                        <td>
                                            @foreach ($dt->banks as $item)
                                                <ul style="display: inline-grid;">
                                                    <li>{{ $item }}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn" wire:click="edit({{ $dt->id }})"><span
                                                    class="bi bi-pen"></span></button>
                                            <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
                                                    class="bi bi-trash"></span></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
