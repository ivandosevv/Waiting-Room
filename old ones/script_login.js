document.querySelector('form').addEventListener('submit', function(event) {
    const username = document.querySelector('#username').value;
    const password = document.querySelector('#password').value;

    if (!username || !password) {
        alert('Please fill in both fields.');
        event.preventDefault();
    }
});
