document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('loginButton').addEventListener('click', function() {
        console.log("Login button clicked"); // Debugging statement
        window.location.href = 'login.html';
    });

    document.getElementById('signupButton').addEventListener('click', function() {
        console.log("Signup button clicked"); // Debugging statement
        window.location.href = 'signup.html';
    });
});
