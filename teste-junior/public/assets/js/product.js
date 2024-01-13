const alertElement = $("#alert");
const parameter = location.href.split('/');
const form = $("#productForm");
const {product} = window.instances;

let productDatatable;
$(document).ready(() => {
    productDatatable = renderTable();
    addMask();
});

$('#searchBar').on('keyup', function () {
    setTimeout(() => {
        productDatatable.search(this.value).draw();
    }, 1000);
});

$('#showEntriesBtn').on('change', function () {
    productDatatable.page.len(this.value).draw();
});

const update = () => {
    const payload = getPayload(form);

    product.update({...payload})
        .then(response => {
            const {message, type} = response;

            if (type === 'success') {
                alertElement.attr('class', 'alert alert-success');
                alertElement.append().html(`<span>${message}</span>`);

                setTimeout(() => {
                    goTo('product');
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
    product.store({...payload})
        .then(response => {
            const {message} = response;

            showAlert()
            alertElement.attr('class', 'alert alert-success');
            alertElement.append().html(`<span>${message}</span>`);

            setTimeout(() => {
                goTo('product');
            }, 2000);
        })
        .catch(error => {
            const {message} = error;
            alertElement.addClass('alert-danger')
            alertElement.append().html(`<span>${message}</span>`);
        });
}

const destroy = () => {
    const form = $("#deleteProductForm");
    const payload = getPayload(form);

    product.delete(payload)
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                toast(type, message);
                $("#btnCloseModal").click();
                productDatatable.clear().draw();
            }
        })
        .catch(err => {
            console.log(err);
        })
}

window.products = {};
window.products.multiDelete = () => {
    // Get all selected rows and return their ids as an array
    const rows = Array.from($("td input:checkbox:checked"), e => e.value);
    const payload = {
        uuids: rows
    }

    product.multiDelete(payload)
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                toast(type, message);
                $("#btnCloseModal").click();
                productDatatable.clear().draw();
            }
        })
        .catch(err => {
            console.log(err);
        });
}

// Global function, because I can't reach the method
window.showDeleteConfirmation = el => {
    $("#productId").val(el.value);
    confirmDeletionModal.show();
}

const renderTable = () => {
    return $("#productsTable").DataTable({
        ajax: location.origin + "/api/product",
        ...defaultDataSettings,
        columnDefs: [
            ...defaultDataSettings["columnDefs"],
            {width: "fit-content", targets: [2, 3]},
            {width: "10%", target: 4}
        ],
        columns: [
            {data: 'uuid', orderable: false, searchable: false},
            {data: 'name'},
            {data: 'bar_code'},
            {data: 'price'},
            {data: 'actions', orderable: false},
        ]
    });
}

const populateForm = product => {
    $("#codeInput").val(product.bar_code);
    $("#nameInput").val(product.name);
    $("#priceInput").val(product.price);
    $("#productId").val(product.uuid);
}

if (parameter.length > 5) {
    product.get(parameter[4])
        .then(response => {
            const {product} = response;
            populateForm(product);
        });
}

let confirmDeletionModal;
if (document.getElementById('deleteProductDialog')) {
    confirmDeletionModal = new Modal(document.getElementById('deleteProductDialog'), {
        keyboard: false
    })
}

$("#deleteProductForm button").on('click', function () {
    destroy();
});

$("#btn-update").on('click', function () {
    update();
});

$("#btn-create").on('click', function () {
    store();
});
