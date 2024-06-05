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
            <!-- end page title -->


            <div class="row">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-50 mb-0">Clock In / Clock Out</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span id="clock-in-time" class="counter-value" style="display: none;">08:00 AM</span>
                                    </h2>
                                    <p id="clock-in-location" class="text-50" style="display: none;"></p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span id="clock-out-time" class="counter-value" style="display: none;">05:00 PM</span>
                                    </h2>
                                    <p id="clock-out-location" class="text-50" style="display: none;"></p>
                                    <button id="clock-in-button" class="btn btn-success mt-3" style="display: none;">Clock In</button>
                                    <button id="clock-out-button" class="btn btn-danger mt-3" style="display: none;">Clock Out</button>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-4">
                                        <i class=" ri-map-pin-time-line"></i>
                                    </span>
                                    </div>
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
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- Load the Google Maps JavaScript API -->
<script>
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        key: "AIzaSyD35-Jeo7nF8vCB4qqWVstbQJpQQALh4KQ",
        v: "weekly",
        // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
        // Add other bootstrap parameters as needed, using camel case.
    });
</script>
<script type="module">
    const apiKey = 'AIzaSyD35-Jeo7nF8vCB4qqWVstbQJpQQALh4KQ';
    const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};
    const user = {!! json_encode($user) !!};


    $( document ).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        initMap();
        fetchAttendance();

        const preloader = document.getElementById('preloader');
        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
        preloader.style.visibility = 'hidden'; // Set visibility to visible
    });

    async function fetchAttendance() {
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

    async function initMap() {
        const position = { lat: 23.879132, lng: 90.502617 };
        const startLocation = { lat: 23.987057, lng: 90.361908 };
        const endLocation = { lat: 23.690618, lng: 90.546729 };
        const waypoints = [
            { location: { lat: 23.972761457544667,  lng: 90.39590756824155 }, stopover: false },
            { location: { lat: 23.939769103462904, lng: 90.43984602831715 }, stopover: false },
            { location: { lat: 23.84609091993803, lng: 90.52989931509055 }, stopover: false },
            { location: { lat: 23.804620469092963, lng: 90.57015326006785 }, stopover: false },
            { location: { lat: 23.751565684297116, lng: 90.58184461650606 }, stopover: false },
            { location: { lat: 23.695471102776942, lng: 90.5494454346598 }, stopover: false }
        ];

        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

        // Initialize the map
        const map = new Map(document.getElementById("gmaps-markers"), {
            zoom: 4,
            center: position,
            mapId: "DEMO_MAP_ID",
        });

        const priceTag = document.createElement("div");

        priceTag.className = "project-name";
        priceTag.textContent = "Dhaka Bypass Expressway";

        // Add the marker
        new AdvancedMarkerElement({
            map: map,
            position: position,
            content: priceTag,
        });

        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
        });

        // Calculate and display the route
        await calculateAndDisplayRoute(directionsService, directionsRenderer, startLocation, endLocation, waypoints);

        // Fetch and update user locations periodically
        await fetchLocations(map);
    }

    async function calculateAndDisplayRoute(directionsService, directionsRenderer, start, end, waypoints) {
        directionsService.route(
            {
                origin: start,
                destination: end,
                waypoints: waypoints,
                optimizeWaypoints: false,
                travelMode: 'DRIVING',  // You can change this to WALKING, BICYCLING, etc.
            },
            (response, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                } else {
                    console.error('Directions request failed due to ' + status);
                }
            }
        );
    }

    async function fetchLocations(map) {
        const endpoint = '{{ route('getUserLocationsForToday') }}'; // Replace with your endpoint

        try {
            const response = await fetch(endpoint);
            const data = await response.json();

            // Clear existing markers
            clearMarkers();

            // Add new markers for each user
            data.forEach(user => {
                const userImage = "assets/images/users/" + user.user_name + ".jpg";
                const icon = {
                    url: userImage,
                    scaledSize: new google.maps.Size(40, 40), // Adjust size as needed
                };
                const [latitude, longitude] = user.clockin_location.split(',');
                new google.maps.Marker({
                    position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
                    map: map,
                    title: user.name,
                    icon: icon,
                });
            });
        } catch (error) {
            console.error('Error fetching user locations:', error);
        }
    }

    function clearMarkers() {
        // Implement marker clearing logic if needed
    }



    function formatTime(date) {
        let hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
        let minutes = date.getMinutes();
        let ampm = date.getHours() >= 12 ? 'PM' : 'AM';
        return (hours < 10 ? '0' + hours : hours) + ':' + (minutes < 10 ? '0' + minutes : minutes) + ' ' + ampm;
    }

    // Set location text
    function setAttendance(elementId, latitude, longitude, time) {
        document.getElementById(elementId + '-time').style.display = '';
        document.getElementById(elementId + '-time').textContent = time;
        document.getElementById(elementId + '-location').style.display = '';
        document.getElementById(elementId + '-location').textContent = `Location: ${latitude.toFixed(4)}, ${longitude.toFixed(4)}`;
        document.getElementById(elementId + '-button').style.display = 'none';
        document.getElementById(elementId === 'clock-in' ? 'clock-out-button' : '').style.display = '';
    }

    // Send clock data via AJAX
    function sendClockData(route, time, latitude, longitude, userId) {
        const date = new Date().toISOString().split('T')[0]; // Current date in YYYY-MM-DD format

        $.ajax({
            url: route,
            type: 'POST',
            data: {
                user_id: userId,
                date: date,
                time: time,
                location: latitude.toFixed(4) + ', ' + longitude.toFixed(4)
            },
            success: function(response) {
                console.log('Clock data sent successfully');
            },
            error: function(xhr, status) {
                console.error(xhr.responseText);
            }
        });
    }


    // Event listener for the clock-in button
    document.getElementById('clock-in-button').addEventListener('click', async function() {
        let now = new Date();
        let time = formatTime(now);

        navigator.geolocation.getCurrentPosition(async function(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            setAttendance('clock-in', latitude, longitude, time);
            sendClockData('{{ route('clockin') }}', time, latitude, longitude, user.id);
        });
    });

    document.getElementById('clock-out-button').addEventListener('click', function() {
        let now = new Date();
        let time = formatTime(now);

        navigator.geolocation.getCurrentPosition(function(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            setAttendance('clock-out', latitude, longitude, time);
            sendClockData('{{ route('clockout') }}', time, latitude, longitude, user.id);
        });
    });

</script>
    <style>
        .project-name {
            background-color: #4285F4;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 10px;
            padding: 5px 10px;
            position: relative;
        }

        .project-name::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 100%;
            transform: translate(-50%, 0);
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 8px solid #4285F4;
        }
    </style>
@endsection

