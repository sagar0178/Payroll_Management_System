$(document).ready(function () {
    // Function to enable/disable cancel button based on leave status
    function updateCancelButtons() {
        $('tbody tr').each(function () {
            var leaveStatus = $(this).find('td:eq(5)').text();
            var cancelButton = $(this).find('td:eq(6) button');
            if (leaveStatus === 'Pending') {
                cancelButton.prop('disabled', false);
            } else {
                cancelButton.prop('disabled', true);
            }
        });
    }

    // Call the function on page load
    updateCancelButtons();

    // Event handler for cancel button click
    $('tbody').on('click', '.btn-cancel', function () {
        var leaveID = $(this).data('id');

        // Display a confirmation popup
        var confirmation = confirm('Are you sure you want to cancel this leave application?');
        if (confirmation) {
            // Redirect to cancel_leave.php to process the cancellation
            window.location.href = 'cancel_leave.php?id=' + leaveID;
        }
    });

    // Function to show success message and hide after a delay
    function showSuccessMessage(message) {
        var successMessage = $('<div class="alert alert-success">' + message + '</div>');
        $('.card-body').append(successMessage);

        // Hide the success message after 3 seconds
        setTimeout(function () {
            successMessage.remove();
        }, 3000);
    }

    // Function to show error message and hide after a delay
    function showErrorMessage(message) {
        var errorMessage = $('<div class="alert alert-danger">' + message + '</div>');
        $('.card-body').append(errorMessage);

        // Hide the error message after 3 seconds
        setTimeout(function () {
            errorMessage.remove();
        }, 3000);
    }

    // Check if there is a success message from cancel_leave.php
    var successMessage = '<?= $success_message ?>';
    if (successMessage !== '') {
        showSuccessMessage(successMessage);
    }

    // Check if there is an error message from cancel_leave.php
    var errorMessage = '<?= $error_message ?>';
    if (errorMessage !== '') {
        showErrorMessage(errorMessage);
    }
});


/* Download PDF */

document.getElementById('downloadBtn').addEventListener('click', function () {
    const pdf = new jsPDF();

    pdf.text("Employee Income Statement", 10, 10);
    pdf.fromHTML(document.getElementById('incomeTable'), 15, 15, {
        width: 180
    });

    pdf.save("employee_income_statement.pdf");
});

