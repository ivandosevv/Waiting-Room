window.onload = function() {
    fetchQueuePosition();
    fetchNextNumber();
    fetchComments();
}

function fetchQueuePosition() {
    fetch('get_student_queue_position.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('queue_position').innerText = data.queue_position;
        } else {
            // Handle failed request
            alert('Failed to get queue position');
        }
    })
    .catch(error => console.error('Error:', error));
}

function fetchNextNumber() {
    fetch('get_next_number.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('next_number').innerText = data.next_number;
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
            alert('Failed to get comments');
        }
    })
    .catch(error => console.error('Error:', error));
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
