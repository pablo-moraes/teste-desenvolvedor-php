@section('btn-route', route('create_product_form'))
@section('btn-text', 'New Product')
<div class="table-responsive">
    <table id="products-table" class="table table-bordered align-middle w-100 pt-3">
        <thead class="table-light">
        <tr class="text-start">
            <th scope="col">Name</th>
            <th scope="col">Bar code</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
