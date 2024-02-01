const addMask = () => {
    $('.money').mask('R$ #.##0,00', {
        reverse: true, translation: {
            '0': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
}

const showAlert = (type = 'success', message = 'Your work has been saved', timer = 1500) => {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: timer
    });
}

const getPayload = form => {
    return form.serializeArray().reduce((acc, item) => {
        acc[item.name] = item.value;
        return acc
    }, {});
}

/**
 * Takes the user to the specifiec path
 * @param page path specified
 * @param delay to redirect
 */
const goTo = (page = 'home', delay = 1000) => {
    setTimeout(() => {
        window.location.href = location.origin + `/${page}`;
    }, delay);
}

const appendOption = (el, data) => {
    if ($(`#${el}`).find("option[value='" + data.uuid + "']").length) {
        $(`#${el}`).val(data.uuid).trigger('change');
    } else {
        // Create a DOM Option and pre-select by default
        var newOption = new Option(data.text, data.uuid, true, true);
        // Append it to the select
        $(`#${el}`).append(newOption).trigger('change');
    }
}

const showOrHidePassword = () => {
    $('.eye-icon').toggleClass('d-none');
    const inputPassword = $('#inputPasswd');
    if ($('.eye-icon.bi-eye-slash-fill').hasClass('d-none')) {
        return inputPassword.attr('type', 'password');
    }

    inputPassword.attr('type', 'text');
}

// Default configs for datatable instance
const defaultDataSettings = {
    processing: true,
    serverSide: true,
    aaSorting: [[1, 'asc']],
    "lengthMenu": [[20, 25, 50, 100], [20, 25, 50, 100]],
    dom: 'tipr',
    columnDefs: [
        {
            target: 0,
            className: "text-center",
            width: "5%",
            render: (data, type, row) =>
                `<input class="form-check-input checkboxes" type="checkbox" value="${data}" name="items">`
        }
    ],
};

let confirmDeletionModal;
if (document.getElementById('deleteRegisterModal')) {
    confirmDeletionModal = new Modal(document.getElementById('deleteRegisterModal'), {
        keyboard: false
    })
}

window.showDeleteConfirmation = (elementId, element) => {
    $(`#${elementId}`).val(element.value);
    confirmDeletionModal.show();
}
