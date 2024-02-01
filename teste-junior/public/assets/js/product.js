import { ApiManager } from "@/app.js";

const parameter = location.href.split('/');
const form = $("#productForm");
const crudClient = ApiManager.general;

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

    crudClient.update({...payload}, 'product')
        .then(response => {
            const {message, type} = response;

            if (type === 'success') {
                showAlert(type, message);
                goTo('product');
            }
        })
        .catch(error => {
            const {message} = error
            showAlert('error',message)
        });
}

const store = () => {
    const payload = getPayload(form);
    crudClient.save({...payload}, 'product')
        .then(response => {
            const {type, message} = response;
            showAlert(type, message)
            goTo('product', 2000);
        })
        .catch(error => {
            const {type, message} = error;
            showAlert(type, message);
        });
}

const destroy = () => {
    const form = $("#deleteProductForm");
    const payload = getPayload(form);

    crudClient.delete(payload, 'product')
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                showAlert(type, message);
                confirmDeletionModal.hide();
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

    crudClient.multiDelete(payload, 'product')
        .then(response => {
            const {message, type} = response;
            if (type === 'success') {
                showAlert(type, message);

                $("#btnCloseModal").click();
                productDatatable.clear().draw();
            }
        })
        .catch(err => {
            const {type, message} = err;
            showAlert(type, message);
        });
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
    crudClient.get(parameter[4], 'product')
        .then(response => {
            const {product, type, message} = response;
            showAlert(type, message);
            populateForm(product);
        });
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
