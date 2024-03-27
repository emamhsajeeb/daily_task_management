<div id="subscribeModals" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-7">
                    <div class="modal-body p-5">
                        <h2 class="lh-base">Subscribe now today to get <span class="text-danger">20% off</span> experiences!</h2>
                        <p class="text-muted mb-4">A free bet is a bet which is provided by a betting site for a customer to place and then benefit from the winnings. Free bets are commonly used as welcome offers.</p>
                        <div class="input-group mb-3">
                            <button class="btn btn-primary" type="button" id="enableNotification">Subscript Now</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="subscribe-modals-cover h-100">
                        <img src="assets/images/auth-one-bg.jpg" alt="" class="h-100 w-100 object-fit-cover" style="clip-path: polygon(100% 0%, 100% 100%, 100% 100%, 0% 100%, 25% 50%, 0% 0%);">
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



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

    // Add event listener to show modal when it is about to be shown
    $('#subscribeModals').on('show.bs.modal', function (e) {
        $('#enableNotification').on('click', requestPermission); // Attach click event to the button
    });

    getToken(messaging, { vapidKey: 'BLcVF1Gg7a0lG4VZkHPWI7cXPCaCFO70YS_odQ3PMqvedqmg7bH0-jMZzqK7DkU7dF2fFzfq5wc9IrzyJ6C4weM' }).then((currentToken) => {
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
            error: function (error) {
                console.log(error);
            },
        });
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        console.log('No registration token available. Request permission to generate one.');
        $('#subscribeModals').modal('show'); // Show the modal
    });
</script>


