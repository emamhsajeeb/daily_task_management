<script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<!-- particles js -->
<script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
<!-- particles app js -->
<script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>
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
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script type="module">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Import the functions you need from the SDKs you need
    import {initializeApp}  from "https://www.gstatic.com/firebasejs/10.9.0/firebase-app.js";
    import {getMessaging, getToken} from "https://cdnjs.cloudflare.com/ajax/libs/firebase/10.9.0/firebase-messaging.min.js";

    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyCma6YB2JiSX7QvsS6J1d0RwuGM8URvK-U",
        authDomain: "dbedc-task-management.firebaseapp.com",
        databaseURL: "https://dbedc-task-management-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "dbedc-task-management",
        storageBucket: "dbedc-task-management.appspot.com",
        messagingSenderId: "351976405927",
        appId: "1:351976405927:web:46ff930e027712fca41482"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    getToken(messaging, { vapidKey: 'BLcVF1Gg7a0lG4VZkHPWI7cXPCaCFO70YS_odQ3PMqvedqmg7bH0-jMZzqK7DkU7dF2fFzfq5wc9IrzyJ6C4weM' }).then((currentToken) => {
        if (currentToken) {
            console.log(currentToken);
            $.ajax({
                url: '{{ route("updateDeviceToken") }}',

                type: 'POST',
                data: {
                    token: currentToken
                },
                success: function (data) {
                    console.log(data.message)
                    alert(data.message);
                },
                // error: function (error) {
                //     console.log(error);
                //     alert('Error occurred while updating device token.');
                // },
            });
        } else {
            // Show permission request UI
            console.log('No registration token available. Request permission to generate one.');
            function requestPermission() {
                console.log('Requesting permission...');
                Notification.requestPermission().then((permission) => {
                    if (permission === 'granted') {
                        console.log('Notification permission granted.');
                        // Perform necessary actions if permission is granted
                    } else {
                        console.log('Notification permission denied.');
                        // Handle case where permission is denied
                    }
                });
            }
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        alert('An error occurred while retrieving token.');
    });
</script>


