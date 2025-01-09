@extends('backend.layout.app')
@section('content')
    <div class="card">
        <input type="hidden" id="create_url" value="{{ route('admin.passengers.create') }}">
        <input type="hidden" id="store_url" value="{{ route('admin.passengers.store') }}">
        <input type="hidden" id="list_url" value="{{ route('admin.passengers.list') }}">
        <input type="hidden" id="edit_url" value="{{ route('admin.passengers.edit') }}">
        <input type="hidden" id="update_url" value="{{ route('admin.passengers.update') }}">
        <input type="hidden" id="delete_url" value="{{ route('admin.passengers.delete') }}">
        <input type="hidden" id="print_url" value="{{ route('admin.passengers.print') }}">
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
        <table id="datatable" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>NID No.</th>
                    <th>Company Name</th>
                    <th>Contact Amount</th>
                    <th>Deposit Amount</th>
                    <th>Due Amount</th>
                    <th>Discount Amount</th>
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
                data: 'name',
                name: 'name'
            },
            {
                data: 'nid_no',
                name: 'nid_no'
            },
            {
                data: 'company_name',
                name: 'company_name'
            },
            {
                data: 'contact_amount',
                name: 'contact_amount'
            }, // Replace with your columns
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
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            } // Action buttons
        ]

        // const exportOptions = {
        //     columns: [0, 1, 2, 4] // Specify the columns to include in the CSV export
        // }
    </script>
@endsection
