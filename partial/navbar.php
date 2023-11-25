<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'cred/db_connection.php';
include 'partial/utils.php';

session_start();

$user_id = $_SESSION['user_id'];
$user_data = get_user_data($user_id);

include 'base.php';

?>

<div class="navbar">
    <div class="topbar-flex">
        <div class="title">
            <p>Student Attendance</p>
        </div>
        <div class="user_tool" id="userTool">
            <p>
                <?php echo $user_data['name'] ?>
            </p>
        </div>
    </div>
</div>

<!-- Popup content -->
<div class="overlay" id="overlay"></div>
<div class="popup" id="user_tool_popup">
    <ul>
        <li id="manageAccBtn">Manage Account</li>
        <li id="logoutBtn">Logout</li>
    </ul>
</div>

<!-- Edit Account Popup -->
<div class="popup edit-account-popup" id="editAccountPopup">
    <h1 class="form-title">Manage Account</h1>
    <form id="editAccountForm">
        <label for="editName">Name:</label><br>
        <input type="text" class="input-style" id="editName" name="editName" value="<?php echo $user_data['name']; ?>" required>
        <div class="error" id="nameError"></div>
        <br>
        <label for="editUsername">Username:</label><br>
        <input type="text" class="input-style" id="editUsername" name="editUsername" value="<?php echo $user_data['username']; ?>" required>
        <div class="error" id="usernameError"></div>
        <br>
        <label for="editPassword">Password:</label><br>
        <input type="password" class="input-style" id="editPassword" name="editPassword">
        <p id="hint">Leave this blank if you dont want to change the password.</p>
        <div class="error" id="passwordError"></div>
        <br>
        <button type="button" class="button-style" id="saveChangesBtn">Save Changes</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Toggle popup when clicking on user_tool
        $("#userTool").click(function () {
            $("#user_tool_popup, #overlay").toggle();
        });

        // Hide popup and overlay when clicking outside the popup
        $("#overlay").click(function () {
            $(".popup, #overlay").hide();

            clearInput("editPassword");
        });

        // Open Edit Account Popup when clicking on Manage Account
        $("#manageAccBtn").click(function () {
            $("#user_tool_popup, #overlay").hide();
            $("#editAccountPopup, #overlay").show();
        });

    });

    $("#saveChangesBtn").click(function () {
        // Clear previous error messages
        $(".error").text("");

        // Validate the form
        if (validateForm()) {
            $.ajax({
                type: "POST",
                url: "edit_account.php",
                data: $("#editAccountForm").serialize(),
                success: function (response) {
                    // Handle the response from the server
                    if (response.status == "success") {
                        // Update successful, you may display a success message or perform other actions
                        alert("Account details updated successfully!");
                        // Close the popup
                        $("#editAccountPopup, #overlay").hide();
                    } else {
                        // Update failed, display an error message
                        alert("Failed to update account details. Please try again.");
                    }
                },
                error: function () {
                    // Handle AJAX error
                    alert("An error occurred during the AJAX request.");
                }
            });
        }
    });

    function validateForm() {
        var valid = true;

        // Validate Name
        var name = $("#editName").val();
        if (name.trim() === "") {
            $("#nameError").text("Name is required.");
            valid = false;
        }

        // Validate Username
        var username = $("#editUsername").val();
        if (username.trim() === "") {
            $("#usernameError").text("Username is required.");
            valid = false;
        }

        // // Validate Password
        // var password = $("#editPassword").val();
        // if (password.trim() === "") {
        //     $("#passwordError").text("Password is required.");
        //     valid = false;
        // }

        return valid;
    }
</script>