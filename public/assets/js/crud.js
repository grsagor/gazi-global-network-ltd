$(document).ready(function () {
    $('#datatable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true
    });
    $(document).on('click', '#create-btn', function () {
        const url = $('#create_url').val();

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#crudModal').html(response.html);
                    $('#crudModal').modal('show');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
            }
        });
    });
    $(document).on('click', '#crudStoreBtn', function () {
        const url = $('#store_url').val();
        const formData = new FormData(document.getElementById('crudCreateForm'));
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    $('#crudCreateForm')[0].reset();
                    $('#crudModal').modal('hide');
                    showToast('success', response.msg)
                }
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    // Handle validation errors
                    const errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        const errorMessage = errors[field][0]; // Get the first error message for the field
                        $(`#${field}`).after(`<span class="error-message text-danger">${errorMessage}</span>`);
                    }
                } else {
                    console.error('Error saving user:', error);
                }
            }
        });
    });

});


