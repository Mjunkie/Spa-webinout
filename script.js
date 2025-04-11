document.getElementById('signup-form').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
    var email = document.getElementById('email').value;
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; 


    if (password !== confirmPassword) {
        e.preventDefault(); 
        alert('Passwords do not match!');
        return;
    }

    
    if (!emailPattern.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address!');
        return;
    }
});
