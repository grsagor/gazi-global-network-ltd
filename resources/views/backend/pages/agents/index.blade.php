@extends('backend.layout.app')
@section('content')
    <div class="card">
        <input type="hidden" id="create_url" value="{{ route('admin.agents.create', ['role' => $role]) }}">
        <input type="hidden" id="store_url" value="{{ route('admin.agents.store', ['role' => $role]) }}">
        <input type="hidden" id="list_url" value="{{ route('admin.agents.list', ['role' => $role]) }}">
        <input type="hidden" id="edit_url" value="{{ route('admin.agents.edit', ['role' => $role]) }}">
        <input type="hidden" id="update_url" value="{{ route('admin.agents.update', ['role' => $role]) }}">
        <input type="hidden" id="delete_url" value="{{ route('admin.agents.delete', ['role' => $role]) }}">
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
                    <th>Name</th>
                    <th>Email</th>
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
                data: 'email',
                name: 'email'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            } // Action buttons
        ]
    </script>
@endsection
