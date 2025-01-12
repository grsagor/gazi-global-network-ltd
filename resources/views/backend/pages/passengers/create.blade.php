<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="crudModalLabel">Save Passenger</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="crudCreateForm">
                @csrf
                @if ($user_role == 1)
                    <div class="mb-3">
                        <label for="agent_id" class="form-label">Select Agent</label>
                        <select name="agent_id" id="agent_id" class="form-control">
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->first_name }} {{ $agent->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="agent_id" value="{{ $user->id }}">
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                        required>
                </div>
                <div class="mb-3">
                    <label for="father_name" class="form-label">Father Name</label>
                    <input type="text" class="form-control" id="father_name" name="father_name"
                        placeholder="Enter father name" required>
                </div>
                <div class="mb-3">
                    <label for="nid_no" class="form-label">NID No.</label>
                    <input type="text" class="form-control" id="nid_no" name="nid_no" placeholder="Enter NID No."
                        required>
                </div>
                <div class="mb-3">
                    <label for="passport_no" class="form-label">Passport No.</label>
                    <input type="text" class="form-control" id="passport_no" name="passport_no"
                        placeholder="Enter Passport No." required>
                </div>
                <div class="mb-3">
                    <label for="passport_expire_date" class="form-label">Passport Expire Date</label>
                    <input type="date" class="form-control" id="passport_expire_date" name="passport_expire_date"
                        required>
                </div>
                <div class="mb-3">
                    <label for="passport_info_upload" class="form-label">Passport Information Page Upload</label>
                    <input type="file" class="form-control" id="passport_info_upload" name="passport_info_upload"
                        accept="image/*,application/pdf" required>
                </div>
                <div class="mb-3">
                    <label for="pcc_number" class="form-label">PCC Number</label>
                    <input type="text" class="form-control" id="pcc_number" name="pcc_number"
                        placeholder="Enter PCC Number" required>
                </div>
                <div class="mb-3">
                    <label for="pcc_issue_date" class="form-label">PCC Issue Date</label>
                    <input type="date" class="form-control" id="pcc_issue_date" name="pcc_issue_date" required>
                </div>
                <div class="mb-3">
                    <label for="pcc_upload" class="form-label">PCC Upload</label>
                    <input type="file" class="form-control" id="pcc_upload" name="pcc_upload"
                        accept="image/*,application/pdf" required>
                </div>
                <div class="mb-3">
                    <label for="designated_country_name" class="form-label">Designated Country Name</label>
                    <input type="text" class="form-control" id="designated_country_name"
                        name="designated_country_name" placeholder="Enter Designated Country Name" required>
                </div>
                <div class="mb-3">
                    <label for="work_type" class="form-label">Work Type</label>
                    <input type="text" class="form-control" id="work_type" name="work_type"
                        placeholder="Enter Work Type" required>
                </div>
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name"
                        placeholder="Enter Company Name" required>
                </div>
                <div class="mb-3">
                    <label for="required_doc_name" class="form-label">Add Required Document Name (Remark)</label>
                    <textarea class="form-control" id="required_doc_name" name="required_doc_name" placeholder="Enter Remarks"
                        rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="application_status" class="form-label">Application Status</label>
                    <select class="form-select" id="application_status" name="application_status" required>
                        <option value="" selected disabled>Choose...</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="contact_amount" class="form-label">Contact Amount</label>
                    <input type="number" class="form-control" id="contact_amount" name="contact_amount"
                        placeholder="Enter Contact Amount" required>
                </div>
                <div class="mb-3">
                    <label for="deposit_amount" class="form-label">Deposit Amount</label>
                    <input type="number" class="form-control" id="deposit_amount" name="deposit_amount"
                        placeholder="Enter Deposit Amount" required>
                </div>
                <div class="mb-3">
                    <label for="due_amount" class="form-label">Due Amount</label>
                    <input type="number" class="form-control" id="due_amount" name="due_amount"
                        placeholder="Enter Due Amount" required>
                </div>
                <div class="mb-3">
                    <label for="discount_amount" class="form-label">Discount Amount</label>
                    <input type="number" class="form-control" id="discount_amount" name="discount_amount"
                        placeholder="Enter Discount Amount" required>
                </div>
                <div class="mb-3">
                    <label for="image_upload" class="form-label">Image Upload</label>
                    <input type="file" class="form-control" id="image_upload" name="image_upload"
                        accept="image/*" onchange="previewImages(event)" data-preview-container="#image_preview"
                        multiple>
                </div>
                <div id="image_preview" class="d-flex flex-wrap mt-2"></div>
                <div class="mb-3">
                    <label for="pdf_upload" class="form-label">PDF Upload</label>
                    <input type="file" class="form-control" id="pdf_upload" name="pdf_upload"
                        accept="application/pdf">
                </div>
                <div class="mb-3">
                    <label for="payment_doc_upload" class="form-label">Payment Doc Upload</label>
                    <input type="file" class="form-control" id="payment_doc_upload" name="payment_doc_upload"
                        accept="application/pdf">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="crudStoreBtn">Save</button>
        </div>
    </div>
</div>
