@extends('backend.layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Agent Account Details</h3>
                        <button data-id="{{ $id }}" class="btn btn-secondary create-new btn-primary crudPrintBtn"
                            type="button">
                            <span>
                                <span class="d-none d-sm-inline-block">Print</span>
                            </span>
                        </button>
                    </div>
                    <input type="hidden" id="print_url" value="{{ route('admin.accounts.agent.print') }}">
                    <div class="card-body">
                        @if ($agent->role == 2)
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Total Contact Amount:</strong></div>
                                <div class="col-md-6">{{ $total_contact_amount }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Total Deposit Amount:</strong></div>
                                <div class="col-md-6">{{ $total_deposit_amount }}</div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Total Due Amount:</strong></div>
                            <div class="col-md-6">{{ $total_due_amount }}</div>
                        </div>

                        @if ($agent->role == 2)
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Total Discount Amount:</strong></div>
                                <div class="col-md-6">{{ $total_discount_amount }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Total Return Amount:</strong></div>
                                <div class="col-md-6">{{ $total_return_amount }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


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
    </div>


    <input type="hidden" id="create_url" value="{{ route('admin.passengers.create') }}">
    <input type="hidden" id="store_url" value="{{ route('admin.passengers.store') }}">
    <input type="hidden" id="list_url" value="{{ route('admin.passengers.list') }}">
    <input type="hidden" id="subagent_list_url" value="{{ route('admin.agents.list', ['role' => 3]) }}">
    <input type="hidden" id="delete_url" value="{{ route('admin.passengers.delete') }}">
    <input type="hidden" id="print_url" value="{{ route('admin.passengers.print') }}">
    <input type="hidden" id="status_url" value="{{ route('admin.passengers.status') }}">
    <input type="hidden" id="edit_url" value="{{ route('admin.passengers.edit') }}">
    <input type="hidden" id="update_url" value="{{ route('admin.passengers.update') }}">
    @if ($agent->role == 2)
        <input type="hidden" id="agent_id" value="{{ $agent->id }}">
    @endif
    @if ($agent->role == 3)
        <input type="hidden" id="subagent_id" value="{{ $agent->id }}">
    @endif

    <!-- Modal -->
    <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">

    </div>
@endsection
@section('js')
    <script>
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
                    exportOptions: typeof exportOptions !== 'undefined' && exportOptions ?
                        exportOptions : {}
                }]
            });
        }

        $(document).ready(function() {
            passengerDatatable();
        });

        // const exportOptions = {
        //     columns: [0, 1, 2, 4] // Specify the columns to include in the CSV export
        // }
    </script>
@endsection
