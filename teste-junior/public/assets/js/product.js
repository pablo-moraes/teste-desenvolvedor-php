const alertElement = $("#alert");
const parameter = location.href.split('/');
const form = $("#productForm");

let productDatatable;
$(document).ready(() => {
     productDatatable = renderTable();
    addMask();
});

const updateProduct = () => {
    const payload = getPayload(form);

    product.update({...payload})
        .then(response => {
            const {message, type} = response;

            if (type === 'success') {
                alertElement.attr('class', 'alert alert-success');
                alertElement.append().html(`<span>${message}</span>`);

                setTimeout(() => {
                    window.location.href = location.origin + '/product';
                }, 1000);
            }
        })
        .catch(error => {
            const {message} = error
            alertElement.attr('class', 'alert alert-danger');
            alertElement.append().html(`<span>${message}</span>`);
        });
}

const storeProduct = () => {
    const payload = getPayload(form);
    product.store({...payload})
        .then(response => {
            const {message} = response;

            showAlert()
            alertElement.attr('class', 'alert alert-success');
            alertElement.append().html(`<span>${message}</span>`);

                setTimeout(() => {
                    window.location.href = location.origin + '/product';
                }, 2000);
        })
        .catch(error => {
            const {message} = error;
            alertElement.addClass('alert-danger')
            alertElement.append().html(`<span>${message}</span>`);
        });
}

const deleteProduct = () => {
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

// Global function, because I can't reach the method
window.showDeleteConfirmation = el => {
    $("#productId").val(el.value);
    confirmDeletionModal.show();
}

const renderTable = () => {
    return $("#products-table").DataTable({
        ajax: location.origin + "/api/product",
        searching: true,
        processing: true,
        serverSide: true,
        pageLength: 20,
        "lengthMenu": [[20, 25, 50, 100], [20, 25, 50, 100]],
        columnDefs: [
            {width: "15%", target: 3},
            {width: "fit-content", target: 2}
        ],
        columns: [
            {data: 'name'},
            {data: 'bar_code'},
            {data: 'price'},
            {data: 'actions', orderable: false},
        ]
    });
}

const fillOutForm = product => {
    $("#codeInput").val(product.bar_code);
    $("#nameInput").val(product.name);
    $("#priceInput").val(product.price);
    $("#productId").val(product.uuid);
}

const addMask = () => {
    $('.money').mask('R$ #.##0,00', {
        reverse: true, translation: {
            '0': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
}

if (parameter.length > 5) {
    product.get(parameter[4])
        .then(response => {
            const {product} = response;
            fillOutForm(product);
        });
}

let confirmDeletionModal;
if (document.getElementById('deleteProductDialog')) {
    confirmDeletionModal = new Modal(document.getElementById('deleteProductDialog'), {
        keyboard: false
    })
}


const toast = (type = 'success', message = 'Your work has been saved', timer = 1500) => {
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: timer
    })
}

const getPayload = form => {
    return form.serializeArray().reduce((acc, item) => {
        acc[item.name] = item.value;
        return acc
    }, {});
}

//Events
$("form").on('submit', event => {
    event.preventDefault();
})

$("#btn-update").on('click', function () {
    updateProduct();
});

$("#btn-create").on('click', function () {
    storeProduct();
});

$("#deleteProductForm button").on('click', function () {
    deleteProduct();
});

// Form Validation
(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()
