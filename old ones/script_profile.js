document.querySelector('form').addEventListener('submit', function(event) {
    const email = document.querySelector('#email').value;
    const password = document.querySelector('#password').value;
    const passwordRepeat = document.querySelector('#password-repeat').value;

    if (!email || (password && password !== passwordRepeat)) {
        if (!email) {
            alert('Please provide your email address.');
        } else {
            alert('Passwords do not match.');
        }
        event.preventDefault();
    }
});
