@extends('layouts.app')

@section('dashboard')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid" style="max-width: 100% !important;">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $title }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ $title }}</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-xxl-3 col-sm-12">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="fw-medium text-muted mb-0">Clock In/Clock Out</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p id="clock-in" class="fw-medium text-50 mb-0" style="display: none;">Clock In</p>
                                    <h2 class="mt-1 ff-secondary fw-semibold">
                                        <span id="clock-in-time" class="counter-value" style="display: none;">08:00 AM</span>
                                    </h2>
                                    <p id="clock-in-location" class="text-50" style="display: none;"></p>
                                </div>
                                <div>
                                    <p id="clock-out" class="fw-medium text-50 mb-0" style="display: none;">Clock Out</p>
                                    <h2 class="mt-1 ff-secondary fw-semibold">
                                        <span id="clock-out-time" class="counter-value" style="display: none;">05:00 PM</span>
                                    </h2>
                                    <p id="clock-out-location" class="text-50" style="display: none;"></p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-4">
                                        <i class=" ri-map-pin-time-line"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button id="clock-in-button" class="btn btn-success mt-2" style="display: none;">Clock In</button>
                                    <button id="clock-out-button" class="btn btn-danger mt-2" style="display: none;">Clock Out</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card-->
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Total Tasks</p>
                                    <h4 class="mt-4 ff-secondary fw-semibold"><span>{{ $statistics['total'] }}</span></h4>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i> 17.32 %</span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                                        <i class="ri-ticket-2-line"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Completed Tasks</p>
                                    <h4 class="mt-4 ff-secondary fw-semibold"><span>{{ $statistics['completed'] }}</span></h4>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"><i class="ri-arrow-down-line align-middle"></i> 2.52 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Pending Tasks</p>
                                    <h4 class="mt-4 ff-secondary fw-semibold"><span>{{ $statistics['pending'] }}</span></h4>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"><i class="ri-arrow-down-line align-middle"></i> 0.87 %</span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                                        <i class="mdi mdi-timer-sand"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">RFI Submission</p>
                                    <h4 class="mt-4 ff-secondary fw-semibold"><span >{{ $statistics['rfi_submissions'] }}</span></h4>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i> 0.63 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                                        <i class="ri-task-line"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
                <!--end col-->
                @role('admin')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Users Locations</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="gmaps-markers" style="height: 80vh" class="gmaps"></div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->
                @endrole
                @role('admin')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Todays Timesheet</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-sm align-middle table-nowrap table-hover mb-0" id="timeSheetTable">
                                    <thead class="table-light">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Employee</th>
                                        <th scope="col">Clockin Time</th>
                                        <th scope="col">Clockin Location</th>
                                        <th scope="col">Clockout Time</th>
                                        <th scope="col">Clockout Location</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- end table -->
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                    <div class="table-responsive">

                    </div>
                    <!-- end table responsive -->
                </div>
                <!-- end col -->
                @endrole
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- Load the Google Maps JavaScript API -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script type="module">
    const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};
    const user = {!! json_encode($user) !!};

    let map;

    async function initMap() {
        const projectLocation = { lat: 23.879132, lng: 90.502617 };
        const startLocation = { lat: 23.987057, lng: 90.361908 };
        const endLocation = { lat: 23.690618, lng: 90.546729 };
        const waypoints = [
            { lat: 23.972761457544667, lng: 90.39590756824155 },
            { lat: 23.939769103462904, lng: 90.43984602831715 },
            { lat: 23.84609091993803, lng: 90.52989931509055 },
            { lat: 23.804620469092963, lng: 90.57015326006785 },
            { lat: 23.751565684297116, lng: 90.58184461650606 },
            { lat: 23.695471102776942, lng: 90.5494454346598 }
        ];

        map = L.map('gmaps-markers').setView(projectLocation, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // Add start and end markers
        L.marker(startLocation)
            .addTo(map)
            .bindPopup("KM-0");

        L.marker(endLocation)
            .addTo(map)
            .bindPopup("KM-48");

        // Calculate and display the route
        L.Routing.control({
            waypoints: [
                L.latLng(startLocation),
                // ...waypoints.map(point => L.latLng(point)),
                L.latLng(endLocation)
            ],
            routeWhileDragging: true
        }).addTo(map);

        // Fetch and update user locations periodically
        await fetchLocations(map);
    }

    async function fetchLocations(map) {
        const endpoint = '{{ route('getUserLocationsForToday') }}'; // Replace with your endpoint

        try {
            const response = await fetch(endpoint);
            const data = await response.json();

            // Add new markers for each user
            data.forEach(user => {
                console.log(user);

                const userIcon = L.icon({
                    shadowUrl: 'data:image/svg+xml;base64,' + btoa(`
                        <svg fill="#000000" width="36px" height="36px" viewBox="0 0 36 36" version="1.1" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>map-marker-solid</title>
                            <path class="clr-i-solid clr-i-solid-path-1" d="M18,2A11.79,11.79,0,0,0,6.22,13.73c0,4.67,2.62,8.58,4.54,11.43l.35.52a99.61,99.61,0,0,0,6.14,8l.76.89.76-.89a99.82,99.82,0,0,0,6.14-8l.35-.53c1.91-2.85,4.53-6.75,4.53-11.42A11.79,11.79,0,0,0,18,2Zm0,17a6.56,6.56,0,1,1,6.56-6.56A6.56,6.56,0,0,1,18,19Z"></path>
                        </svg>
                    `),
                    iconUrl: "assets/images/users/" + user.user_name + ".jpg",
                    shadowSize:   [56, 56], // size of the shadow
                    shadowAnchor: [28, 56],  // the same for the shadow
                    iconSize: [30, 30],
                    iconAnchor: [15, 50],
                    popupAnchor: [0, -40],
                    className: 'user-icon'
                });

                const clockinPosition = user.clockin_location ? {
                    lat: parseFloat(user.clockin_location.split(',')[0]),
                    lng: parseFloat(user.clockin_location.split(',')[1]),
                } : null;

                const clockoutPosition = user.clockout_location ? {
                    lat: parseFloat(user.clockout_location.split(',')[0]),
                    lng: parseFloat(user.clockout_location.split(',')[1]),
                } : null;

                if (clockinPosition) {
                    const clockInTime = new Date(`2024-06-04T${user.clockin_time}`).toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true,
                    });
                    L.marker(clockinPosition, { icon: userIcon })
                        .addTo(map)
                        .bindPopup("Name: " + user.first_name + "<br>Designation: " + user.position + "<br>Clockin Time: " + (user.clockin_time ? clockInTime : "Not clocked in yet") + "<br>Clockout Time: " + (user.clockout_time ? user.clockout_time : "Not clocked out yet"));
                }

                if (clockoutPosition) {
                    const clockInTime = new Date(`2024-06-04T${user.clockin_time}`).toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true,
                    });
                    const clockOutTime = new Date(`2024-06-04T${user.clockout_time}`).toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true,
                    });
                    L.marker(clockoutPosition, { icon: userIcon })
                        .addTo(map)
                        .bindPopup("Name: " + user.first_name + "<br>Designation: " + user.position + "<br>Clockin Time: " + (user.clockin_time ? clockInTime : "Not clocked in yet") + "<br>Clockout Time: " + (user.clockout_time ? clockOutTime : "Not clocked out yet"));
                }
            });
        } catch (error) {
            console.error('Error fetching user locations:', error);
        }
    }

    $( document ).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        displayCurrentUserAttendanceForToday();
        admin ? initMap() : '' ;
        admin ? displayAllUserAttendanceForToday() : '' ;

        const preloader = document.getElementById('preloader');
        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
        preloader.style.visibility = 'hidden'; // Set visibility to visible
    });

    async function displayAllUserAttendanceForToday() {
        const endpoint = '{{ route('getAllUsersAttendanceForToday') }}'; // Replace with your endpoint

        try {
            const response = await fetch(endpoint);
            const attendances = await response.json();
            // Log the response to check its structure
            console.log('Attendance data:', attendances);

            // Find the table body element
            const tbody = document.getElementById('timeSheetTable').getElementsByTagName('tbody')[0];

            // Clear existing rows
            tbody.innerHTML = '';

            // Iterate through the list of attendance records
            attendances.forEach(attendance => {
                // Destructure the required fields from attendance
                const { date, user_name, first_name, clockin_time, clockin_location, clockout_time, clockout_location } = attendance;

                // Format clock-in and clock-out locations
                const clockinLat = clockin_location?.split(',')[0] || 'N/A';
                const clockinLng = clockin_location?.split(',')[1] || 'N/A';
                const clockoutLat = clockout_location?.split(',')[0] || 'N/A';
                const clockoutLng = clockout_location?.split(',')[1] || 'N/A';

                // Create a new row and cells
                const newRow = tbody.insertRow();

                // Add cells for each piece of data
                const dateCell = newRow.insertCell();
                const employeeCell = newRow.insertCell();
                const clockinTimeCell = newRow.insertCell();
                const clockinLocationCell = newRow.insertCell();
                const clockoutTimeCell = newRow.insertCell();
                const clockoutLocationCell = newRow.insertCell();

                // Populate the cells with data
                dateCell.textContent = new Date(date).toLocaleString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric',
                });
                employeeCell.innerHTML = `
                <div class="d-flex gap-2 align-items-center">
                    <div class="flex-shrink-0">
                        <img src="${"assets/images/users/" + user_name + ".jpg"}" alt="${first_name}" class="avatar-xs rounded-circle" />
                    </div>
                    <div class="flex-grow-1">
                        ${first_name}
                    </div>
                </div>
            `;
                clockinTimeCell.textContent = clockin_time ? new Date(`2024-06-04T${clockin_time}`).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true,
                }) : 'N/A';
                clockinLocationCell.textContent = `Location: ${clockinLat}, ${clockinLng}`;
                clockoutTimeCell.textContent = clockout_time ? new Date(`2024-06-04T${clockout_time}`).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true,
                }) : 'N/A';
                clockoutLocationCell.textContent = `Location: ${clockoutLat}, ${clockoutLng}`;
            });

        } catch (error) {
            console.error('Error fetching attendance data:', error, details);
        }
    }

    async function displayCurrentUserAttendanceForToday() {
        const endpoint = '{{ route('getCurrentUserAttendanceForToday') }}'; // Replace with your endpoint

        try {
            const response = await fetch(endpoint);
            const attendance = await response.json();
            console.log(attendance);
            const clockin_latitude = attendance.clockin_location?.split(',')[0];
            const clockin_longitude = attendance.clockin_location?.split(',')[1];
            const clockout_latitude = attendance.clockout_location?.split(',')[0];
            const clockout_longitude = attendance.clockout_location?.split(',')[1];

            if (attendance.clockin_time) {
                document.getElementById('clock-in').style.display = '';
                document.getElementById('clock-in-time').style.display = '';
                document.getElementById('clock-in-button').style.display = 'none';
                document.getElementById('clock-out-button').style.display = '';
                document.getElementById('clock-in-time').textContent = new Date(`2024-06-04T${attendance.clockin_time}`).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true,
                });
                document.getElementById('clock-in-location').style.display = '';
                document.getElementById('clock-in-location').textContent = `Location: ${clockin_latitude}, ${clockin_longitude}`;
            } else {
                document.getElementById('clock-in-button').style.display = '';
            }
            if (attendance.clockout_time) {
                document.getElementById('clock-out').style.display = '';
                document.getElementById('clock-out-time').style.display = '';
                document.getElementById('clock-out-button').style.display = 'none';
                document.getElementById('clock-out-time').textContent = new Date(`2024-06-04T${attendance.clockout_time}`).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true,
                });
                document.getElementById('clock-out-location').style.display = '';
                document.getElementById('clock-out-location').textContent = `Location: ${clockout_latitude}, ${clockout_longitude}`;
            }

        } catch (error) {
            console.error('Error fetching user attendance:', error);
        }
    }

    async function calculateAndDisplayRoute(directionsService, directionsRenderer, start, end, waypoints, travelMode) {
        const request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode[travelMode.toUpperCase()]
        };

        // Include waypoints only if they are provided and are not empty
        if (waypoints.length > 0) {
            request.waypoints = waypoints;
            request.optimizeWaypoints = true; // optional: optimize the waypoints order
        }

        directionsService.route(request, (response, status) => {
            if (status === 'OK') {
                new google.maps.DirectionsRenderer({
                    suppressMarkers: true,
                    map: map,
                }).setDirections(response);
            } else {
                console.error('Directions request failed due to ' + status);
            }
        });
    }


    // Send clock data via AJAX
    function setAttendance(route, elementId, position) {
        let time = new Date().toLocaleString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true,
        });

        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;

        $.ajax({
            url: route,
            type: 'POST',
            data: {
                user_id: user.id,
                location: latitude.toFixed(4) + ', ' + longitude.toFixed(4)
            },
            success: async function (response) {
                console.log(response);
                document.getElementById(elementId).style.display = '';
                document.getElementById(elementId + '-time').style.display = '';
                document.getElementById(elementId + '-time').textContent = time;
                document.getElementById(elementId + '-location').style.display = '';
                document.getElementById(elementId + '-location').textContent = `Location: ${latitude.toFixed(4)}, ${longitude.toFixed(4)}`;
                document.getElementById(elementId + '-button').style.display = 'none';
                document.getElementById(elementId + '-button').textContent = elementId === 'clock-in' ? 'Clock In' : elementId === 'clock-out' ? 'Clock Out' :'';
                elementId === 'clock-in' ? (document.getElementById('clock-out-button').style.display = '') : '';
                toastr.success(elementId === 'clock-in' ? "Clocked in successfully" : elementId === 'clock-out' ? "Clocked out successfully" : '');
                await fetchLocations(map);
            },
            error: function(xhr, status) {
                console.error(xhr.responseText);
            }
        });
    }


    // Event listener for the clock-in button
    document.getElementById('clock-in-button').addEventListener('click', async function() {
        Swal.fire({
            title: "Are you sure you want to clock in?",
            text: "This will record your clock in time and location.",
            showCancelButton: true,
            confirmButtonColor: '#28a745', // Green for Yes
            cancelButtonColor: '#dc3545', // Red for No
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2',
                cancelButton: 'btn btn-danger w-xs'
            },
            buttonsStyling: false,
            showCloseButton: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('clock-in-button').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Clocking in..';
                navigator.geolocation.getCurrentPosition(async function(position) {
                    setAttendance('{{ route('clockin') }}', 'clock-in', position);
                });
            }
        });
    });

    document.getElementById('clock-out-button').addEventListener('click', function() {
        Swal.fire({
            title: "Are you sure you want to clock out?",
            text: "This will record your clock out time and location.",
            showCancelButton: true,
            confirmButtonColor: '#28a745', // Green for Yes
            cancelButtonColor: '#dc3545', // Red for No
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2',
                cancelButton: 'btn btn-danger w-xs'
            },
            buttonsStyling: false,
            showCloseButton: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('clock-out-button').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Clocking out..';
                navigator.geolocation.getCurrentPosition(async function(position) {
                    setAttendance('{{ route('clockout') }}', 'clock-out', position);
                });
            }
        });
    });

</script>
<style>
    .user-icon {
        border-radius:15px;
    }

    .leaflet-routing-alternatives-container {
        display: none;
    }
</style>
@endsection

