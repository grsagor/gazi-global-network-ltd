$(document).ready(function () {
    const url = $('#list_url').val();
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "GET"
        },
        columns: columns,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthMenu: [10, 25, 50, 100], // Define the "per page" options
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"Bf>>' + // Buttons next to search box
            'rtip', // Buttons, table (t), pagination (p), info (i)
        buttons: [
            {
                extend: 'csv',
                text: 'Export CSV', // Button text
                className: 'btn btn-primary', // Add a custom class for styling
                exportOptions: typeof exportOptions !== 'undefined' && exportOptions ? exportOptions : {}
            }
        ]
    });


    /* Create Functionality */
    $(document).on('click', '#crudCreateBtn', function () {
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
                    showToast('success', response.msg);
                    $('#datatable').DataTable().ajax.reload();
                }
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        const errorMessage = errors[field][0];
                        $(`#${field}`).after(`<span class="error-message text-danger">${errorMessage}</span>`);
                    }
                } else {
                    console.error('Error saving user:', error);
                }
            }
        });
    });

    /* Edit Functionality */
    $(document).on('click', '.crudEditBtn', function () {
        const url = $('#edit_url').val();
        const id = $(this).data('id');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { id },
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
    $(document).on('click', '#crudUpdateBtn', function () {
        const url = $('#update_url').val();
        const formData = new FormData(document.getElementById('crudUpdateForm'));
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    $('#crudUpdateForm')[0].reset();
                    $('#crudModal').modal('hide');
                    showToast('success', response.msg);
                    $('#datatable').DataTable().ajax.reload();
                }
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        const errorMessage = errors[field][0];
                        $(`#${field}`).after(`<span class="error-message text-danger">${errorMessage}</span>`);
                    }
                } else {
                    console.error('Error saving user:', error);
                }
            }
        });
    });

    /* Delete Code */
    $(document).on('click', '.crudDeleteBtn', function () {
        const id = $(this).data('id');  // Get the ID of the record to delete
        const url = $('#delete_url').val();
        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,  // Your delete route here
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF token in header
                    },
                    type: 'POST',
                    data: { id },
                    success: function (response) {
                        if (response.success) {
                            showToast('success', response.msg);
                            $('#datatable').DataTable().ajax.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    /* Print Functionality */
    $(document).on('click', '.crudPrintBtn', function () {
        const url = $('#print_url').val();
        const id = $(this).data('id');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: { id },
            success: function (response) {
                if (response.success) {
                    $('body').append('<div id="print-content">' + response.html + '</div>');
                    window.print();
                    $('#print-content').remove();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
            }
        });
    });
});

function previewImages(event) {
    const inputElement = event.target; // Get the input element
    const previewContainer = document.querySelector(inputElement.dataset.previewContainer); // Get the preview container from data attribute
    previewContainer.innerHTML = ''; // Clear any previous images

    // Loop through selected files, whether single or multiple
    const files = inputElement.files;
    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        let reader = new FileReader();

        reader.onload = function (e) {
            let img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('img-thumbnail', 'mr-2');
            img.style.width = '100px';
            img.style.height = '100px';
            previewContainer.appendChild(img);
        };

        reader.readAsDataURL(file); // Read the file and trigger onload
    }
}