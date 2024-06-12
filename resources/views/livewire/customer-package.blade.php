<div>
    <div class="home">
        <!-- header starts -->
        <nav class="navbar navbar-expand-lg navbar-dark">
          <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
              <img src="{{ asset('assets/logo/logo-white.png') }}" alt="Logo" width="200" />
            </a>

            <button
              class="navbar-toggler navbar-dark"
              type="button"
              data-toggle="collapse"
              data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link text-white" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white" href="{{ route('interesting_stories') }}">News</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white" href="{{ route('view_feedback') }}">Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('about_page') }}">About</a>
                </li>
              </ul>
            </div>

          </div>

          <div class="collapse navbar-collapse mx-2">
              @if(Auth::check())
                  <button onclick="window.location.href='/home'" class="btn btn-outline-light max_contant">Go To
                      Dashboard</button>
                  <a href="{{ route('logout') }}" class="btn btn-secondary max_contant"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              @else
                  <button onclick="window.location.href='/signup'" class="btn btn-outline-light max_contant">Sign Up Now</button>
                  <button onclick="window.location.href='/signin'" class="btn btn-secondary max_contant">Login</button>
              @endif

          </div>

        </nav>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">INTELLI-RATE</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body text-dark">
            <ul class="navbar-nav justify-content-end pe-3">
            <li class="nav-item">
              <a class="nav-link text-dark" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="{{ route('interesting_stories') }}">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="{{ route('view_feedback') }}">Feedback</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="{{ route('about_page') }}">About</a>
            </li>
            </ul>

            <!-- <div>
              <a href="/signup.html" class="btn btn-outline-primary max_contant">Sign Up</a>
              <a href="/login.html" class="btn btn-secondary max_contant">Login</a>
            </div> -->
          </div>
        </div>
        <!-- header ends  -->

        <!-- package section starts  -->

        <section class="back_sign__ py-3">
            <div class="container-fluid">
                <div class="col-md-8  m-auto">
                    <h2 class="mb-5 text-center text-white">Intelli-Rate</h2>
                    <div class="main_signUp">
                        <div>
                            <h5 class="text-center pt-4 blue_dark">Choose Subscription Plan (One year)</h5>
                            <div>
                                {{-- Package --}}
                                <div class="row p-3">
                                    <div>
                                        <section class="show_box">
                                            <div class="container-fluid">
                                                <div class="container px-5 py-3">
                                                    <div class="row">
                                                        <div class="section-header text-center  pb-5">
                                                            <h2 class="fw-bold fs-2 ">
                                                                Select Your Plan
                                                            </h2>
                                                            <p style="text-align: justify;">
                                                                Choose the metropolitan area of your choice; if the metro is not listed, select a custom report,
                                                                and we will design a custom report for your needs according to the selection of your metropolitan areas.
                                                                You also have the choice to select both standard reports and customer reports.
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        @foreach ($packages as $package)
                                                            <div class="col-lg-6 col-md-12 mb-6"
                                                                >
                                                                <div class="card-2 shadow p-4"
                                                                @if ($ss[$package->package_type] == 1)
                                                                    style="border:2px solid #0d69c5;"
                                                                @endif
                                                                >
                                                                @if ($ss[$package->package_type] == 1)
                                                                    <div class="check_mark">
                                                                    &#10003;
                                                                    </div>
                                                                @endif
                                                                    <div class="card-body">
                                                                        <div class="text-center p-3">
                                                                            <h5 class="card-title-2"
                                                                            >
                                                                                {{ $package->name }}</h5>
                                                                            <span
                                                                                class="card-price-2">${{ number_format($package->price) }}</span>/Annually
                                                                        </div>
                                                                        <p class="card-description-2"
                                                                            style="text-align: justify; margin-bottom: 0px;">
                                                                            {{ $package->description }} </p>
                                                                    </div>
                                                                    <div class="card-body w-100 text-center">
                                                                        @if ($package->package_type == 'state')
                                                                            <p>Four-Week Free Trial</p>
                                                                            <select class="form-select form-control mb-3 ">
                                                                                @foreach ($standard_report_list as $srl)
                                                                                    <option>{{ $srl->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        @endif
                                                                    </div>
                                                                    <div class="card-body text-center w-100">
                                                                        <button class="btn
                                                                        @if ($ss[$package->package_type] == 1)
                                                                        btn-primary
                                                                    @else
                                                                    btn-outline-primary
                                                                @endif
                                                                         btn-md w-100"
                                                                            style="border-radius:10px;"
                                                                            wire:click="subscription_changed('{{ $package->package_type }}')">

                                                                            @if ($ss[$package->package_type] == 1)
                                                                    Selected
                                                                    @else
                                                                    Select
                                                                @endif

                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                        </section>
                                    </div>
                                </div>
                                {{-- Package Details --}}
                                <div class="text-center">
                                    <div wire:loading.delay>
                                        <div class="spinner-border text-danger" role="status">
                                        </div>
                                        <br>
                                        <span class="text-danger">Loading...</span>
                                    </div>
                                </div>
                                <div class="row p-3" wire:loading.class="invisible">
                                    @error('subscription')
                                        <div class="mb-5 text-center">
                                            <span class="alert alert-danger" role="alert">{{ $message }}</span>
                                        </div>
                                    @enderror
                                    @if ($this->current_amount != 0)
                                        <p class="text-success fw-bold">Total Amount:
                                            ${{ number_format($this->current_amount) }}</p>
                                    @endif
                                    @if ($this->subscription != '')
                                        @if ($this->subscription == 'custom')
                                            <div class="col-md-7" style="width: 100% !important">
                                                <div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="bank_type" class="form-label">Select Institution
                                                                Type</label>
                                                            <select class="form-select" id="bank_type" name="bank_type"
                                                                aria-label="Default select example" wire:model="bank_type"
                                                                wire:change="selectbanktype($event.target.value)">
                                                                <option value="">All Institution Types</option>
                                                                @foreach ($bank_types as $bank_type)
                                                                    <option value="{{ $bank_type->id }}">
                                                                        {{ $bank_type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <div>
                                                                @foreach ($bank_state_filter_name as $key => $filtered_state)
                                                                    <span
                                                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_state }}
                                                                        <button type="button"
                                                                            wire:click="deleteState({{ $key }})">
                                                                            <span
                                                                                style="position: absolute;
                                                                        font-size: 14px;
                                                                        background-color: #f12d2d;
                                                                        padding: 0px 7px;
                                                                        border-radius: 13px;
                                                                        top: -12px;
                                                                        right: -12px;
                                                                        color: #fff;
                                                                        font-weight: 600;">x</span>
                                                                        </button>
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                            <label for="bank_type" class="form-label">Select Institution
                                                                State</label>
                                                            <select class="form-select form-control mb-3"
                                                                aria-label="Default select example"
                                                                wire:model="selected_state_now"
                                                                wire:change="selectstate($event.target.value)">
                                                                <option value="">Select State</option>
                                                                @foreach ($available_states as $state)
                                                                    <option value="{{ $state->id }}">
                                                                        {{ $state->name }}</option>
                                                                @endforeach
                                                                <option value="all">All Data</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <div>
                                                                @foreach ($bank_cbsa_filter_name as $key => $filtered_city)
                                                                    <span
                                                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                                                        <button type="button"
                                                                            wire:click="deleteCbsa({{ $key }})">
                                                                            <span
                                                                                style="position: absolute;
                                                                        font-size: 14px;
                                                                        background-color: red;
                                                                        padding: 0px 7px;
                                                                        border-radius: 13px;
                                                                        top: -12px;
                                                                        right: -12px;
                                                                        color: #fff;
                                                                        font-weight: 600;">x</span>
                                                                        </button>
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                            <label for="bank_type" class="form-label">Select Metropolitician
                                                                Area</label>
                                                            <select class="form-select form-control mb-3 "
                                                                aria-label="Default select example"
                                                                wire:model="selected_city_now"
                                                                wire:change="selectcbsa($event.target.value)">
                                                                <option value="">Select Metropolitician Area</option>
                                                                @foreach ($available_cbsa as $city)
                                                                    <option value="{{ $city->cbsa_code }}">
                                                                        {{ $city->cbsa_name }}</option>
                                                                @endforeach
                                                                <option value="all">All Data</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <div class="d-flex justify-content-between">
                                                                <label for="bank_name_city" class="form-label">Institution
                                                                    Name,
                                                                    State,
                                                                    City
                                                                </label>
                                                                <label>Number Selected: {{ count($this->custom_banks) }}</label>
                                                            </div>
                                                            <div class="mt-2">
                                                                <div class="bank_select_divv p-2">
                                                                    @if (count($this->all_banks) != 0)
                                                                        @php $count = 0; @endphp
                                                                        @foreach ($this->all_banks as $bank)
                                                                            @if (in_array($bank->id, $this->custom_banks))
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="{{ $bank->id }}"
                                                                                        id="defaultCheck{{ $bank->id }}"
                                                                                        wire:model.defer="selectedItems"
                                                                                        checked>
                                                                                    <label class="form-check-label"
                                                                                        for="defaultCheck{{ $bank->id }}">
                                                                                        {{ $bank->name }} <span
                                                                                            class="state_city_span">({{ $bank->zip_code }}, {{ $bank->states->name }},
                                                                                            &nbsp;{{ $bank->cities->name }})</span>
                                                                                    </label>
                                                                                </div>
                                                                                @php $count++; @endphp
                                                                            @else
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="{{ $bank->id }}"
                                                                                        id="defaultCheck{{ $bank->id }}"
                                                                                        wire:model.defer="selectedItems"
                                                                                        >
                                                                                    <label class="form-check-label"
                                                                                        for="defaultCheck{{ $bank->id }}">
                                                                                        {{ $bank->name }} <span
                                                                                            class="state_city_span">
                                                                                            ({{ $bank->states->name }},
                                                                                            &nbsp;{{ $bank->cities->name }})</span>
                                                                                    </label>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    @if ($this->total_bank_count > count($this->all_banks))
                                                                        <a wire:click="loadMore"
                                                                            style="cursor:pointer; display: block; text-align: center;"
                                                                            class="">Load More</a>
                                                                    @endif
                                                                </div>
                                                                <div class="d-flex justify-content-center m-2">
                                                                    <button class="btn btn-primary" wire:click="save_banks">Save</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                            @error('notselected')
                                                <div class="mb-5 text-center">
                                                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        @elseif ($this->subscription == 'state')
                                            <div class="col-md-12">
                                                <div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <div class="d-flex flex-lg-wrap">
                                                                @foreach ($bank_city_filter_name as $key => $filtered_city)
                                                                    <span
                                                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                                                        <button type="button"
                                                                            wire:click="deleteCity({{ $key }})">
                                                                            <span
                                                                                style="position: absolute;
                                                                        font-size: 14px;
                                                                        background-color: red;
                                                                        padding: 0px 7px;
                                                                        border-radius: 13px;
                                                                        top: -12px;
                                                                        right: -12px;
                                                                        color: #fff;
                                                                        font-weight: 600;">x</span>
                                                                        </button>
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                            <label for="bank_type" class="form-label">Select Metropolitan Area</label>
                                                            <select class="form-select form-control mb-3 "
                                                                aria-label="Default select example"
                                                                wire:model="selected_city_now"
                                                                wire:change="selectcity($event.target.value)">
                                                                <option value="">Select Metropolitan Area</option>
                                                                @foreach ($standard_report_list as $srl)
                                                                    <option value="{{ $srl->city_id }}">{{ $srl->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($this->subscription == 'msa')
                                            <b class="mb-2">Standard Report</b>
                                            <div class="col-md-12">
                                                <div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <div class="d-flex flex-lg-wrap">
                                                                @foreach ($mixed_metro_areas_name as $key => $filtered_city)
                                                                    <span
                                                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                                                        <button type="button"
                                                                            wire:click="delete_mixed_select_metro_area({{ $key }})">
                                                                            <span
                                                                                style="position: absolute;
                                                                        font-size: 14px;
                                                                        background-color: red;
                                                                        padding: 0px 7px;
                                                                        border-radius: 13px;
                                                                        top: -12px;
                                                                        right: -12px;
                                                                        color: #fff;
                                                                        font-weight: 600;">x</span>
                                                                        </button>
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                            <label for="bank_type" class="form-label">Select Metropolitan Area</label>
                                                            <select class="form-select form-control mb-3 "
                                                                aria-label="Default select example"
                                                                wire:model="selected_city_now"
                                                                wire:change="mixed_select_metro_area($event.target.value)">
                                                                <option value="">Select Metropolitan Area</option>
                                                                @foreach ($standard_report_list as $srl)
                                                                    <option value="{{ $srl->city_id }}">{{ $srl->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <b class="mt-3">Custom Report</b>
                                            <div class="col-md-7" style="width: 100% !important">
                                                <div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="bank_type" class="form-label">Select Institution
                                                                Type</label>
                                                            <select class="form-select" id="bank_type" name="bank_type"
                                                                aria-label="Default select example" wire:model="bank_type"
                                                                wire:change="selectbanktype($event.target.value)">
                                                                <option value="">All Institution Types</option>
                                                                @foreach ($bank_types as $bank_type)
                                                                    <option value="{{ $bank_type->id }}">
                                                                        {{ $bank_type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <div>
                                                                @foreach ($bank_state_filter_name as $key => $filtered_state)
                                                                    <span
                                                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_state }}
                                                                        <button type="button"
                                                                            wire:click="deleteState({{ $key }})">
                                                                            <span
                                                                                style="position: absolute;
                                                                        font-size: 14px;
                                                                        background-color: #f12d2d;
                                                                        padding: 0px 7px;
                                                                        border-radius: 13px;
                                                                        top: -12px;
                                                                        right: -12px;
                                                                        color: #fff;
                                                                        font-weight: 600;">x</span>
                                                                        </button>
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                            <label for="bank_type" class="form-label">Select Institution
                                                                State</label>
                                                            <select class="form-select form-control mb-3"
                                                                aria-label="Default select example"
                                                                wire:model="selected_state_now"
                                                                wire:change="selectstate($event.target.value)">
                                                                <option value="">Select State</option>
                                                                @foreach ($available_states as $state)
                                                                    <option value="{{ $state->id }}">
                                                                        {{ $state->name }}</option>
                                                                @endforeach
                                                                <option value="all">All Data</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <div>
                                                                @foreach ($bank_cbsa_filter_name as $key => $filtered_city)
                                                                    <span
                                                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                                                        <button type="button"
                                                                            wire:click="deleteCbsa({{ $key }})">
                                                                            <span
                                                                                style="position: absolute;
                                                                        font-size: 14px;
                                                                        background-color: red;
                                                                        padding: 0px 7px;
                                                                        border-radius: 13px;
                                                                        top: -12px;
                                                                        right: -12px;
                                                                        color: #fff;
                                                                        font-weight: 600;">x</span>
                                                                        </button>
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                            <label for="bank_type" class="form-label">Select Metropolitician
                                                                Area</label>
                                                            <select class="form-select form-control mb-3 "
                                                                aria-label="Default select example"
                                                                wire:model="selected_city_now"
                                                                wire:change="selectcbsa($event.target.value)">
                                                                <option value="">Select Metropolitician Area</option>
                                                                @foreach ($available_cbsa as $city)
                                                                    <option value="{{ $city->cbsa_code }}">
                                                                        {{ $city->cbsa_name }}</option>
                                                                @endforeach
                                                                <option value="all">All Data</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div>
                                                    <div>
                                                        <div class="mb-3">
                                                            <div class="d-flex justify-content-between">
                                                                <label for="bank_name_city" class="form-label">Institution
                                                                    Name,
                                                                    State,
                                                                    City
                                                                </label>
                                                                <label>Number Selected: {{ count($this->custom_banks) }}</label>
                                                            </div>
                                                            <div class="mt-2">
                                                                <div class="bank_select_divv p-2">
                                                                    @if (count($this->all_banks) != 0)
                                                                        @php $count = 0; @endphp
                                                                        @foreach ($this->all_banks as $bank)
                                                                            @if (in_array($bank->id, $this->custom_banks))
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="{{ $bank->id }}"
                                                                                        id="defaultCheck{{ $bank->id }}"
                                                                                        wire:model.defer="selectedItems"
                                                                                        checked>
                                                                                    <label class="form-check-label"
                                                                                        for="defaultCheck{{ $bank->id }}">
                                                                                        {{ $bank->name }} <span
                                                                                            class="state_city_span">({{ $bank->zip_code }}, {{ $bank->states->name }},
                                                                                            &nbsp;{{ $bank->cities->name }})</span>
                                                                                    </label>
                                                                                </div>
                                                                                @php $count++; @endphp
                                                                            @else
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="{{ $bank->id }}"
                                                                                        id="defaultCheck{{ $bank->id }}"
                                                                                        wire:model.defer="selectedItems">
                                                                                    <label class="form-check-label"
                                                                                        for="defaultCheck{{ $bank->id }}">
                                                                                        {{ $bank->name }} <span
                                                                                            class="state_city_span">
                                                                                            ({{ $bank->states->name }},
                                                                                            &nbsp;{{ $bank->cities->name }})</span>
                                                                                    </label>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    @if ($this->total_bank_count > count($this->all_banks))
                                                                        <a wire:click="loadMore"
                                                                            style="cursor:pointer; display: block; text-align: center;"
                                                                            class="">Load More</a>
                                                                    @endif
                                                                </div>
                                                                <div class="d-flex justify-content-center m-2">
                                                                    <button class="btn btn-primary" wire:click="save_banks">Save</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                            </div>
                                            @error('notselected')
                                                <div class="mb-5 text-center">
                                                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        @endif
                                    @endif

                                    <div class="col-md-12 mb-3">
                                        <div class="mb-3 text-center">
                                            <button type="submit" class="btn btn-primary submit_btn"
                                                wire:click="submitForm">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </section>

        <!-- package section ends  -->
      </div>

</div>
