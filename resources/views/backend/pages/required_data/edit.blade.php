<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="crudModalLabel">Edit Passenger</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="crudUpdateForm">
                @csrf
                <input type="hidden" name="id" value="{{ $passenger->id }}">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $passenger->name) }}" placeholder="Enter name" required>
                </div>
                <div class="mb-3">
                    <label for="father_name" class="form-label">Father Name</label>
                    <input type="text" class="form-control" id="father_name" name="father_name"
                        value="{{ old('father_name', $passenger->father_name) }}" placeholder="Enter father name"
                        required>
                </div>
                <div class="mb-3">
                    <label for="nid_no" class="form-label">NID No.</label>
                    <input type="text" class="form-control" id="nid_no" name="nid_no"
                        value="{{ old('nid_no', $passenger->nid_no) }}" placeholder="Enter NID No." required>
                </div>
                <div class="mb-3">
                    <label for="passport_no" class="form-label">Passport No.</label>
                    <input type="text" class="form-control" id="passport_no" name="passport_no"
                        value="{{ old('passport_no', $passenger->passport_no) }}" placeholder="Enter Passport No."
                        required>
                </div>
                <div class="mb-3">
                    <label for="passport_expire_date" class="form-label">Passport Expire Date</label>
                    <input type="date" class="form-control" id="passport_expire_date" name="passport_expire_date"
                        value="{{ old('passport_expire_date', $passenger->passport_expire_date) }}" required>
                </div>
                <div class="mb-3">
                    <label for="passport_info_upload" class="form-label">Passport Information Page Upload</label>
                    <input type="file" class="form-control" id="passport_info_upload" name="passport_info_upload"
                        accept="image/*,application/pdf">
                    @if ($passenger->passport_info_upload)
                        <div class="mt-2">
                            <img src="{{ asset($passenger->passport_info_upload) }}" alt="Passport Page"
                                class="img-fluid" width="150">
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="pcc_number" class="form-label">PCC Number</label>
                    <input type="text" class="form-control" id="pcc_number" name="pcc_number"
                        value="{{ old('pcc_number', $passenger->pcc_number) }}" placeholder="Enter PCC Number" required>
                </div>
                <div class="mb-3">
                    <label for="pcc_issue_date" class="form-label">PCC Issue Date</label>
                    <input type="date" class="form-control" id="pcc_issue_date" name="pcc_issue_date"
                        value="{{ old('pcc_issue_date', $passenger->pcc_issue_date) }}" required>
                </div>
                <div class="mb-3">
                    <label for="pcc_upload" class="form-label">PCC Upload</label>
                    <input type="file" class="form-control" id="pcc_upload" name="pcc_upload"
                        accept="image/*,application/pdf">
                    @if ($passenger->pcc_upload)
                        <div class="mt-2">
                            <a href="{{ asset($passenger->pcc_upload) }}" target="_blank">View PCC Document</a>
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="country_id" class="form-label">Designated Country Name</label>
                    <input type="text" class="form-control" id="country_id"
                        name="country_id"
                        value="{{ old('country_id', $passenger->country_id) }}"
                        placeholder="Enter Designated Country Name" required>
                </div>
                <div class="mb-3">
                    <label for="work_type" class="form-label">Work Type</label>
                    <input type="text" class="form-control" id="work_type" name="work_type"
                        value="{{ old('work_type', $passenger->work_type) }}" placeholder="Enter Work Type" required>
                </div>
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name"
                        value="{{ old('company_name', $passenger->company_name) }}" placeholder="Enter Company Name"
                        required>
                </div>
                <div class="mb-3">
                    <label for="required_doc_name" class="form-label">Add Required Document Name (Remark)</label>
                    <textarea class="form-control" id="required_doc_name" name="required_doc_name" placeholder="Enter Remarks"
                        rows="3" required>{{ old('required_doc_name', $passenger->required_doc_name) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="application_status" class="form-label">Application Status</label>
                    <select class="form-select" id="application_status" name="application_status" required>
                        <option value="" disabled>Choose...</option>
                        <option value="pending" {{ $passenger->application_status == 'pending' ? 'selected' : '' }}>
                            Pending</option>
                        <option value="approved" {{ $passenger->application_status == 'approved' ? 'selected' : '' }}>
                            Approved</option>
                        <option value="rejected" {{ $passenger->application_status == 'rejected' ? 'selected' : '' }}>
                            Rejected</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="contact_amount" class="form-label">Contact Amount</label>
                    <input type="number" class="form-control" id="contact_amount" name="contact_amount"
                        value="{{ old('contact_amount', $passenger->contact_amount) }}"
                        placeholder="Enter Contact Amount" required>
                </div>
                <div class="mb-3">
                    <label for="deposit_amount" class="form-label">Deposit Amount</label>
                    <input type="number" class="form-control" id="deposit_amount" name="deposit_amount"
                        value="{{ old('deposit_amount', $passenger->deposit_amount) }}"
                        placeholder="Enter Deposit Amount" required>
                </div>
                <div class="mb-3">
                    <label for="due_amount" class="form-label">Due Amount</label>
                    <input type="number" class="form-control" id="due_amount" name="due_amount"
                        value="{{ old('due_amount', $passenger->due_amount) }}" placeholder="Enter Due Amount"
                        required>
                </div>
                <div class="mb-3">
                    <label for="discount_amount" class="form-label">Discount Amount</label>
                    <input type="number" class="form-control" id="discount_amount" name="discount_amount"
                        value="{{ old('discount_amount', $passenger->discount_amount) }}"
                        placeholder="Enter Discount Amount" required>
                </div>
                <div class="mb-3">
                    <label for="image_upload" class="form-label">Image Upload</label>
                    <input type="file" class="form-control" id="image_upload" name="image_upload"
                        accept="image/*" onchange="previewImages(event)" data-preview-container="#image_preview">
                </div>
                <div id="image_preview" class="d-flex flex-wrap mt-2">
                    @if ($passenger->image_upload)
                        <div class="col-2">
                            <img src="{{ asset($passenger->image_upload) }}" alt="Uploaded Image" class="img-fluid">
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="pdf_upload" class="form-label">PDF Upload</label>
                    <input type="file" class="form-control" id="pdf_upload" name="pdf_upload"
                        accept="application/pdf">
                    @if ($passenger->pdf_upload)
                        <div class="mt-2">
                            <a href="{{ asset($passenger->pdf_upload) }}" target="_blank">View PDF</a>
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="payment_doc_upload" class="form-label">Payment Doc Upload</label>
                    <input type="file" class="form-control" id="payment_doc_upload" name="payment_doc_upload"
                        accept="application/pdf">
                    @if ($passenger->payment_doc_upload)
                        <div class="mt-2">
                            <a href="{{ asset($passenger->payment_doc_upload) }}" target="_blank">View Payment
                                Document</a>
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option {{ $passenger->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $passenger->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                    </select>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="crudUpdateBtn">Update</button>
        </div>
    </div>
</div>
