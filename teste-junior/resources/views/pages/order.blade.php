@php
    $showForm = Route::is('update_order_form') || Route::is('create_order_form');
@endphp
@extends('layouts.app')

@section('title', 'Orders')
@section('content')
    @includeWhen($showForm, 'forms.order')
    @includeUnless($showForm, 'datatables.order-table')

    @if(!$showForm)
        <x-confirmation-modal id="deleteRegister" :title="'Delete Orders'">
            <x-slot:text>
                Are you sure you want to remove the selected order?
            </x-slot:text>

            <x-slot:button>
                <form id="deleteOrderForm">
                    @csrf
                    <input type="hidden" name="uuid" value="" id="orderId">
                    <button type="button" class="btn btn-primary">Remove</button>
                </form>
            </x-slot:button>
        </x-confirmation-modal>
    @endif
@endsection

@push('scripts')
    @vite(public_path('assets/js/order.js'))
@endpush
