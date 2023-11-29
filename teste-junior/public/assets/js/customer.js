const alertElement = $("#alert");
const parameter = location.href.split('/');
const form = $("#customerForm");
const {customer} = window.instances;

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

    customer.update({...payload})
        .then(response => {
            const {message, type} = response;

            if (type === 'success') {
                alertElement.attr('class', 'alert alert-success');
                alertElement.append().html(`<span>${message}</span>`);

                setTimeout(() => {
                    window.location.href = location.origin + '/customer';
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
    customer.store({...payload})
        .then(response => {
            const {message} = response;

            showAlert()
            alertElement.attr('class', 'alert alert-success');
            alertElement.append().html(`<span>${message}</span>`);

            setTimeout(() => {
                window.location.href = location.origin + '/customer';
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

    customer.delete(payload)
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                toast(type, message);
                $("#btnCloseModal").click();
                customerDatatable.clear().draw();
            }
        })
        .catch(err => {
            console.log(err);
        })
}

// Global function, because I can't reach the method
window.showDeleteConfirmation = el => {
    $("#customerId").val(el.value);
    confirmDeletionModal.show();
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

const fillOutForm = customer => {
    $("#docInput").val(customer.document);
    $("#nameInput").val(customer.name);
    $("#mailInput").val(customer.email);
    $("#customerId").val(customer.uuid);
}

if (parameter.length > 5) {
    customer.get(parameter[4])
        .then(response => {
            const {customer} = response;
            console.log(response);
            fillOutForm(customer);
        });
}

let confirmDeletionModal;
if (document.getElementById('deleteCustomerDialog')) {
    confirmDeletionModal = new Modal(document.getElementById('deleteCustomerDialog'), {
        keyboard: false
    })
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
