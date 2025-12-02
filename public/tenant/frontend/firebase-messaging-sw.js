// firebase-messaging-sw.js
// Version: 1.1.3

importScripts("https://www.gstatic.com/firebasejs/11.8.1/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/11.8.1/firebase-messaging-compat.js");

firebase.initializeApp({
  apiKey: "AIzaSyACRysAnd0JxaigGFRZ3mGyjm16IcPg5zI",
  authDomain: "test-ce6d4.firebaseapp.com",
  projectId: "test-ce6d4",
  storageBucket: "test-ce6d4.firebasestorage.app",
  messagingSenderId: "680663384330",
  appId: "1:680663384330:web:4d237479cf6fad9149faf3",
  measurementId: "G-98N77NZEL8",
});

const messaging = firebase.messaging();

// ✅ Background message handler
messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message:', payload);

  const data = payload.data || {};
  const notificationTitle = data.title || 'New Notification';
  const notificationOptions = {
    body: data.body || '',
    icon: data.icon || '/logo.jpg',
    data: {
      link: data.link || '/' // ✅ Store the redirect link
    }
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});

// ✅ Handle notification click
self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  const targetLink = event.notification.data?.link || '/';

  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clientList => {
      for (const client of clientList) {
        if (client.url === targetLink && 'focus' in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(targetLink);
      }
    })
  );
});
