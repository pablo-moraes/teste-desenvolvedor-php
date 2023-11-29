@php
    $showForm = Route::is('update_product_form') || Route::is('create_product_form');
@endphp
@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('title', 'Products')
@section('content')

    @if(!$showForm)
        @include('datatables.product-table')
        <!-- Modal -->
        <div class="modal fade" id="deleteProductDialog" tabindex="-1" aria-labelledby="deleteProductModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProductModal">Delete Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to remove the selected product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCloseModal">Close</button>
                        <form id="deleteProductForm">
                            @csrf
                            <input type="hidden" name="uuid" value="" id="productId">
                            <button type="button" class="btn btn-primary">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @includeWhen($showForm, 'forms.product')
@endsection

@push('scripts')
    <script type="module" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="module" src="{{ asset('assets/js/product.js') }}"></script>
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
