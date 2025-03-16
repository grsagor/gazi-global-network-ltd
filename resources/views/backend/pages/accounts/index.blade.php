@extends('backend.layout.app')
@section('content')
    <div class="w-100 overflow-hidden mb-5">
        <input type="hidden" id="paid_list_url" value="{{ route('admin.accounts.paid.list') }}">
        <input type="hidden" id="unpaid_list_url" value="{{ route('admin.accounts.unpaid.list') }}">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Contact Amount</p>
                        <h4 class="card-title mb-3">৳ {{ $total_contact_amount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="wallet info"
                                    class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Deposit Amount</p>
                        <h4 class="card-title mb-3">৳ {{ $total_deposit_amount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Due Amount</p>
                        <h4 class="card-title mb-3">৳ {{ $total_due_amount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="wallet info"
                                    class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Discount Amount</p>
                        <h4 class="card-title mb-3">৳ {{ $total_discount_amount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @if ($user->role == 1)
            <div class="row">
                <div class="col-6 overflow-hidden">
                    <div class="card overflow-auto">
                        <input type="hidden" id="agent_list_url" value="{{ route('admin.accounts.agent.list') }}">
                        <div class="datatable-header flex-column flex-md-row pb-0">
                            <div class="head-label text-center">
                                <h5 class="card-title mb-0">Top Paid Agents</h5>
                            </div>
                        </div>
                        <table id="paid_datatable" class="table table-hover" style="width:100%">
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
                </div>
                <div class="col-6 overflow-hidden">
                    <div class="card overflow-auto">
                        <input type="hidden" id="agent_list_url" value="{{ route('admin.accounts.agent.list') }}">
                        <div class="datatable-header flex-column flex-md-row pb-0">
                            <div class="head-label text-center">
                                <h5 class="card-title mb-0">Top Unpaid Agents</h5>
                            </div>
                        </div>
                        <table id="unpaid_datatable" class="table table-hover overflow-x-auto" style="width:100%">
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
                </div>
            </div>
        @endif
    </div>
    @if ($user->role == 1)
        <div class="card mb-5">
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
    @endif
    <div class="card">
        <input type="hidden" id="passenger_list_url" value="{{ route('admin.accounts.passenger.list') }}">
        <div class="datatable-header flex-column flex-md-row pb-0">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">Passenger Accounts</h5>
            </div>
        </div>
        <table id="passenger_datatable" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Passport No.</th>
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
        function agentDatatable() {
            const columns = [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'contact_amount',
                    name: 'contact_amount',
                    className: 'text-center',
                },
                {
                    data: 'deposit_amount',
                    name: 'deposit_amount',
                    className: 'text-center',
                },
                {
                    data: 'due_amount',
                    name: 'due_amount',
                    className: 'text-center',
                },
                {
                    data: 'discount_amount',
                    name: 'discount_amount',
                    className: 'text-center',
                },
                {
                    data: 'return_amount',
                    name: 'return_amount',
                    className: 'text-center',
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

        function passengerDatatable() {
            const columns = [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'passport_no',
                    name: 'passport_no',
                },
                {
                    data: 'contact_amount',
                    name: 'contact_amount',
                    className: 'text-center',
                },
                {
                    data: 'deposit_amount',
                    name: 'deposit_amount',
                    className: 'text-center',
                },
                {
                    data: 'due_amount',
                    name: 'due_amount',
                    className: 'text-center',
                },
                {
                    data: 'discount_amount',
                    name: 'discount_amount',
                    className: 'text-center',
                },
                {
                    data: 'return_amount',
                    name: 'return_amount',
                    className: 'text-center',
                },
            ]
            const url = $('#passenger_list_url').val();
            console.log('url', url)
            if ($.fn.DataTable.isDataTable('#passenger_datatable')) {
                $('#passenger_datatable').DataTable().destroy();
            }

            const data = {};

            $('#passenger_datatable').DataTable({
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
                    text: 'Export CSV', // Button text
                    className: 'btn btn-primary', // Add a custom class for styling
                    // exportOptions: typeof exportOptions !== 'undefined' && exportOptions ? exportOptions : {}
                    action: function(e, dt, button, config) {
                        const url = "{{ route('admin.accounts.passengers.all.csv') }}";
                        exportToCSV(url, 'passengers.csv');
                    }
                }]
            }).on('draw', function() {
                $('.bootstrap4-toggle').bootstrapToggle();
            });
        }

        $(document).ready(function() {
            agentDatatable();
            passengerDatatable();
        });
    </script>

    <script>
        function paidDatatable() {
            const columns = [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'contact_amount',
                    name: 'contact_amount',
                    className: 'text-center',
                },
                {
                    data: 'deposit_amount',
                    name: 'deposit_amount',
                    className: 'text-center',
                },
                {
                    data: 'due_amount',
                    name: 'due_amount',
                    className: 'text-center',
                },
                {
                    data: 'discount_amount',
                    name: 'discount_amount',
                    className: 'text-center',
                },
                {
                    data: 'return_amount',
                    name: 'return_amount',
                    className: 'text-center',
                },
            ]
            const url = $('#paid_list_url').val();
            console.log('url', url)
            if ($.fn.DataTable.isDataTable('#paid_datatable')) {
                $('#paid_datatable').DataTable().destroy();
            }

            const data = {};

            $('#paid_datatable').DataTable({
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
                ordering: false,
                info: true,
                lengthMenu: [10, 25, 50, 100],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"Bf>>' +
                    'rtip',
                buttons: []
            }).on('draw', function() {
                $('.bootstrap4-toggle').bootstrapToggle();
            });
        }

        function unpaidDatatable() {
            const columns = [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'contact_amount',
                    name: 'contact_amount',
                    className: 'text-center',
                },
                {
                    data: 'deposit_amount',
                    name: 'deposit_amount',
                    className: 'text-center',
                },
                {
                    data: 'due_amount',
                    name: 'due_amount',
                    className: 'text-center',
                },
                {
                    data: 'discount_amount',
                    name: 'discount_amount',
                    className: 'text-center',
                },
                {
                    data: 'return_amount',
                    name: 'return_amount',
                    className: 'text-center',
                },
            ]
            const url = $('#unpaid_list_url').val();
            console.log('url', url)
            if ($.fn.DataTable.isDataTable('#unpaid_datatable')) {
                $('#unpaid_datatable').DataTable().destroy();
            }

            const data = {};

            $('#unpaid_datatable').DataTable({
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
                ordering: false,
                info: true,
                lengthMenu: [10, 25, 50, 100],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"Bf>>' +
                    'rtip',
                buttons: []
            }).on('draw', function() {
                $('.bootstrap4-toggle').bootstrapToggle();
            });
        }

        $(document).ready(function() {
            paidDatatable();
            unpaidDatatable();
        });
    </script>
@endsection
