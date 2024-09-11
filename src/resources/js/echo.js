import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     wsHost: '192.168.1.125',  // <-- Change this to the actual IP address of your Raspberry Pi
//     wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
//     wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws'],
// });
// console.log(window.Echo);
// console.log('Echo initialized:', window.Echo);

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: '192.168.1.125',  // Raspberry Pi IP address
    wsPort: 8080,             // WebSocket port
    wssPort: 8080,            // Secure WebSocket port
    forceTLS: false,          // Set this to false unless you're using HTTPS
    enabledTransports: ['ws'], // Allow WebSocket
});

console.log(window.Echo);
console.log('Echo initialized:', window.Echo);