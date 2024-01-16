@php
    $showForm = Route::is('update_customer_form') || Route::is('create_customer_form');
@endphp
@extends('layouts.app')

@section('title', 'Customers')
@section('content')
    @includeWhen($showForm, 'forms.customer')
    @includeUnless($showForm, 'datatables.customer-table')

    @if(!$showForm)
        <x-confirmation-modal id="deleteRegister" :title="'Delete Customer'">
            <x-slot:text>
                Are you sure you want to remove the selected customer?
            </x-slot:text>

            <x-slot:button>
                <form id="deleteCustomerForm">
                    @csrf
                    <input type="hidden" name="uuid" value="" id="customerId">
                    <button type="button" class="btn btn-primary">Remove</button>
                </form>
            </x-slot:button>
        </x-confirmation-modal>
    @endif
@endsection

@push('scripts')
    <script type="module" src="{{ asset('assets/js/customer.js') }}"></script>
@endpush
