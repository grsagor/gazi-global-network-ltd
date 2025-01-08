@extends('backend.layout.app')
@section('content')
    <div class="card">
        <input type="hidden" id="create_url" value="{{ route('admin.agents.create') }}">
        <input type="hidden" id="store_url" value="{{ route('admin.agents.store') }}">
        <div class="datatable-header flex-column flex-md-row pb-0">
            <div class="head-label text-center">
                <h5 class="card-title mb-0">DataTable with Buttons</h5>
            </div>
            <div class="dt-action-buttons text-end pt-6 pt-md-0">
                <div class="dt-buttons btn-group flex-wrap">
                    <button id="create-btn" class="btn btn-secondary create-new btn-primary" type="button">
                        <span><i class="bx bx-plus bx-sm me-sm-2"></i>
                            <span class="d-none d-sm-inline-block">Add New Record</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <table id="datatable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011-04-25</td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>Garrett Winters</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                    <td>63</td>
                    <td>2011-07-25</td>
                    <td>$170,750</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">

    </div>
@endsection

@section('js')
@endsection
