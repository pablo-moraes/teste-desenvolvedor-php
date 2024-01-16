@php
    $updatePath = isUpdatePath("order");
@endphp

<div class="d-flex align-items-baseline justify-content-between mb-4 p-2">
    <h3 class="fw-bold">
        {{ $updatePath ? "Update Order" : "Create Order" }}
    </h3>


    <h6 class="fw-normal"><a class="text-decoration-none" href="{{ route('view_orders') }}">Back</a></h6>
</div>

<form class="mx-2 mx-md-4 mx-xxl-5 needs-validation" id="orderForm" novalidate>
    @csrf

    @if($updatePath)
        <input type="hidden" name="uuid" id="orderId">
    @endif

    <div class="row my-2">
        <div class="form-group col-md-6 has-validation">
            <label for="customerInput">Customer</label>
            <select class="form-select custom-select" id="customerInput" name="customer_id" required>
                <option selected class="text-muted">Search Customer</option>
            </select>
            <div class="invalid-feedback">
                Please select a product
            </div>
        </div>
        <div class="form-group col-md-6 has-validation">
            <label for="productInput">Product</label>
            <select class="form-select custom-select" id="productInput" name="product_id" required>
                <option selected class="text-muted">Search Product</option>
            </select>
            <div class="invalid-feedback">
                Please select a product
            </div>
        </div>
    </div>
    <div class="form-group has-validation">
        <label for="quantityInput">Quantity</label>
        <input type="number" class="form-control" id="quantityInput" name="quantity" placeholder="Enter the quantity" required>
        <div class="invalid-feedback">
            Please enter the quantity
        </div>
    </div>
    <div class="form-group my-3">
        @unless($updatePath)
            <button class="btn btn-primary" id="btn-create">Submit</button>
        @else
            <button class="btn btn-primary" id="btn-update">Update Order</button>
        @endif
    </div>

    <div class="alert" role="alert" id="alert">

    </div>
</form>
