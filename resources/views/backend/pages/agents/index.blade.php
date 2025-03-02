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
                <label for="filter_company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="filter_company_name" placeholder="Company Name">
            </div>
            <div class="mb-3 col-3">
                <label for="filter_agent_id" class="form-label">AgentID</label>
                <input type="text" class="form-control" id="filter_id" placeholder="AgentID">
            </div>
            <div class="mb-3 col-3">
                <label for="filter_nid" class="form-label">NID</label>
                <input type="text" class="form-control" id="filter_nid" placeholder="NID">
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-danger" id="clear_btn">Clear</button>
            <button type="button" class="btn btn-primary" id="filter_btn">Filter</button>
        </div>
    </div>
    <div class="card">
        <input type="hidden" id="create_url" value="{{ route('admin.agents.create', ['role' => $role]) }}">
        <input type="hidden" id="store_url" value="{{ route('admin.agents.store', ['role' => $role]) }}">
        <input type="hidden" id="list_url" value="{{ route('admin.agents.list', ['role' => $role]) }}">
        <input type="hidden" id="edit_url" value="{{ route('admin.agents.edit', ['role' => $role]) }}">
        <input type="hidden" id="update_url" value="{{ route('admin.agents.update', ['role' => $role]) }}">
        <input type="hidden" id="delete_url" value="{{ route('admin.agents.delete', ['role' => $role]) }}">
        <input type="hidden" id="status_url" value="{{ route('admin.agents.status', ['role' => $role]) }}">
        <div class="datatable-header flex-column flex-md-row pb-0">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">
                    {{ $role == '2' ? 'Agents' : '' }}
                    {{ $role == '3' ? 'Sub Agents' : '' }}
                </h5>
            </div>
            <div class="dt-action-buttons text-end pt-6 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button id="crudCreateBtn" class="btn btn-secondary create-new btn-primary" type="button">
                        <span><i class="bx bx-plus bx-sm me-sm-2"></i>
                            <span class="d-none d-sm-inline-block">Add</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <table id="datatable" class="table table-hover" style="width:100%">
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
                            const role = "{{ $role }}"
                            const url = @json(route('admin.agents.all.csv', ['role' => $role]));
                            let fileName = 'ggnl.csv';
                            if (role == 2) {
                                fileName = 'agents.csv';
                            } else if(role == 3) {
                                fileName = 'sub_agents.csv';
                            }
                            exportToCSV(url, fileName);
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
                const passport = $('#filter_passport').val();
                const company = $('#filter_company_name').val();
                const id = $('#filter_id').val();
                const nid = $('#filter_nid').val();

                const data = {
                    name,
                    passport,
                    company,
                    id,
                    nid
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
            $('#filter_id').val('');
            $('#filter_nid').val('');
            initializeDatatable();
        })
    </script>
@endsection
