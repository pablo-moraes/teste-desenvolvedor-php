@section('btn-route', route('create_customer_form'))
@section('btn-text', 'New Customer')
<x-table id="customersTable" model="customers">
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
