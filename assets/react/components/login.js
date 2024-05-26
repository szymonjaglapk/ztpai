import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    const loginButton = document.querySelector('.login-button');
    if (loginButton !== null) {
        loginButton.addEventListener('click', function(event) {
            event.preventDefault();

            const email = document.querySelector('#username').value;
            const password = document.querySelector('#password').value;

            axios.post('/login', {
                email: email,
                password: password
            })
                .then(response => {
                    const token = response.data;
                    localStorage.setItem('jwt', token);
                })
                .catch(error => {
                    console.error('There was an error!', error);
                });
        });
    }
});