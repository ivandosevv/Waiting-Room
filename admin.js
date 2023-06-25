function addUser(userType) {
    const username = prompt("Please enter the username:");
    const password = prompt("Please enter the password:");
    const first_name = prompt("Please enter the first_name:");
    const last_name = prompt("Please enter the last_name:");
    const email = prompt("Please enter the email:");
    console.log(userType);

    fetch('add_user.php', {
        method: 'POST',
        body: JSON.stringify({
            username: username,
            password: password,
            first_name: first_name,
            last_name: last_name,
            email: email,
            userType: userType
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Handle successful user addition
            alert('User added successfully');
        } else {
            // Handle failed user addition
            alert('Failed to add user');
        }
    })
    .catch(error => console.error('Error:', error));
}
