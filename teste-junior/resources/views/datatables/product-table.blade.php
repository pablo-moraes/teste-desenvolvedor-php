@section('btn-route', route('create_product_form'))
@section('btn-text', 'New Product')

<x-table id="productsTable">
    <x-slot:header>
        <tr class="text-start">
            <th scope="col"><input class="form-check-input" type="checkbox" id="checkAll"></th>
            <th scope="col">Name</th>
            <th scope="col">Bar code</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </x-slot:header>
</x-table>
