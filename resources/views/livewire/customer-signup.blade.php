<form id="signupForm" wire:submit.prevent="submitForm">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="bank_name" class="form-label font_wright_500">Institution Name</label>
                <input type="text" id="bank_name" name="bank_name" wire:model.lazy="bank_name" class="form-control" aria-describedby="name"
                    placeholder="BancAnalytics" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="bank_phone" class="form-label font_wright_500">Main Phone Number</label>
                <input type="text" id="bank_phone" name="bank_phone" class="form-control" wire:model.lazy="bank_phone"  aria-describedby="phone"
                    maxlength="12" placeholder="949-656-3133" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="bank_website" class="form-label font_wright_500">Website</label>
                <input type="text" id="bank_website" name="bank_website" wire:model.lazy="bank_website" class="form-control"
                    aria-describedby="website" placeholder="Your Website" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="zip_code" class="form-label font_wright_500">Zip Code</label>
                <input type="text" id="zip_code" name="zip_code" wire:model="zip_code" wire:keyup="fetch_zip_code" class="form-control" aria-describedby="website"
                    placeholder="Your Zip Code" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="bank_state" class="form-label font_wright_500">State</label>
                <select class="form-select" id="bank_state" name="bank_state" wire:model.lazy="bank_state" aria-label="Default select example"
                    required disabled>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="bank_city" class="form-label font_wright_500">City</label>
                <select class="form-select" id="bank_city" name="bank_city" aria-label="Default select example" wire:model.lazy="bank_city" required
                    disabled>
                    @if ($bank_cities != null)
                        @foreach ($bank_cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="billing_address" class="form-label font_wright_500">Billing
                    Address</label>
                <input type="text" id="billing_address" name="billing_address" class="form-control" wire:model="billing_address"
                    aria-describedby="website" placeholder="Street / PO Box" required>
            </div>
        </div>
    </div>
    <h5 class="admin_heading text-center py-3 my-3 fw-bold blue_dark">Administrator Information
    </h5>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="admin_first_name" class="form-label font_wright_500">First
                    Name</label>
                <input type="text" id="admin_first_name" name="admin_first_name" class="form-control" wire:model.lazy="admin_first_name"
                    aria-describedby="name" placeholder="First Name" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="admin_last_name" class="form-label font_wright_500">Last Name</label>
                <input type="text" id="admin_last_name" name="admin_last_name" class="form-control" wire:model.lazy="admin_last_name"
                    aria-describedby="name" placeholder="Last Name" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="admin_email" class="form-label font_wright_500">Email Address</label>
                <input type="email" id="admin_email" name="admin_email" class="form-control" wire:model.lazy="admin_email"
                    aria-describedby="email" placeholder="Contact Person Email Address" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="admin_phone" class="form-label font_wright_500">Direct Phone
                    Number</label>
                <input type="text" id="admin_phone" name="admin_phone" class="form-control"
                    aria-describedby="phone" maxlength="12" wire:model.lazy="admin_phone" required placeholder="949-656-3133">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="admin_designation" class="form-label font_wright_500">Title</label>
                <input type="text" id="admin_designation" name="admin_designation" class="form-control" wire:model.lazy="admin_designation" 
                    aria-describedby="Designation" placeholder="Job Title" required>
            </div>
        </div>
    </div>
    <div class="w-100 d-flex align-items-center justify-content-center">
        <button type="submit" class="btn my-btn-outline-secondary">Signup</button>
    </div>
</form>
