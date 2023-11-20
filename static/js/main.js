function clearInput($input_id) {
    // Get the input element by its ID
    var inputField = document.getElementById($input_id);

    // Clear the value of the input field
    inputField.value = '';
}

// Close popup on pressing the "Escape" key
$(document).keydown(function (e) {
    if (e.key === "Escape") {
        $(".popup, #overlay").hide();
        clearInput("editPassword");

    }
});


// Handle logout using AJAX or redirect to logout page
$("#logoutBtn").click(function () {
    window.location.href = 'logout.php';
});
