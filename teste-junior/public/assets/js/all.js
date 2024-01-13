const addMask = () => {
    $('.money').mask('R$ #.##0,00', {
        reverse: true, translation: {
            '0': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
}

const toast = (type = 'success', message = 'Your work has been saved', timer = 1500) => {
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: timer
    });
}

/**
 * Takes the user to the specifiec path
 * @param page path specified
 */
const goTo = (page = 'home') => {
    window.location.href = location.origin + `/${page}`;
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
