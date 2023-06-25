window.onload = function() {
    getUserType();
}

function getUserType() {
    fetch('get_user_type.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const userType = data.userType;
            if (userType === 'student') {
                fetchPage('student_room.html');
            } else if (userType === 'teacher') {
                fetchPage('teacher_room.html');
            } else if (userType === 'admin') {
                fetchPage('admin.html');
            } else {
                // Handle invalid user type
                alert('Invalid user type');
            }
        } else {
            // Handle failed request
            alert('Failed to get user type');
        }
    })
    .catch(error => console.error('Error:', error));
}

function fetchPage(url) {
    fetch(url)
    .then(response => response.text())
    .then(data => {
        document.getElementById('room_content').innerHTML = data;
        executeScripts('room_content');
    });
}

function executeScripts(id) {
    const scripts = Array.from(document.getElementById(id).getElementsByTagName("script"));
    scripts.forEach(oldScript => {
        const newScript = document.createElement("script");
        Array.from(oldScript.attributes)
            .forEach(attr => newScript.setAttribute(attr.name, attr.value));
        newScript.appendChild(document.createTextNode(oldScript.innerHTML));
        oldScript.parentNode.replaceChild(newScript, oldScript);
    });
}
