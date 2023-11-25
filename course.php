<?php

include 'partial/navbar.php';
?>

<!-- <div class="SidebarContainer-flex"> -->
<?php
include 'partial/sidebar.php';
?>

<div class="container">
    <div class="from_and_list_course-flex">
        <div class="course-form">
            <h1 class="form-title">Course Form</h1>
            <form action="" class="form-style" id="courseForm">
                <label for="inputCourseName">Course</label><br>
                <input type="text" class="input-style" id="inputCourseName" name="inputCourseName" required>
                <div class="error" id="inputCourseName-error"></div>
                <br>
                <label for="inputCourseDesc">Description</label><br>
                <textarea class="textarea-style" name="" id="inputCourseDesc" cols="30" rows="10"></textarea>
                <div class="error" id="inputCourseDesc-error"></div>

                <br>
                <button type="button" class="button-style" id="saveBtn">Save</button>
                <button type="button" class="button-style" id="cancelBtn">Cancel</button>
            </form>
        </div>
        <div class="course-list">
            <h1 class="form-title">Course List</h1>
            <div class="datatable-style">
                <table id="courseList" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Course Description</th>
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
    <!-- Edit Course Popup -->
    <div class="popup popup-content edit-course-popup" id="editCoursePopup">
        <h1 class="form-title">Manage Course</h1>
        <form id="editCourseForm">
            <input type="hidden" class="input-style" id="editCourseId" name="editCourseId">
            <label for="editCourseName">Course Name</label><br>
            <input type="text" class="input-style" id="editCourseName" name="editCourseName">
            <div class="error" id="editCoursenameError"></div>
            <br>
            <label for="editCourseDesc">Description</label><br>
            <textarea name="editCourseDesc" id="editCourseDesc" cols="30" rows="10"></textarea>
            <div class="error" id="editCourseDescError"></div>
            <br>
            <button type="button" class="button-style" id="saveCourseChangesBtn">Save Changes</button>
        </form>
    </div>
</div>


<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        // DataTable initialization
        var dataTable = $('#courseList').DataTable({
            ajax: {
                url: 'partial/course_partial/get_courses.php',
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
                { data: 'course' },
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

    // Function to validate the edit course form on the client-side
    function validateEditCourseForm() {
        var courseName = $('#editCourseName').val().trim();
        var courseDesc = $('#editCourseDesc').val().trim();

        // Reset error messages
        $('#editCoursenameError').text('');
        $('#editCourseDescError').text('');

        var isValid = true;

        // Validate course name
        if (courseName === '') {
            $('#editCoursenameError').text('Course name is required.');
            isValid = false;
        }

        // Validate course description
        if (courseDesc === '') {
            $('#editCourseDescError').text('Course description is required.');
            isValid = false;
        }

        return isValid;
    }

    // Function to save course changes
    function saveCourseChanges(courseId, newName, newDesc) {
        $.ajax({
            url: 'partial/course_partial/save_course_changes.php',
            type: 'POST',
            data: {
                course_id: courseId,
                new_name: newName,
                new_desc: newDesc
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {

                    // Reload the DataTable
                    $('#courseList').DataTable().ajax.reload();


                    $("#editCoursePopup, #overlay").hide();

                    // Handle success, e.g., show a success message, update UI, etc.
                    console.log(response.message);
                    // Optionally, close the edit course popup or perform other actions
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

    // Event listener for the "Save Changes" button in the edit course popup
    $('#saveCourseChangesBtn').on('click', function () {
        // Validate the form on the client-side
        if (!validateEditCourseForm()) {
            return;
        }

        // Retrieve data from the form
        var courseId = $('#editCourseId').val().trim();
        var newName = $('#editCourseName').val().trim();
        var newDesc = $('#editCourseDesc').val().trim();

        // Call the function to save course changes
        saveCourseChanges(courseId, newName, newDesc);
    });

    function openEditCoursePopup(courseId) {
        // Ajax request to fetch course details
        $.ajax({
            url: 'partial/course_partial/get_course_details.php',
            type: 'GET',
            data: { course_id: courseId },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                // Check if the response has an error
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }

                // Populate the form fields with the retrieved data
                $('#editCourseId').val(data.id);
                $('#editCourseName').val(data.course);
                $('#editCourseDesc').val(data.description);

                $("#editCoursePopup, #overlay").show();

            },
            error: function () {
                console.log('Error connecting to the server. Please try again.');
            }
        });
    }

    // Event delegation for edit and delete buttons
    $('#courseList').on('click', '.editBtn', function () {
        var courseId = $(this).data('id');
        openEditCoursePopup(courseId);
    });

    // Function to delete a course
    function deleteCourse(courseId) {
        $.ajax({
            url: 'partial/course_partial/delete_course.php',
            type: 'POST',
            data: { course_id: courseId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {

                    // Reload the DataTable
                    $('#courseList').DataTable().ajax.reload();

                    // Handle success, e.g., show a success message, update UI, etc.
                    console.log(response.message);
                    // Reload the DataTable or update the course list as needed
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

    $('#courseList').on('click', '.deleteBtn', function () {
        var courseId = $(this).data('id');

        // Call the function to delete the course
        deleteCourse(courseId);

        console.log('Delete button clicked for course ID: ' + courseId);
    });
</script>

<script>
    // Form validation and submission using Ajax
    $('#saveBtn').on('click', function () {
        // Clear previous errors
        $('.error').html('');

        // Get form data
        var courseName = $('#inputCourseName').val();
        var courseDesc = $('#inputCourseDesc').val();

        // Simple validation
        if (courseName === '') {
            $('#inputCourseName-error').html('Course name is required.');
            return;
        }
        if (courseDesc === '') {
            $('#inputCourseDesc-error').html('Course description is required.');
            return;
        }

        // Ajax request to submit the form data
        $.ajax({
            url: 'partial/course_partial/save_course.php',
            type: 'POST',
            data: {
                courseName: courseName,
                courseDesc: courseDesc
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    // Reload the DataTable
                    $('#courseList').DataTable().ajax.reload();

                    // Clear the form
                    $('#courseForm')[0].reset();
                } else {
                    // Display an error message
                    alert('Error saving course. Please try again.');
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
        $('#courseForm')[0].reset();
    });
</script>