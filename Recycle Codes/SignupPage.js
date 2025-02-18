document.addEventListener("DOMContentLoaded", function () {
    const signupButton = document.getElementById("signupButton");

    signupButton.addEventListener("click", function () {
        const username = document.getElementById("newUsername").value.trim();
        const password = document.getElementById("newPassword").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        const messageBox = document.getElementById("messageBox");

        // Clear previous messages
        messageBox.style.display = "none";
        messageBox.textContent = "";

        // Validation checks
        if (!username || !password || !confirmPassword) {
            showMessage("error", "All fields are required!");
            return;
        }
        if (password.length < 6) {
            showMessage("error", "Password must be at least 6 characters long.");
            return;
        }
        if (password !== confirmPassword) {
            showMessage("error", "Passwords do not match!");
            return;
        }

        // Save user data to local storage
        localStorage.setItem(username, password);
        showMessage("success", "Sign-up successful! Redirecting...");

        // Redirect to Login Page after 2 seconds
        setTimeout(() => {
            window.location.href = "LoginPage.html";
        }, 2000);
    });

    // Function to display messages
    function showMessage(type, message) {
        messageBox.className = type;
        messageBox.textContent = message;
        messageBox.style.display = "block";
    }

    
});
