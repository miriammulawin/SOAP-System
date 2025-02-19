document.addEventListener("DOMContentLoaded", function () {
    // Login button functionality
    document.getElementById("loginButton").addEventListener("click", function () {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Retrieve the password from local storage
        const storedPassword = localStorage.getItem(username);

        if (storedPassword && storedPassword === password) {
            document.getElementById("successMessage").textContent = "Successfully logged in!";
            document.getElementById("successMessage").style.display = "block";
            document.getElementById("errorMessage").style.display = "none";
            // Redirect to main.html after a short delay
            setTimeout(() => {
                window.location.href = "main.html"; // Redirect to main.html
            }, 1000);
        } else {
            document.getElementById("errorMessage").textContent = "Invalid username or password.";
            document.getElementById("errorMessage").style.display = "block";
            document.getElementById("successMessage").style.display = "none";
        }
    });

    // Show password functionality
    document.getElementById("togglePassword").addEventListener("change", function () {
        const passwordInput = document.getElementById("password");
        passwordInput.type = this.checked ? "text" : "password";
    });

    // Sign Up button functionality
    document.getElementById("signupButton").addEventListener("click", function () {
        // Redirect to signup page or display a message
        window.location.href = "signup.html";
    });
});
