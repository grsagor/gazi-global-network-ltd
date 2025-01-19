@extends('backend.layout.app')
@section('content')
    <div class="card">
        <input type="hidden" id="agent_list_url" value="{{ route('admin.accounts.agent.list') }}">
        <div class="datatable-header flex-column flex-md-row pb-0">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Agent Accounts</h5>
            </div>
        </div>
        <table id="agent_datatable" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact Amount</th>
                    <th>Deposit Amount</th>
                    <th>Due Amount</th>
                    <th>Discount Amount</th>
                    <th>Return Amount</th>
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
        function mainDatatable() {
            const columns = [{
                    data: 'label',
                    name: 'label'
                },
                {
                    data: 'value',
                    name: 'value'
                }
            ]
            const url = $('#main_list_url').val();
            console.log('url', url)
            if ($.fn.DataTable.isDataTable('#main_datatable')) {
                $('#main_datatable').DataTable().destroy();
            }

            const data = {};

            $('#main_datatable').DataTable({
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
                lengthMenu: [10, 25, 50, 100],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"Bf>>' +
                    'rtip',
                buttons: [{
                    extend: 'csv',
                    text: 'Export CSV',
                    className: 'btn btn-primary',
                    exportOptions: typeof exportOptions !== 'undefined' && exportOptions ?
                        exportOptions : {}
                }]
            }).on('draw', function() {
                $('.bootstrap4-toggle').bootstrapToggle();
            });
        }
        function agentDatatable() {
            const columns = [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'contact_amount',
                    name: 'contact_amount'
                },
                {
                    data: 'deposit_amount',
                    name: 'deposit_amount'
                },
                {
                    data: 'due_amount',
                    name: 'due_amount'
                },
                {
                    data: 'discount_amount',
                    name: 'discount_amount'
                },
                {
                    data: 'return_amount',
                    name: 'return_amount'
                },
            ]
            const url = $('#agent_list_url').val();
            console.log('url', url)
            if ($.fn.DataTable.isDataTable('#agent_datatable')) {
                $('#agent_datatable').DataTable().destroy();
            }

            const data = {};

            $('#agent_datatable').DataTable({
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
                lengthMenu: [10, 25, 50, 100],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"Bf>>' +
                    'rtip',
                buttons: [{
                    extend: 'csv',
                    text: 'Export CSV',
                    className: 'btn btn-primary',
                    exportOptions: typeof exportOptions !== 'undefined' && exportOptions ?
                        exportOptions : {}
                }]
            }).on('draw', function() {
                $('.bootstrap4-toggle').bootstrapToggle();
            });
        }

        $(document).ready(function() {
            mainDatatable();
            agentDatatable();
        });
    </script>
@endsection
