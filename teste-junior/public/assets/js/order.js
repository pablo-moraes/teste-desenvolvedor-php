const alertElement = $("#alert");
const parameter = location.href.split('/');
const form = $("#orderForm");
const {order} = window.instances;

let orderDatatable;
$(document).ready(() => {
    orderDatatable = renderTable();
    addMask();
});

$('#searchBar').on('keyup', function() {
    setTimeout(() => {
        orderDatatable.search(this.value).draw();
    }, 1000);
});

$('#showEntriesBtn').on('change', function() {
    orderDatatable.page.len(this.value).draw();
});

const update = () => {
    const payload = getPayload(form);
    console.log(payload);
    order.update({...payload})
        .then(response => {
            const {message, type} = response;

            if (type === 'success') {
                alertElement.attr('class', 'alert alert-success');
                alertElement.append().html(`<span>${message}</span>`);

                setTimeout(() => {
                    goTo('order');
                }, 1000);
            }
        })
        .catch(error => {
            const {message} = error
            alertElement.attr('class', 'alert alert-danger');
            alertElement.append().html(`<span>${message}</span>`);
        });
}

const store = () => {
    const payload = getPayload(form);
    order.store({...payload})
        .then(response => {
            const {message} = response;

            showAlert()
            alertElement.attr('class', 'alert alert-success');
            alertElement.append().html(`<span>${message}</span>`);

            setTimeout(() => {
                goTo('order');
            }, 2000);
        })
        .catch(error => {
            const {message} = error;
            alertElement.addClass('alert-danger')
            alertElement.append().html(`<span>${message}</span>`);
        });
}

const destroy = () => {
    const form = $("#deleteOrderForm");
    const payload = getPayload(form);

    order.delete(payload)
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                toast(type, message);
                $("#btnCloseModal").click();
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

    order.multiDelete(payload)
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                toast(type, message);
                $("#btnCloseModal").click();
                orderDatatable.clear().draw();
            }
        })
        .catch(err => {
            console.log(err);
        });
}

// Global function, because I can't reach the method
window.showDeleteConfirmation = el => {
    $("#orderId").val(el.value);
    confirmDeletionModal.show();
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
    order.get(parameter[4])
        .then(response => {
            const {order} = response;
            populateForm(order);

            // append selected values to determined select elements
            appendOption("customerInput", order.customer);
            appendOption("productInput", order.product);
        });
}

let confirmDeletionModal;
if (document.getElementById('deleteOrderDialog')) {
    confirmDeletionModal = new Modal(document.getElementById('deleteOrderDialog'), {
        keyboard: false
    })
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
