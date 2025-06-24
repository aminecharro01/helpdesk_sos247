import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import Chart from 'chart.js/auto';
window.Chart = Chart;

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY;
const pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: pusherKey,
    cluster: pusherCluster,
    forceTLS: true,
    encrypted: true,
});

// Écouter les événements sur les canaux spécifiques
window.Echo.channel('tickets')
    .listen('.ticket.created', (e) => {
        console.log('🆕 Ticket créé :', e.ticket);
        const event = new CustomEvent('ticket-created', { detail: e.ticket });
        window.dispatchEvent(event);
    })
