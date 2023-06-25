function loginUser(event) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const userType = document.getElementById('userType').value;

    fetch('authenticate.php', {
        method: 'POST',
        body: JSON.stringify({
            username: username,
            password: password,
            userType: userType
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // alert(data);
        if (data.success) {
            // Handle successful login
            window.location.href = 'room.html';
        } else {
            // Handle failed login
            alert('Failed to log in');
        }
    })
    .catch(error => console.error('Error:', error));
}
