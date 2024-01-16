const alertElement = $("#alert");
const parameter = location.href.split('/');
const form = $("#customerForm");
const crudClient = window.crudClient;

let customerDatatable;
$(document).ready(() => {
    customerDatatable = renderTable();
    addMask();
});

$('#searchBar').on('keyup', function() {
    setTimeout(() => {
        customerDatatable.search(this.value).draw();
    }, 1000);
});

$('#showEntriesBtn').on('change', function() {
    customerDatatable.page.len(this.value).draw();
});

const update =  () => {
    const payload = getPayload(form);

    crudClient.update({...payload}, 'customer')
        .then(response => {
            const {message, type} = response;

            if (type === 'success') {
                alertElement.attr('class', 'alert alert-success');
                alertElement.append().html(`<span>${message}</span>`);

                setTimeout(() => {
                    goTo('customer')
                }, 1000);
            }
        })
        .catch(error => {
            const {message} = error
            alertElement.attr('class', 'alert alert-danger');
            alertElement.append().html(`<span>${message}</span>`);
        });
}

const store =  () => {
    const payload = getPayload(form);
    crudClient.save({...payload}, 'customer')
        .then(response => {
            const {message} = response;

            showAlert()
            alertElement.attr('class', 'alert alert-success');
            alertElement.append().html(`<span>${message}</span>`);

            setTimeout(() => {
                goTo('customer');
            }, 2000);
        })
        .catch(error => {
            const {message} = error;
            alertElement.addClass('alert-danger')
            alertElement.append().html(`<span>${message}</span>`);
        });
}

const destroy = () => {
    const form = $("#deleteCustomerForm");
    const payload = getPayload(form);

    crudClient.delete(payload, 'customer')
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                showAlert(type, message);
                confirmDeletionModal.hide();
                customerDatatable.clear().draw();
            }
        })
        .catch(err => {
            console.log(err);
        })
}

window.customers = {};
window.customers.multiDelete = () => {
    // Get all selected rows and return their ids as an array
    const rows = Array.from($("td input:checkbox:checked"), e => e.value);
    const payload = {
        uuids: rows
    }

    crudClient.multiDelete(payload, 'customer')
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                showAlert(type, message);
                $("#btnCloseModal").click();
                customerDatatable.clear().draw();
            }
        })
        .catch(err => {
            console.log(err);
        });
}

const renderTable = () => {
    return $("#customersTable").DataTable({
        ajax: location.origin + "/api/customer",
        ...defaultDataSettings,
        columnDefs: [
            ...defaultDataSettings["columnDefs"],
            {width: "15%", target: 3},
            {width: "fit-content", target: 2},
            {width: "10%", target: 4}
        ],
        columns: [
            {data: 'uuid', orderable: false, searchable: false},
            {data: 'name'},
            {data: 'email'},
            {data: 'document'},
            {data: 'actions', orderable: false},
        ]
    });
}

const populateForm = customer => {
    $("#docInput").val(customer.document);
    $("#nameInput").val(customer.name);
    $("#mailInput").val(customer.email);
    $("#customerId").val(customer.uuid);
}

if (parameter.length > 5) {
    crudClient.get(parameter[4], 'customer')
        .then(response => {
            const {customer} = response;
            console.log(response);
            populateForm(customer);
        });
}

$("#deleteCustomerForm button").on('click', function () {
    destroy();
});

$("#btn-update").on('click', function () {
    update();
});

$("#btn-create").on('click', function () {
    store();
});
