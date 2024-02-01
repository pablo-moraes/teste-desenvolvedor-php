import {ApiManager} from "@/app.js";

const parameter = location.href.split('/');
const form = $("#orderForm");
const crudClient = ApiManager.general;

let orderDatatable;
$(document).ready(() => {
    orderDatatable = renderTable();
    addMask();
});

$('#searchBar').on('keyup', function () {
    setTimeout(() => {
        orderDatatable.search(this.value).draw();
    }, 1000);
});

$('#showEntriesBtn').on('change', function () {
    orderDatatable.page.len(this.value).draw();
});

const update = () => {
    const payload = getPayload(form);
    console.log(payload);
    crudClient.update({...payload}, 'order')
        .then(response => {
            const {type, message} = response;

            if (type === 'success') {
                showAlert(type, message);
                goTo('order');
            }
        })
        .catch(error => {
            const {type, message} = error
            showAlert(type, message)
        });
}

const store = () => {
    const payload = getPayload(form);
    crudClient.save({...payload}, 'order')
        .then(response => {
            const {type, message} = response;

            showAlert(type, message);
            goTo('order');
        })
        .catch(error => {
            const {type, message} = error;
            showAlert(type, message);
        });
}

const destroy = () => {
    const form = $("#deleteOrderForm");
    const payload = getPayload(form);

    crudClient.delete(payload, 'order')
        .then(response => {
            const {type, message} = response;
            if (type === 'success') {
                showAlert(type, message);
                confirmDeletionModal.hide();
                orderDatatable.clear().draw();
            }
        })
        .catch(err => {
            console.log(err);
        })
}

window.orders = {};
window.orders.multiDelete = () => {
    // Get all selected rows and return their ids as an array
    const rows = Array.from($("td input:checkbox:checked"), e => e.value);
    const payload = {
        uuids: rows
    }

    crudClient.multiDelete(payload, 'order')
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                showAlert(type, message);
                $("#btnCloseModal").click();
                orderDatatable.clear().draw();
            }
        })
        .catch(err => {
            console.log(err);
        });
}

const renderTable = () => {
    return $("#ordersTable").DataTable({
        ajax: location.origin + "/api/order",
        ...defaultDataSettings,
        columnDefs: [
            ...defaultDataSettings["columnDefs"],
            {width: "10%", target: 6},
            {
                target: 1,
                width: "fit-content",
                render: (data, type, row) =>
                    `<a href="${location.origin}/customer/${row.customer.uuid}/edit" target="_blank" class="text-decoration-none">${data}</a>`
            },
            {
                target: 2,
                width: "fit-content",
                render: (data, type, row) =>
                    `<a href="${location.origin}/product/${row.product.uuid}/edit" target="_blank" class="text-decoration-none">${data}</a>`
            }
        ],
        columns: [
            {data: 'uuid', orderable: false, searchable: false},
            {data: 'customer.name'},
            {data: 'product.name'},
            {data: 'quantity'},
            {data: 'total_price'},
            {data: 'created_at'},
            {data: 'actions', orderable: false},
        ]
    });
}

const populateForm = order => {
    $("#quantityInput").val(order.quantity);
    $("#orderId").val(order.uuid);
}

if (parameter.length > 5) {
    crudClient.get(parameter[4], 'order')
        .then(response => {
            const {order} = response;
            populateForm(order);

            // append selected values to determined select elements
            appendOption("customerInput", order.customer);
            appendOption("productInput", order.product);
        });
}

$("#deleteOrderForm button").on('click', function () {
    destroy();
});

$("#btn-update").on('click', function () {
    update();
});

$("#btn-create").on('click', function () {
    store();
});

$('#productInput').select2({
    theme: 'bootstrap-5',
    ajax: {
        delay: 500,
        type: 'POST',
        dataType: 'json',
        url: location.origin + '/api/product/search',
        data: function (params) {
            return {
                search: params.term,
                page: params.page || 1
            };
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            const body = data.body;
            const results = body.data;
            return {
                results: results,
                pagination: {
                    more: (params.page * 20) < body.total
                }
            };
        }
    }
});

$('#customerInput').select2({
    theme: 'bootstrap-5',
    ajax: {
        delay: 500,
        type: 'POST',
        dataType: 'json',
        url: location.origin + '/api/customer/search',
        data: function (params) {
            return {
                search: params.term,
                page: params.page || 1,
            };
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            const body = data.body;
            const results = body.data;
            return {
                results: results,
                pagination: {
                    more: (params.page * 20) < body.total
                }
            };
        }
    }
});
