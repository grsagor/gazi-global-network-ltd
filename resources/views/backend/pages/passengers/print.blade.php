<div class="card">
    <div class="card-header">
        <h3>Passenger Details</h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6"><strong>Name:</strong></div>
            <div class="col-md-6">{{ $passenger->name }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Father's Name:</strong></div>
            <div class="col-md-6">{{ $passenger->father_name }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>NID No:</strong></div>
            <div class="col-md-6">{{ $passenger->nid_no ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Passport No:</strong></div>
            <div class="col-md-6">{{ $passenger->passport_no ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Passport Expiry Date:</strong></div>
            <div class="col-md-6">
                {{ $passenger->passport_expire_date ? \Carbon\Carbon::parse($passenger->passport_expire_date)->format('d-m-Y') : 'N/A' }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Designated Country:</strong></div>
            <div class="col-md-6">{{ $passenger->country_id }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Work Type:</strong></div>
            <div class="col-md-6">{{ $passenger->work_type ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Company Name:</strong></div>
            <div class="col-md-6">{{ $passenger->company_name ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Required Document Name:</strong></div>
            <div class="col-md-6">{{ $passenger->required_doc_name ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Application Status:</strong></div>
            <div class="col-md-6">{{ $passenger->application_status ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Contact Amount:</strong></div>
            <div class="col-md-6">{{ $passenger->contact_amount ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Deposit Amount:</strong></div>
            <div class="col-md-6">{{ $passenger->deposit_amount ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Due Amount:</strong></div>
            <div class="col-md-6">{{ $passenger->due_amount ?? 'N/A' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6"><strong>Discount Amount:</strong></div>
            <div class="col-md-6">{{ $passenger->discount_amount ?? 'N/A' }}</div>
        </div>
    </div>
</div>
