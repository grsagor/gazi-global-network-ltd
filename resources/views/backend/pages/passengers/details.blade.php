@extends('backend.layout.app')

@section('content')
    <input type="hidden" id="edit_url" value="{{ route('admin.passengers.edit') }}">
    <input type="hidden" id="update_url" value="{{ route('admin.passengers.update') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Passenger Details</h3>
                        <div>
                            <button type="button" class="btn btn-sm btn-primary" id="exportCsvBtn">Export To CSV</button>
                            <button type="button" data-id="{{ $passenger->id }}"
                                class="btn btn-sm btn-primary crudEditBtn">Edit</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Agent:</strong></div>
                            <div class="col-md-6">{{ $passenger->agent->first_name }} {{ $passenger->agent->last_name }}
                            </div>
                        </div>
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
                            <div class="col-md-6"><strong>PCC Number:</strong></div>
                            <div class="col-md-6">{{ $passenger->pcc_number ?? 'N/A' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>PCC Issue Date:</strong></div>
                            <div class="col-md-6">{{ $passenger->pcc_issue_date ?? 'N/A' }}</div>
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
                            <div class="col-md-6">
                                {{ $passenger->contact_amount ? intval($passenger->contact_amount) : 'N/A' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Deposit Amount:</strong></div>
                            <div class="col-md-6">
                                {{ $passenger->deposit_amount ? intval($passenger->deposit_amount) : 'N/A' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Due Amount:</strong></div>
                            <div class="col-md-6">{{ $passenger->due_amount ? intval($passenger->due_amount) : 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Discount Amount:</strong></div>
                            <div class="col-md-6">
                                {{ $passenger->discount_amount ? intval($passenger->discount_amount) : 'N/A' }}</div>
                        </div>

                        <!-- Displaying Images and Files -->

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Image Upload:</strong></div>
                            <div class="col-md-6">
                                @if ($passenger->image_upload)
                                    <img src="{{ asset($passenger->image_upload) }}" alt="Passenger Image"
                                        class="img-fluid" style="max-width: 200px;">
                                @else
                                    <p class="error-message text-danger">No file uploaded for this field.</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>PDF Upload:</strong></div>
                            <div class="col-md-6">

                                @if ($passenger->pdf_upload)
                                    <a href="{{ asset($passenger->pdf_upload) }}" target="_blank" class="btn btn-info">View
                                        PDF</a>
                                @else
                                    <p class="error-message text-danger">No file uploaded for this field.</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Payment Document Upload:</strong></div>
                            <div class="col-md-6">
                                @if ($passenger->payment_doc_upload)
                                    <a href="{{ asset($passenger->payment_doc_upload) }}" target="_blank"
                                        class="btn btn-info">View Payment Doc</a>
                                @else
                                    <p class="error-message text-danger">No file uploaded for this field.</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Passport Info Upload:</strong></div>
                            <div class="col-md-6">
                                @if ($passenger->passport_info_upload)
                                    <a href="{{ asset($passenger->passport_info_upload) }}" target="_blank"
                                        class="btn btn-info">View Passport Info</a>
                                @else
                                    <p class="error-message text-danger">No file uploaded for this field.</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>PCC Upload:</strong></div>
                            <div class="col-md-6">
                                @if ($passenger->pcc_upload)
                                    <a href="{{ asset($passenger->pcc_upload) }}" target="_blank"
                                        class="btn btn-info">View
                                        PCC</a>
                                @else
                                    <p class="error-message text-danger">No file uploaded for this field.</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">

    </div>
@endsection


@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("exportCsvBtn").addEventListener("click", function() {
                let passengers = [
                    @json($passenger)
                ]; // Ensure you pass the passengers data to the view
                let csvContent = "data:text/csv;charset=utf-8,";

                // CSV Header
                csvContent += "Name,Passport No.,Country,Company Name,AgentID,Status\n";

                // Status Mapping
                const statusMapping = {
                    1: "Request for onlist",
                    2: "Onlisted",
                    3: "Not submitted",
                    4: "Submitted",
                    5: "Pending",
                    6: "Ready for submission",
                    7: "Additional docs require",
                    8: "Hold",
                    9: "Permit",
                    10: "Stamping done",
                    11: "Rejected",
                    12: "Resubmit",
                    13: "Return",
                    14: "Additional docs submitted",
                };

                // Data Rows
                passengers.forEach(passenger => {
                    let row = [
                        `"${passenger.name}"`,
                        `"${passenger.passport_no ?? 'N/A'}"`,
                        `"${passenger.country_id}"`,
                        `"${passenger.company_name ?? 'N/A'}"`,
                        `"${passenger.agent_id ?? 'N/A'}"`,
                        `"${statusMapping[passenger.status] || 'Unknown'}"`
                    ].join(",");

                    csvContent += row + "\n";
                });

                // Create and download the CSV file
                let encodedUri = encodeURI(csvContent);
                let link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "passenger_data.csv");
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });
    </script>
@endsection
