@extends('backend.layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Passenger Details</h3>
                    </div>
                    <div class="card-body">
                        @if ($agent->profile_image)
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Profile Image:</strong></div>
                                <div class="col-md-6">
                                    <img src="{{ asset($agent->profile_image) }}" alt="Passenger Image" class="img-fluid"
                                        style="max-width: 200px;">
                                </div>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Name:</strong></div>
                            <div class="col-md-6">{{ $agent->first_name }} {{ $agent->last_name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Email:</strong></div>
                            <div class="col-md-6">{{ $agent->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Phone:</strong></div>
                            <div class="col-md-6">{{ $agent->phone }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Father Name:</strong></div>
                            <div class="col-md-6">{{ $agent->father_name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>NID:</strong></div>
                            <div class="col-md-6">{{ $agent->nid }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Passport No:</strong></div>
                            <div class="col-md-6">{{ $agent->passport }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Compmany Name:</strong></div>
                            <div class="col-md-6">{{ $agent->company }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Category:</strong></div>
                            <div class="col-md-6">{{ $agent->category }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Rating:</strong></div>
                            <div class="col-md-6">{{ $agent->rating }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Note:</strong></div>
                            <div class="col-md-6">{{ $agent->note }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <input type="hidden" id="create_url" value="{{ route('admin.passengers.create') }}">
        <input type="hidden" id="store_url" value="{{ route('admin.passengers.store') }}">
        <input type="hidden" id="list_url" value="{{ route('admin.passengers.list') }}">
        <input type="hidden" id="edit_url" value="{{ route('admin.passengers.edit') }}">
        <input type="hidden" id="update_url" value="{{ route('admin.passengers.update') }}">
        <input type="hidden" id="delete_url" value="{{ route('admin.passengers.delete') }}">
        <input type="hidden" id="print_url" value="{{ route('admin.passengers.print') }}">
        <input type="hidden" id="status_url" value="{{ route('admin.agents.status') }}">
        @if ($agent->role == 2)
            <input type="hidden" id="agent_id" value="{{ $agent->id }}">
        @endif
        @if ($agent->role == 3)
            <input type="hidden" id="subagent_id" value="{{ $agent->id }}">
        @endif


        <div class="datatable-header flex-column flex-md-row pb-0">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Passengers</h5>
            </div>
            {{-- @if ($user_role != 3)
                <div class="dt-action-buttons text-end pt-6 pt-md-0">
                    <div class="dt-buttons btn-group flex-wrap">
                        <button id="crudCreateBtn" class="btn btn-secondary create-new btn-primary" type="button">
                            <span><i class="bx bx-plus bx-sm me-sm-2"></i>
                                <span class="d-none d-sm-inline-block">Add</span>
                            </span>
                        </button>
                    </div>
                </div>
            @endif --}}
        </div>
        <table id="datatable_agent_passenger" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Passport No.</th>
                    <th>Country</th>
                    <th>Company Name</th>
                    <th>Agent Name</th>
                    <th>AgentID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@section('js')
    <script>
        const columns = [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'passport_no',
                name: 'passport_no'
            },
            {
                data: 'designated_country_name',
                name: 'designated_country_name'
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
                data: 'agent_id',
                name: 'agent_id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            } // Action buttons
        ]

        $(document).ready(function() {
            const url = $('#list_url').val();
            const agent_id = $('#agent_id').val();
            const subagent_id = $('#subagent_id').val();
            if ($.fn.DataTable.isDataTable('#datatable_agent_passenger')) {
                $('#datatable_agent_passenger').DataTable().destroy();
            }

            const data = {agent_id, subagent_id};

            $('#datatable_agent_passenger').DataTable({
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
                    exportOptions: typeof exportOptions !== 'undefined' && exportOptions ?
                        exportOptions : {}
                }]
            }).on('draw', function() {
                $('.bootstrap4-toggle').bootstrapToggle();
            });

            $('#filter_btn').click(function() {
                const name = $('#filter_name').val();
                const passport_no = $('#filter_passport').val();
                const designated_country_name = $('#filter_country').val();
                const company_name = $('#filter_company_name').val();
                const agent_name = $('#filter_agent_name').val();
                const agent_id = $('#filter_agent_id').val();
                const status = $('#filter_status').val();

                const data = {
                    name,
                    passport_no,
                    designated_country_name,
                    company_name,
                    agent_name,
                    agent_id,
                    status
                }
                initializeDatatable(data);
            })
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
