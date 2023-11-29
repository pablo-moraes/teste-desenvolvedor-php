@php
    $showForm = Route::is('update_customer_form') || Route::is('create_customer_form');
@endphp
@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('title', 'Customers')
@section('content')

    @if(!$showForm)
        @include('datatables.customer-table')
        <!-- Modal -->
        <div class="modal fade" id="deleteCustomerDialog" tabindex="-1" aria-labelledby="deleteCustomerDialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCustomerModal">Delete Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to remove the selected customer?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="btnCloseModal">Close</button>
                        <form id="deleteCustomerForm">
                            @csrf
                            <input type="hidden" name="uuid" value="" id="customerId">
                            <button type="button" class="btn btn-primary">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @includeWhen($showForm, 'forms.customer')
@endsection

@push('scripts')
    <script type="module" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="module" src="{{ asset('assets/js/customer.js') }}"></script>
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
