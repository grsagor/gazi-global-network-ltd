@extends('backend.layout.app')
@section('content')
    <div class="card mb-5 p-5">
        <div class="head-label">
            <h5 class="card-title mb-0">Filter</h5>
        </div>
        <div class="row">
            <div class="mb-3 col-3">
                <label for="filter_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="filter_name" placeholder="Name">
            </div>
            <div class="mb-3 col-3">
                <label for="filter_passport" class="form-label">Passport No.</label>
                <input type="text" class="form-control" id="filter_passport" placeholder="Passport No.">
            </div>
            <div class="mb-3 col-3">
                <label for="filter_country" class="form-label">Country</label>
                <select class="form-select" id="filter_country">
                    <option value="">Select</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 col-3">
                <label for="filter_company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="filter_company_name" placeholder="Company Name">
            </div>
            <div class="mb-3 col-3">
                <label for="filter_agent_name" class="form-label">Agent Name</label>
                <input type="text" class="form-control" id="filter_agent_name" placeholder="Agent Name">
            </div>
            <div class="mb-3 col-3">
                <label for="filter_agent_id" class="form-label">AgentID</label>
                <input type="text" class="form-control" id="filter_agent_id" placeholder="AgentID">
            </div>
            <div class="mb-3 col-3">
                <label for="filter_status" class="form-label">Status</label>
                <select class="form-select" id="filter_status">
                    <option value="">Select</option>
                    <option value="1">Request for onlist</option>
                    <option value="2">Onlisted</option>
                    <option value="3">Not submitted</option>
                    <option value="4">Submitted</option>
                    <option value="5">Pending</option>
                    <option value="6">Ready for submission</option>
                    <option value="7">Additional docs require</option>
                    <option value="8">Hold</option>
                    <option value="9">Permit</option>
                    <option value="10">Stamping done</option>
                    <option value="11">Rejected</option>
                    <option value="12">Resubmit</option>
                    <option value="13">Return</option>
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-danger" id="clear_btn">Clear</button>
            <button type="button" class="btn btn-primary" id="filter_btn">Filter</button>
        </div>
    </div>
    <div class="card">
        <input type="hidden" id="create_url" value="{{ route('admin.passengers.create') }}">
        <input type="hidden" id="store_url" value="{{ route('admin.passengers.store') }}">
        <input type="hidden" id="list_url" value="{{ route('admin.passengers.list') }}">
        <input type="hidden" id="edit_url" value="{{ route('admin.passengers.edit') }}">
        <input type="hidden" id="update_url" value="{{ route('admin.passengers.update') }}">
        <input type="hidden" id="delete_url" value="{{ route('admin.passengers.delete') }}">
        <input type="hidden" id="print_url" value="{{ route('admin.passengers.print') }}">
        <input type="hidden" id="status_url" value="{{ route('admin.passengers.status') }}">

        <div class="datatable-header flex-column flex-md-row pb-0">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Passengers</h5>
            </div>
            @if ($user_role != 3)
                <div class="dt-action-buttons text-end pt-6 pt-md-0">
                    <div class="dt-buttons btn-group flex-wrap">
                        <button id="crudCreateBtn" class="btn btn-secondary create-new btn-primary" type="button">
                            <span><i class="bx bx-plus bx-sm me-sm-2"></i>
                                <span class="d-none d-sm-inline-block">Add</span>
                            </span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
        <div class="overflow-auto">
            <table id="datatable" class="table table-hover" style="width:100%;">
                <thead>
                    <tr>
                        <th>SI</th>
                        <th>Name</th>
                        <th>Passport No.</th>
                        <th>Country</th>
                        <th>Company Name</th>
                        <th>Agent Name</th>
                        <th>Work Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">

    </div>
@endsection

@section('js')
    <script>
        const columns = [{
                data: null,
                name: 'index',
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Generates 1, 2, 3, ...
                },
                orderable: false, // Index should not be sortable
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'passport_no',
                name: 'passport_no'
            },
            {
                data: 'country_id',
                name: 'country_id'
            },
            {
                data: 'company_name',
                name: 'company_name'
            },
            {
                data: 'agent_name',
                name: 'agent_name'
            },
            {
                data: 'work_type',
                name: 'work_type'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'passenger_status_column'
            } // Action buttons
        ]

        function initializeDatatable(data) {
            const url = $('#list_url').val();
            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }

            try {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
                        type: "GET",
                        data: data
                    },
                    columns: columns,
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    lengthMenu: [10, 25, 50, 100], // Define the "per page" options
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"Bf>>' +
                        // Buttons next to search box
                        'rtip', // Buttons, table (t), pagination (p), info (i)
                    buttons: [{
                        extend: 'csv',
                        text: 'Export CSV', // Button text
                        className: 'btn btn-primary', // Add a custom class for styling
                        // exportOptions: typeof exportOptions !== 'undefined' && exportOptions ? exportOptions : {}
                        action: function(e, dt, button, config) {
                            const url = "{{ route('admin.passengers.all.csv') }}";
                            exportToCSV(url, 'passengers.csv');
                        }
                    }]
                }).on('draw', function() {
                    $('.bootstrap4-toggle').bootstrapToggle();
                });
            } catch (error) {
                console.log('error', error)
            }
        }

        $(document).ready(function() {
            $('#filter_btn').click(function() {
                const name = $('#filter_name').val();
                const passport_no = $('#filter_passport').val();
                const country_id = $('#filter_country').val();
                const company_name = $('#filter_company_name').val();
                const agent_name = $('#filter_agent_name').val();
                const agent_id = $('#filter_agent_id').val();
                const status = $('#filter_status').val();

                const data = {
                    name,
                    passport_no,
                    country_id,
                    company_name,
                    agent_name,
                    agent_id,
                    status
                }
                initializeDatatable(data);
            });
        });

        $('#clear_btn').click(function() {
            $('#filter_name').val('');
            $('#filter_passport').val('');
            $('#filter_country').val('');
            $('#filter_company_name').val('');
            $('#filter_agent_name').val('');
            $('#filter_agent_id').val('');
            $('#filter_status').val('');
            initializeDatatable();
        })

        // const exportOptions = {
        //     columns: [0, 1, 2, 4] // Specify the columns to include in the CSV export
        // }
    </script>
@endsection
