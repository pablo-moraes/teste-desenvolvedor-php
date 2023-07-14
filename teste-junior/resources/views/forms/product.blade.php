<div class="d-flex align-items-baseline justify-content-between mb-4 p-2">
    <h3 class="fw-bold">
        {{ isUpdateRoute("product") ? "Update" : "Create" }} Product
    </h3>



    <h6 class="fw-normal"><a class="text-decoration-none" href="{{ route('view_products') }}">Back</a></h6>
</div>

<form class="mx-2 mx-md-4 mx-xxl-5 needs-validation" id="productForm" novalidate>
    @csrf

    @if(isUpdateRoute("product"))<input type="hidden" name="uuid" id="productId">@endif
    <div class="form-group">
        <label for="nameInput">Name</label>
        <input type="text" class="form-control" id="nameInput" name="name" placeholder="Name">
    </div>
    <div class="row my-2">
        <div class="form-group col-md-6 has-validation">
            <label for="codeInput">Bar Code</label>
            <input type="text" class="form-control" id="codeInput" name="bar_code" placeholder="000.000-##" required>
            <div class="invalid-feedback">
                Please enter with a barcode
            </div>
        </div>
        <div class="form-group col-md-6 has-validation">
            <label for="priceInput">Price</label>
            <input type="text" class="form-control money" id="priceInput" name="price" placeholder="R$ 0,00" required>
            <div class="invalid-feedback">
                Please enter with a price
            </div>
        </div>
    </div>
    <div class="form-group my-3">
        <button class="btn btn-primary" id="{{ isUpdateRoute("product") ? 'btn-update' : 'btn-create' }}">
            {{ isUpdateRoute("product") ? 'Update Product' : 'Submit' }}
        </button>
    </div>

    <div class="alert" role="alert" id="alert">

    </div>
</form>
