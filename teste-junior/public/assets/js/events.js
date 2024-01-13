// Prevent submition event for all forms.
$("form").on('submit', event => {
    event.preventDefault();
})

// Update all checkboxes state according to main checkboxes.
$("#checkAll").on('change', function (target) {
    const checkboxes = $(".main-table td input:checkbox");

    // Apply checked property as true or false for all checkboxes
    checkboxes.prop('checked', target.currentTarget.checked);
    checkboxes.trigger('change');
});

// Check for changes in multicheckboxes in datatable and apply appropriate status to checkAll checkbox and
// also update modal rows count for each selected checkbox.
$(document).on('change', 'td input:checkbox', function (element) {
    const checkboxes = $('.checkboxes');
    const checkeds = checkboxes.filter(':checked').length;
    const rowCount = $(".rows-count");
    $('#checkAll').prop('indeterminate', checkeds > 0 && checkeds < checkboxes.length);

    const containerDel = $(".delete-container");

    // If there are checked elements, remove d-none class from the delete button.
    if (containerDel.hasClass('d-none') && checkeds) {
        containerDel.removeClass('d-none');
    }

    // Is there aren't checked elements, add class d-none to the delete button
    if (!checkeds) {
        containerDel.addClass('d-none');
    }

    // Update selected rows counter whenever there are changes.
    rowCount.text(`${checkeds}`);
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
})();
