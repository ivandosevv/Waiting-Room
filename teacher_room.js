window.onload = init();

function init() {
    console.log('Page loaded');
    fetchQueueList();
    fetchNextNumber();
    fetchComments();

    // Call fetchNextNumber() every 5 seconds
    setInterval(fetchNextNumber, 5000);
}


function fetchQueueList() {
    fetch('get_queue_list.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let queueListSection = document.getElementById('queue_list');
            queueListSection.innerHTML = '';
            if (data.queueList) {  // Check if data.queueList exists before using it
                for (let student of data.queueList) {
                    let studentElement = document.createElement('p');
                    // Assuming student.username contains the student's username
                    studentElement.innerText = "Number: " + student.queue_number + "; : " + student.student_username;   
                    queueListSection.appendChild(studentElement);
                }
            } else {
                console.log("No students in queue");
            }
        } else {
            // Handle failed request
            alert('Failed to get queue list');
        }
    })
    .catch(error => console.error('Error:', error));
}

function addStudentToQueue() {
    // alert("ITS LIT!");
    let datetimeEntry = document.getElementById('datetime_entry');

    let studentUsername = prompt('Enter student username:');
    if (studentUsername) {
        let formData = new FormData();
        formData.append('student_username', studentUsername);
        formData.append('datetime_entry', datetimeEntry.value);

        fetch('add_student_to_queue.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchQueueList();
                fetchNextNumber();
            } else {
                // Handle failed request
                alert('Failed to add student to queue');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}


function fetchNextNumber() {
    fetch('get_next_number.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);  // Let's log the full data object
        if (data.success) {
            document.getElementById('next_number').innerText = data.nextNumber;
        } else {
            // Handle failed request
            alert('Failed to get next number');
        }
    })    
    .catch(error => console.error('Error:', error));
}

function fetchComments() {
    fetch('get_comments.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let commentsSection = document.getElementById('comments_section');
            commentsSection.innerHTML = '';
            for (let comment of data.comments) {
                let commentElement = document.createElement('p');
                commentElement.innerText = comment;
                commentsSection.appendChild(commentElement);
            }
        } else {
            // Handle failed request
            // alert('Failed to get comments');
        }
    })
    .catch(error => console.error('Error:', error));
}


function inviteNextStudent() {
    fetch('invite_next_student.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchQueueList();
            fetchNextNumber();
        } else {
            // Handle failed request
            alert('Failed to invite next student');
        }
    })
    .catch(error => console.error('Error:', error));
}

function inviteStudentByNumber() {
    let studentNumber = prompt('Enter student number:');
    if (studentNumber) {
        let formData = new FormData();
        formData.append('student_number', studentNumber);

        fetch('invite_student_by_number.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchQueueList();
                fetchNextNumber();
            } else {
                // Handle failed request
                alert('Failed to invite student');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function addComment() {
    let commentText = prompt('Enter your comment:');
    if (commentText) {
        let formData = new FormData();
        formData.append('comment', commentText);

        fetch('add_comment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchComments();
            } else {
                // Handle failed request
                alert('Failed to add comment');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function createRoom() {
    let roomSubject = prompt('Enter the subject for the room:');
    let roomLink = prompt('Enter the link for the room:');

    if (roomSubject) {
        let formData = new FormData();
        formData.append('subject', roomSubject);
        formData.append('link', roomLink);

        fetch('create_room.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Room created successfully');
                window.location.reload(); // This reloads the page to reflect the new room
            } else {
                // Handle failed request
                alert('Failed to create room');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}


function logout() {
    fetch('logout.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'login.html';
        } else {
            // Handle failed request
            alert('Failed to logout');
        }
    })
    .catch(error => console.error('Error:', error));
}
