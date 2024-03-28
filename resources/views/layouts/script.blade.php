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

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('f190593a4dbf29f3775a', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('tasks-channel');
    channel.bind('pusher:subscription_succeeded', function() {
        console.log('Successfully subscribed to tasks-channel.');
    });

    channel.bind('tasks-event', function(data) {
        console.log('Received data:', data);
        // Display a browser notification with the received data
        if (Notification.permission === "granted") {
            var notification = new Notification(data.title, {
                body: data.message
            });
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
                if (permission === "granted") {
                    var notification = new Notification(data.title, {
                        body: data.message
                    });
                }
            });
        }
    });
</script>

{{--<script type="module">--}}
{{--    function requestPermission() {--}}
{{--        console.log('Requesting permission...');--}}
{{--        Notification.requestPermission().then((permission) => {--}}
{{--            if (permission === 'granted') {--}}
{{--                console.log('Notification permission granted.');--}}
{{--                // Perform necessary actions if permission is granted--}}
{{--            } else {--}}
{{--                console.log('Notification permission denied.');--}}
{{--                // Handle case where permission is denied--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}

{{--    // Add event listener to show modal when it is about to be shown--}}
{{--    jQuery('#subscribeModals').on('show.bs.modal', function () {--}}
{{--        jQuery('#enableNotification').on('click', requestPermission); // Attach click event to the button--}}
{{--    });--}}

{{--    jQuery('#subscribeModals').modal('show'); // Show the modal--}}
{{--</script>--}}


