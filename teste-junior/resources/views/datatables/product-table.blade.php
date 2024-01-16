@section('btn-route', route('create_product_form'))
@section('btn-text', 'New Product')

<x-table id="productsTable" table="products">
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


{{-- Confirmation Modal --}}

<x-confirmation-modal id="productsTable" :showCount="true" :title="'Delete Products'">
    <x-slot:button>
        <button type="button" class="btn btn-primary" onclick="window.orders.multiDelete()">Remove</button>
    </x-slot:button>
</x-confirmation-modal>
