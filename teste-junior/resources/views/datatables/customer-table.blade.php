@section('btn-route', route('create_customer_form'))
@section('btn-text', 'New Customer')
<x-table id="customersTable" table="customers">
    <x-slot:header>
        <tr class="text-start">
            <th scope="col"><input class="form-check-input" type="checkbox" id="checkAll"></th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th>Document</th>
            <th>Actions</th>
        </tr>
    </x-slot:header>
</x-table>

{{-- Confirmation Modal --}}

<x-confirmation-modal id="customersTable" :showCount="true" :title="'Delete Customers'">
    <x-slot:button>
        <button type="button" class="btn btn-primary" onclick="window.customers.multiDelete()">Remove</button>
    </x-slot:button>
</x-confirmation-modal>
