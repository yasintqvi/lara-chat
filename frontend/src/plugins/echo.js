import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: 'pusher',
    key: '95c4470e82ccf17e4725',
    cluster: 'us3',
    forceTLS: false,
    encrypted: true,
    authEndpoint: "http://localhost:8000/broadcasting/auth",
    auth: {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
        }
    },
    clientOptions: {
        withCredentials: true,
    }
});


export default echo;
