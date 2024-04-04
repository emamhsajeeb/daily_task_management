console.log("This message is for the service worker");
// This is the service worker with the combined offline experience (Offline page + Offline copy of pages)



self.addEventListener('push', function(event) {
    const data = event.data.json();
    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.message
        })
    );
});

