


<script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>

<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js" integrity="sha512-JSCFHhKDilTRRXe9ak/FJ28dcpOJxzQaCd3Xg8MyF6XFjODhy/YMCM8HW0TFDckNHWUewW+kfvhin43hKtJxAw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- particles js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.3/particles.js" integrity="sha512-BgV3bZfMmUklIZI+dP0SILdmQ0RBY2gxegFFyfgo4Ui56WhKF4Pny9LsV/l96jxDDA+2w47zAXA4IyHo2UT/Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- password-addon init -->
<script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
<!-- list.js min js -->
<script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
<!--list pagination js-->
<script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<!-- profile-setting init js -->
<!-- my custom js -->
<script src="{{ asset('assets/js/mycustom.js') }}"></script>
<!-- prismjs plugin -->
<script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
<!--datatable js-->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const registerSw = async () => {
        return await navigator.serviceWorker.register("{{ asset('/service_worker.js') }}");
    };

    const requestNotificationPermission = async () => {
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
            if ('serviceWorker' in navigator) {
                if ('Notification' in window) {
                    try {
                        const registration = await registerSw();
                        console.log('Service Worker registered:', registration);
                    } catch (error) {
                        throw new Error("Error registering Service Worker: " + error.message);
                    }
                } else {
                    throw new Error("No support for notification API");
                }
            } else {
                throw new Error("No support for service worker!");
            }
        } else {
            throw new Error("Notification permission not granted");
        }
    };

    $( document ).ready(function() {
        // Display a browser notification with the received data
        if (Notification.permission === "denied" || Notification.permission === "default") {
            Swal.fire({
                title: "Turn on notifications to stay updated",
                showCancelButton: false,
                confirmButtonText: "Accept",
                showLoaderOnConfirm: true,
                customClass: {
                    confirmButton: 'btn btn-primary w-xs me-2',
                    cancelButton: 'btn btn-danger w-xs'
                },
                buttonsStyling: false,
                showCloseButton: false,
                allowOutsideClick: false,
                preConfirm: requestNotificationPermission
            }).then(function (result) {
                Swal.fire({
                    icon: "success",
                    title: "Notification permission granted",
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs',
                    },
                    buttonsStyling: false,
                });
            }).catch(function (error) {
                Swal.fire({
                    icon: "error",
                    title: "Notification permission denied",
                    text: error.message,
                    confirmButtonClass: "btn btn-primary w-xs",
                    buttonsStyling: false
                });
            });
        }

        // $('#send-button').click(function() {
        //     var userInput = $('#user-input').val();
        //     $('#chat-messages').append('<div>You: ' + userInput + '</div>');
        //     $('#user-input').val('');
        //
        //     // Send user input to backend for processing
        //     $.post('/botman', { message: userInput }, function(response) {
        //         $('#chat-messages').append('<div>Bot: ' + response + '</div>');
        //     });
        // });
    });

    // Function to display browser notifications
    const pushNotification = async (data) => {
        try {
            // Get the registration of the service worker
            var registration = await navigator.serviceWorker.getRegistration();
            if (registration) {
                // Show the notification using the registered service worker
                await registration.showNotification(data.title, {
                    body: data.message
                });
            } else {
                registration = await registerSw();
                await registration.showNotification(data.title, {
                    body: data.message
                });
            }
        } catch (error) {
            console.error("Error pushing notification:", error);
        }
    };

    var pusher = new Pusher('f190593a4dbf29f3775a', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('tasks-channel');
    channel.bind('pusher:subscription_succeeded', function() {});


    channel.bind('tasks-event', function(data) {
        console.log('Received data:', data);

        // Display a browser notification with the received data
        if (Notification.permission === "granted") {
            pushNotification(data);
        }
    });
</script>




