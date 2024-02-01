@extends('layouts.app')
@php    $showForm = Route::is('update_product_form') || Route::is('create_product_form'); @endphp

@section('title', 'Products')
@section('content')

    @includeWhen($showForm, 'forms.product')
    @includeUnless($showForm, 'datatables.product-table')

    @if(!$showForm)
        <x-confirmation-modal id="deleteRegister" :title="'Delete Product'">

            <x-slot:text>
                Are you sure you want to remove the selected product?
            </x-slot:text>

            <x-slot:button>
                <form id="deleteProductForm">
                    @csrf
                    <input type="hidden" name="uuid" value="" id="productId">
                    <button type="button" class="btn btn-primary">Remove</button>
                </form>
            </x-slot:button>
        </x-confirmation-modal>
    @endif
@endsection

@push('scripts')
    @vite(public_path('assets/js/product.js'))
@endpush
