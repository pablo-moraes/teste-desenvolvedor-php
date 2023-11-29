const addMask = () => {
    $('.money').mask('R$ #.##0,00', {
        reverse: true, translation: {
            '0': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
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

// Watch changes to update listable checkboxes
$("#checkAll").on('change', function (target) {
    const checkboxes = $(".main-table td input:checkbox");
    checkboxes.prop('checked', target.currentTarget.checked);
    checkboxes.trigger('change');
});

$(document).on('change', 'td input:checkbox', function (element) {
    const checkboxes = $('.checkboxes');
    const checkeds = checkboxes.filter(':checked').length;
    $('#checkAll').prop('indeterminate', checkeds > 0 && checkeds < checkboxes.length);

    const containerDel = $(".delete-container");

    if (containerDel.hasClass('d-none') && checkeds) {
        containerDel.removeClass('d-none');
    }

    if (!checkeds) {
        containerDel.addClass('d-none');
    }
})

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
})();
