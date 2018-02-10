/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

let pusherKey = document.head.querySelector('meta[name="pusher-public-key"]');
if (pusherKey) {
  window.Echo = new Echo({
    broadcaster: 'pusher',
    cluster: 'us2',
    encrypted: true,
    key: pusherKey.content
  });
}

window.Echo.channel('system-notification')
  .listen('SystemWideNotification', message => {
    window.flash(message);
  });
