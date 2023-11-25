<?php

include 'partial/navbar.php';
?>

<!-- <div class="SidebarContainer-flex"> -->
<?php
include 'partial/sidebar.php';
?>

<div class="container">
    <div class="from_and_list_subject-flex">
        <div class="subject-form">
            <h1 class="form-title">Subject Form</h1>
            <form action="" class="form-style" id="subjectForm">
                <label for="inputSubjectName">Subject</label><br>
                <input type="text" class="input-style" id="inputSubjectName" name="inputSubjectName" required>
                <div class="error" id="inputSubjectName-error"></div>
                <br>
                <label for="inputSubjectDesc">Description</label><br>
                <textarea class="textarea-style" name="" id="inputSubjectDesc" cols="30" rows="10"></textarea>
                <div class="error" id="inputSubjectDesc-error"></div>

                <br>
                <button type="button" class="button-style" id="saveBtn">Save</button>
                <button type="button" class="button-style" id="cancelBtn">Cancel</button>
            </form>
        </div>
        <div class="subject-list">
            <h1 class="form-title">Subject List</h1>
            <div class="datatable-style">
                <table id="subjectList" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable data rows go here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Edit Subject Popup -->
    <div class="popup popup-content edit-subject-popup" id="editSubjectPopup">
        <h1 class="form-title">Manage Subject</h1>
        <form id="editSubjectForm">
            <input type="hidden" class="input-style" id="editSubjectId" name="editSubjectId">
            <label for="editSubjectName">Subject Name</label><br>
            <input type="text" class="input-style" id="editSubjectName" name="editSubjectName">
            <div class="error" id="editSubjectnameError"></div>
            <br>
            <label for="editSubjectDesc">Description</label><br>
            <textarea name="editSubjectDesc" id="editSubjectDesc" cols="30" rows="10"></textarea>
            <div class="error" id="editSubjectDescError"></div>
            <br>
            <button type="button" class="button-style" id="saveSubjectChangesBtn">Save Changes</button>
        </form>
    </div>
</div>


<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        // DataTable initialization
        var dataTable = $('#subjectList').DataTable({
            ajax: {
                url: 'partial/subject_partial/get_subjects.php',
                type: 'POST',
                dataType: 'json',
                dataSrc: 'data'
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        // Use the row index (meta.row) to generate the serial number
                        return meta.row + 1;
                    }
                },
                { data: 'subject' },
                { data: 'description' },
                {
                    data: null,
                    render: function (data, type, row) {
                        // Action column with Edit and Delete buttons
                        var editBtn = '<button class="editBtn button-style" data-id="' + row.id + '">Edit</button>';
                        var deleteBtn = '<button class="deleteBtn button-style" data-id="' + row.id + '">Delete</button>';
                        return editBtn + deleteBtn;
                    }
                }
            ]
        });
    });

    // Function to validate the edit subject form on the client-side
    function validateEditSubjectForm() {
        var subjectName = $('#editSubjectName').val().trim();
        var subjectDesc = $('#editSubjectDesc').val().trim();

        // Reset error messages
        $('#editSubjectnameError').text('');
        $('#editSubjectDescError').text('');

        var isValid = true;

        // Validate subject name
        if (subjectName === '') {
            $('#editSubjectnameError').text('Subject name is required.');
            isValid = false;
        }

        // Validate subject description
        if (subjectDesc === '') {
            $('#editSubjectDescError').text('Subject description is required.');
            isValid = false;
        }

        return isValid;
    }

    // Function to save subject changes
    function saveSubjectChanges(subjectId, newName, newDesc) {
        $.ajax({
            url: 'partial/subject_partial/save_subject_changes.php',
            type: 'POST',
            data: {
                subject_id: subjectId,
                new_name: newName,
                new_desc: newDesc
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {

                    // Reload the DataTable
                    $('#subjectList').DataTable().ajax.reload();


                    $("#editSubjectPopup, #overlay").hide();

                    // Handle success, e.g., show a success message, update UI, etc.
                    console.log(response.message);
                    // Optionally, close the edit subject popup or perform other actions
                } else {
                    // Handle error, e.g., show an error message
                    console.error(response.message);
                }
            },
            error: function () {
                console.log('Error connecting to the server. Please try again.');
            }
        });
    }

    // Event listener for the "Save Changes" button in the edit subject popup
    $('#saveSubjectChangesBtn').on('click', function () {
        // Validate the form on the client-side
        if (!validateEditSubjectForm()) {
            return;
        }

        // Retrieve data from the form
        var subjectId = $('#editSubjectId').val().trim();
        var newName = $('#editSubjectName').val().trim();
        var newDesc = $('#editSubjectDesc').val().trim();

        // Call the function to save subject changes
        saveSubjectChanges(subjectId, newName, newDesc);
    });

    function openEditSubjectPopup(subjectId) {
        // Ajax request to fetch subject details
        $.ajax({
            url: 'partial/subject_partial/get_subject_details.php',
            type: 'GET',
            data: { subject_id: subjectId },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                // Check if the response has an error
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }

                // Populate the form fields with the retrieved data
                $('#editSubjectId').val(data.id);
                $('#editSubjectName').val(data.subject);
                $('#editSubjectDesc').val(data.description);

                $("#editSubjectPopup, #overlay").show();

            },
            error: function () {
                console.log('Error connecting to the server. Please try again.');
            }
        });
    }

    // Event delegation for edit and delete buttons
    $('#subjectList').on('click', '.editBtn', function () {
        var subjectId = $(this).data('id');
        openEditSubjectPopup(subjectId);
    });

    // Function to delete a subject
    function deleteSubject(subjectId) {
        $.ajax({
            url: 'partial/subject_partial/delete_subject.php',
            type: 'POST',
            data: { subject_id: subjectId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {

                    // Reload the DataTable
                    $('#subjectList').DataTable().ajax.reload();

                    // Handle success, e.g., show a success message, update UI, etc.
                    console.log(response.message);
                    // Reload the DataTable or update the subject list as needed
                } else {
                    // Handle error, e.g., show an error message
                    console.error(response.message);
                }
            },
            error: function () {
                console.log('Error connecting to the server. Please try again.');
            }
        });
    }

    $('#subjectList').on('click', '.deleteBtn', function () {
        var subjectId = $(this).data('id');

        // Call the function to delete the subject
        deleteSubject(subjectId);

        console.log('Delete button clicked for subject ID: ' + subjectId);
    });
</script>

<script>
    // Form validation and submission using Ajax
    $('#saveBtn').on('click', function () {
        // Clear previous errors
        $('.error').html('');

        // Get form data
        var subjectName = $('#inputSubjectName').val();
        var subjectDesc = $('#inputSubjectDesc').val();

        // Simple validation
        if (subjectName === '') {
            $('#inputSubjectName-error').html('Subject name is required.');
            return;
        }
        if (subjectDesc === '') {
            $('#inputSubjectDesc-error').html('Subject description is required.');
            return;
        }

        // Ajax request to submit the form data
        $.ajax({
            url: 'partial/subject_partial/save_subject.php',
            type: 'POST',
            data: {
                subjectName: subjectName,
                subjectDesc: subjectDesc
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    // Reload the DataTable
                    $('#subjectList').DataTable().ajax.reload();

                    // Clear the form
                    $('#subjectForm')[0].reset();
                } else {
                    // Display an error message
                    alert('Error saving subject. Please try again.');
                }
            },
            error: function () {
                // Handle errors
                console.log('Error connecting to the server. Please try again.');
            }
        });
    });

    // Cancel button clears the form
    $('#cancelBtn').on('click', function () {
        $('#subjectForm')[0].reset();
    });
</script>