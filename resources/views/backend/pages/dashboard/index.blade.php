@extends('backend.layout.app')
@section('content')
    <div class="w-100 overflow-hidden">
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
                        <p class="mb-1">Total Passengers</p>
                        <h4 class="card-title mb-3">{{ $total_passengers }}</h4>
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
                        <p class="mb-1">Request for onlist</p>
                        <h4 class="card-title mb-3">{{ $request_onlisted_passengers }}</h4>
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
                        <p class="mb-1">Onlisted</p>
                        <h4 class="card-title mb-3">{{ $onlisted_passengers }}</h4>
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
                        <p class="mb-1">Not submitted</p>
                        <h4 class="card-title mb-3">{{ $not_submitted_passengers }}</h4>
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
                        <p class="mb-1">Submitted</p>
                        <h4 class="card-title mb-3">{{ $submitted_passengers }}</h4>
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
                        <p class="mb-1">Pending</p>
                        <h4 class="card-title mb-3">{{ $pending_passengers }}</h4>
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
                        <p class="mb-1">Ready for submission</p>
                        <h4 class="card-title mb-3">{{ $ready_for_submission_passengers }}</h4>
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
                        <p class="mb-1">Additional docs require</p>
                        <h4 class="card-title mb-3">{{ $additional_doc_required_passengers }}</h4>
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
                        <p class="mb-1">Hold</p>
                        <h4 class="card-title mb-3">{{ $hold_passengers }}</h4>
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
                        <p class="mb-1">Permit</p>
                        <h4 class="card-title mb-3">{{ $permit_passengers }}</h4>
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
                        <p class="mb-1">Stamping done</p>
                        <h4 class="card-title mb-3">{{ $stamping_done_passengers }}</h4>
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
                        <p class="mb-1">Rejected</p>
                        <h4 class="card-title mb-3">{{ $rejected_passengers }}</h4>
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
                        <p class="mb-1">Resubmit</p>
                        <h4 class="card-title mb-3">{{ $resubumit_passengers }}</h4>
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
                        <p class="mb-1">Return</p>
                        <h4 class="card-title mb-3">{{ $return_passengers }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card overflow-auto">
            <input type="hidden" id="agent_list_url" value="{{ route('admin.accounts.agent.list') }}">
            <div class="datatable-header flex-column flex-md-row pb-0">
                <div class="head-label text-center">
                    <h5 class="card-title mb-0">Countries Data</h5>
                </div>
            </div>
            <table id="country_datatable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>SI</th>
                        <th>Country Name</th>
                        <th>Total Passengers</th>
                        <th>Request Onlisted</th>
                        <th>Onlisted</th>
                        <th>Not Submitted</th>
                        <th>Submitted</th>
                        <th>Pending</th>
                        <th>Ready for Submission</th>
                        <th>Additional Doc Required</th>
                        <th>Hold</th>
                        <th>Permit</th>
                        <th>Stamping Done</th>
                        <th>Rejected</th>
                        <th>Resubmit</th>
                        <th>Return</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#country_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.dashboard.countries.list') }}",
            columns: [
                {
                data: null,
                name: 'index',
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Generates 1, 2, 3, ...
                },
                orderable: false, // Index should not be sortable
                searchable: false
            },
                { data: 'country_name', name: 'country_name' },
                { data: 'total_passengers', name: 'total_passengers' },
                { data: 'request_onlisted_passengers', name: 'request_onlisted_passengers' },
                { data: 'onlisted_passengers', name: 'onlisted_passengers' },
                { data: 'not_submitted_passengers', name: 'not_submitted_passengers' },
                { data: 'submitted_passengers', name: 'submitted_passengers' },
                { data: 'pending_passengers', name: 'pending_passengers' },
                { data: 'ready_for_submission_passengers', name: 'ready_for_submission_passengers' },
                { data: 'additional_doc_required_passengers', name: 'additional_doc_required_passengers' },
                { data: 'hold_passengers', name: 'hold_passengers' },
                { data: 'permit_passengers', name: 'permit_passengers' },
                { data: 'stamping_done_passengers', name: 'stamping_done_passengers' },
                { data: 'rejected_passengers', name: 'rejected_passengers' },
                { data: 'resubmit_passengers', name: 'resubmit_passengers' },
                { data: 'return_passengers', name: 'return_passengers' }
            ]
        });
    });
    </script>
@endsection
