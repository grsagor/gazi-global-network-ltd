@extends('backend.layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>
                            @if ($agent->role == 2)
                                Agent
                            @else
                                Subagent
                            @endif Details
                        </h3>
                        <div>
                            <button type="button" data-id="{{ $agent->id }}"
                                class="btn btn-sm btn-primary crudEditBtn">Edit</button>
                        </div>
                    </div>
                    <input type="hidden" id="edit_url" value="{{ route('admin.agents.edit', ['role' => $agent->role]) }}">
                    <input type="hidden" id="update_url"
                        value="{{ route('admin.agents.update', ['role' => $agent->role]) }}">
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
                        @if ($agent->role == 2)
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Rating:</strong></div>
                                <div class="col-md-6">{{ $agent->rating }}</div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Note:</strong></div>
                            <div class="col-md-6">{{ $agent->note }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="create_url" value="{{ route('admin.passengers.create') }}">
    <input type="hidden" id="store_url" value="{{ route('admin.passengers.store') }}">
    <input type="hidden" id="list_url" value="{{ route('admin.passengers.list') }}">
    <input type="hidden" id="subagent_list_url" value="{{ route('admin.agents.list', ['role' => 3]) }}">
    <input type="hidden" id="delete_url" value="{{ route('admin.passengers.delete') }}">
    <input type="hidden" id="print_url" value="{{ route('admin.passengers.print') }}">
    <input type="hidden" id="status_url" value="{{ route('admin.passengers.status') }}">
    @if ($agent->role == 2)
        <input type="hidden" id="agent_id" value="{{ $agent->id }}">
    @endif
    @if ($agent->role == 3)
        <input type="hidden" id="subagent_id" value="{{ $agent->id }}">
    @endif


    @if ($agent->role == 2)
        <div class="card mt-5">
            <div class="datatable-header flex-column flex-md-row pb-0">
                <div class="head-label text-center">
                    <h5 class="card-title mb-0">Sub-Agents</h5>
                </div>
            </div>
            <table id="datatable_agent_subagent" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>SI</th>
                        <th>Name</th>
                        <th>AgentID</th>
                        <th>Company Name</th>
                        <th>Passport</th>
                        <th>NID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endif

    <div class="card mt-5">
        <div class="datatable-header flex-column flex-md-row pb-0">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Passengers</h5>
            </div>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">

    </div>
@endsection
@section('js')
    <script>
        function agentDatatable() {
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
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'company',
                    name: 'company'
                },
                {
                    data: 'passport',
                    name: 'passport'
                },
                {
                    data: 'nid',
                    name: 'nid'
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
            const url = $('#subagent_list_url').val();
            const agent_id = $('#agent_id').val();
            const subagent_id = $('#subagent_id').val();
            if ($.fn.DataTable.isDataTable('#datatable_agent_subagent')) {
                $('#datatable_agent_subagent').DataTable().destroy();
            }

            const data = {
                agent_id,
                subagent_id
            };

            $('#datatable_agent_subagent').DataTable({
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
                        const url = @json(route('admin.agents.all.csv', ['agent_id' => $agent->id, 'role' => '3']));
                        let fileName = 'sub_agents.csv';
                        exportToCSV(url, fileName);
                    }
                }]
            });
        }

        function passengerDatatable() {
            const columns = [{
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
            const url = $('#list_url').val();
            const agent_id = $('#agent_id').val();
            const subagent_id = $('#subagent_id').val();
            if ($.fn.DataTable.isDataTable('#datatable_agent_passenger')) {
                $('#datatable_agent_passenger').DataTable().destroy();
            }

            const data = {
                agent_id,
                subagent_id
            };

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
                    // exportOptions: typeof exportOptions !== 'undefined' && exportOptions ? exportOptions : {}
                    action: function(e, dt, button, config) {
                        const url =
                            "{{ route('admin.passengers.all.csv', ['user_id' => $agent->id]) }}";
                        exportToCSV(url, 'passengers.csv');
                    }
                }]
            });
        }

        $(document).ready(function() {
            passengerDatatable();
            agentDatatable();
        });

        // const exportOptions = {
        //     columns: [0, 1, 2, 4] // Specify the columns to include in the CSV export
        // }
    </script>
@endsection
