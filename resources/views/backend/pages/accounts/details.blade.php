@extends('backend.layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Agent Account Details</h3>
                        <button data-id="{{ $id }}" class="btn btn-secondary create-new btn-primary crudPrintBtn" type="button">
                            <span>
                                <span class="d-none d-sm-inline-block">Print</span>
                            </span>
                        </button>
                    </div>
                    <input type="hidden" id="print_url" value="{{ route('admin.accounts.agent.print') }}">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Total Contact Amount:</strong></div>
                            <div class="col-md-6">{{ $total_contact_amount }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Total Deposit Amount:</strong></div>
                            <div class="col-md-6">{{ $total_deposit_amount }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Total Due Amount:</strong></div>
                            <div class="col-md-6">{{ $total_due_amount }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Total Discount Amount:</strong></div>
                            <div class="col-md-6">{{ $total_discount_amount }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Total Return Amount:</strong></div>
                            <div class="col-md-6">{{ $total_return_amount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
