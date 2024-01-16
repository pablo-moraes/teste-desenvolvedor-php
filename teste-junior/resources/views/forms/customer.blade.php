@php
    $updatePath = isUpdatePath("customer");
@endphp

<div class="d-flex align-items-baseline justify-content-between mb-4 p-2">
    <h3 class="fw-bold">
        {{ $updatePath ? "Update Customer" : "Create Customer" }}
    </h3>


    <h6 class="fw-normal"><a class="text-decoration-none" href="{{ route('view_customers') }}">Back</a></h6>
</div>

<form class="mx-2 mx-md-4 mx-xxl-5 needs-validation" id="customerForm" novalidate>
    @csrf

    @if($updatePath)
        <input type="hidden" name="uuid" id="customerId">
    @endif

    <div class="form-group">
        <label for="nameInput">Name</label>
        <input type="text" class="form-control" id="nameInput" name="name" placeholder="Name">
    </div>
    <div class="row my-2">
        <div class="form-group col-md-6 has-validation">
            <label for="mailInput">E-mail</label>
            <input type="email" class="form-control" id="mailInput" name="email" placeholder="example@email.com"
                   required>
            <div class="invalid-feedback">
                Please enter with a valid email address
            </div>
        </div>
        <div class="form-group col-md-6 has-validation">
            <label for="docInput">CPF</label>
            <input type="text" class="form-control" id="docInput" name="document" placeholder="000.000-##" required>
            <div class="invalid-feedback">
                Please enter with your document
            </div>
        </div>
    </div>
    <div class="form-group my-3">
        @unless($updatePath)
            <button class="btn btn-primary" id="btn-create">Submit</button>
        @else
            <button class="btn btn-primary" id="btn-update">Update Customer</button>
        @endif
    </div>
</form>
