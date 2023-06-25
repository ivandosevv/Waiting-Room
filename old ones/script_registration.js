document.querySelector('form').addEventListener('submit', function(event) {
    const username = document.querySelector('#username').value;
    const email = document.querySelector('#email').value;
    const password = document.querySelector('#password').value;
    const passwordRepeat = document.querySelector('#password-repeat').value;

    if (!username || !email || !password || !passwordRepeat) {
        alert('Please fill in all fields.');
        event.preventDefault();
    } else if (password !== passwordRepeat) {
        alert('Passwords do not match.');
        event.preventDefault();
    }
});
