import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
    auth: {
        withCredentials: true, // ✅ Posílání cookies pro autentizaci
        headers: {
            "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content,
        }
    }
});
