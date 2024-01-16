@section('btn-route', route('create_order_form'))
@section('btn-text', 'New Order')
<x-table id="ordersTable">
    <x-slot:header>
        <tr class="text-start">
            <th scope="col"><input class="form-check-input" type="checkbox" id="checkAll"></th>
            <th scope="col">Customer</th>
            <th scope="col">Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </x-slot:header>
</x-table>

{{-- Confirmation Modal --}}

<x-confirmation-modal id="ordersTable" :showCount="true" :title="'Delete Orders'">
    <x-slot:button>
        <button type="button" class="btn btn-primary" onclick="window.orders.multiDelete()">Remove</button>
    </x-slot:button>
</x-confirmation-modal>
