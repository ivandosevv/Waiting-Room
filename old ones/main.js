// Function to handle queue management
function manageQueue(action, queueName) {
    fetch('manage_queues.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=${action}&queue=${queueName}`
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch((error) => {
        console.error('Error:', error);
    });
}

// Add event listeners for form submissions
document.getElementById('manageQueueForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const action = this.action.value;
    const queueName = this.queue.value;
    
    manageQueue(action, queueName);
});

// Similar event listeners can be added for 'joinQueueForm', 'leaveQueueButton' and 'reorderQueueForm'
// Function to handle joining a queue
function joinQueue(queueName) {
    fetch('join_queue.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `queue=${queueName}`
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch((error) => {
        console.error('Error:', error);
    });
}

// Function to handle leaving a queue
function leaveQueue(queueName) {
    fetch('remove_from_queue.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `queue=${queueName}`
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch((error) => {
        console.error('Error:', error);
    });
}

// Function to handle reordering a queue
function reorderQueue(queueName, student1, student2) {
    fetch('reorder_queue.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `queue=${queueName}&student1=${student1}&student2=${student2}`
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch((error) => {
        console.error('Error:', error);
    });
}

// Add event listeners for form submissions and button clicks
document.getElementById('manageQueueForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const action = this.action.value;
    const queueName = this.queue.value;
    
    manageQueue(action, queueName);
});

document.getElementById('joinQueueForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const queueName = this.queue.value;
    
    joinQueue(queueName);
});

document.getElementById('leaveQueueButton').addEventListener('click', function() {
    const queueName = document.querySelector("#queueToJoin").value;
    
    leaveQueue(queueName);
});

document.getElementById('reorderQueueForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const queueName = this.queue.value;
    const student1 = this.student1.value;
    const student2 = this.student2.value;
    
    reorderQueue(queueName, student1, student2);
});
