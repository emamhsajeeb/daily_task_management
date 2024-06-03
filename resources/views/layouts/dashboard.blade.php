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
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span id="clock-in-time" class="counter-value">08:00 AM</span></h2>
                                    <p id="clock-in-location" class="text-50"></p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span id="clock-out-time" class="counter-value">05:00 PM</span></h2>
                                    <p id="clock-out-location" class="text-50"></p>
                                    <button id="clock-in-button" class="btn btn-success mt-3">Clock In</button>
                                    <button id="clock-out-button" class="btn btn-danger mt-3">Clock Out</button>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-white bg-opacity-25 rounded-circle fs-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-white"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
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
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<script>
    const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};
    const user = {!! json_encode($user) !!};



    $( document ).ready(function() {
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        var preloader = document.getElementById('preloader');
        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
        preloader.style.visibility = 'hidden'; // Set visibility to visible
    });

    function formatTime(date) {
        let hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
        let minutes = date.getMinutes();
        let ampm = date.getHours() >= 12 ? 'PM' : 'AM';
        return (hours < 10 ? '0' + hours : hours) + ':' + (minutes < 10 ? '0' + minutes : minutes) + ' ' + ampm;
    }


    // Replace with your OpenRouteService API key
    const apiKey = 'AIzaSyD35-Jeo7nF8vCB4qqWVstbQJpQQALh4KQ';

    // Start and end locations (longitude and latitude)
    const startLocation = [23.98669,90.36241]; // San Francisco (longitude, latitude)
    const endLocation = [23.69046,90.54668]; // Los Angeles (longitude, latitude)

    // Function to get the detailed path from OpenRouteService API
    async function getHighwayPath(startLocation, endLocation, apiKey) {
        const url = `https://maps.googleapis.com/maps/api/directions/json?origin=${startLocation}&destination=${endLocation}&key=${apiKey}`;
        const response = await $.ajax({
            url: url,
            type: 'GET',
            contentType: 'application/json',
        });
        return response.data.features[0].geometry.coordinates.map(coord => ({
            latitude: coord[1],
            longitude: coord[0]
        }));
    }

    // Generate geolocation points for each km marker
    function generateKmMarkers(polylinePoints, intervalMeters) {
        const markers = [];
        let distanceAccumulator = 0;
        let lastPoint = polylinePoints[0];

        for (let i = 1; i < polylinePoints.length; i++) {
            const point = polylinePoints[i];
            const distance = geolib.getDistance(lastPoint, point);

            if (distanceAccumulator + distance >= intervalMeters) {
                markers.push(point);
                distanceAccumulator = 0;
            } else {
                distanceAccumulator += distance;
            }

            lastPoint = point;
        }

        return markers;
    }

    // Check if the user's location is within 500 meters of any km marker
    function isValidLocation(userLocation, kmMarkers, maxDistanceMeters) {
        return kmMarkers.some(marker => geolib.getDistance(userLocation, marker) <= maxDistanceMeters);
    }

    // Find the nearest km marker to the user's location
    function findNearestKmMarker(userLocation, kmMarkers) {
        let nearestKm = null;
        let shortestDistance = Infinity;
        kmMarkers.forEach((marker, index) => {
            const distance = geolib.getDistance(userLocation, marker);
            if (distance < shortestDistance) {
                shortestDistance = distance;
                nearestKm = index;
            }
        });
        return nearestKm;
    }


    // Set location text
    function setLocation(elementId, latitude, longitude) {
        document.getElementById(elementId).textContent = `Location: ${latitude.toFixed(4)}, ${longitude.toFixed(4)}`;
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
        document.getElementById('clock-in-time').textContent = time;

        navigator.geolocation.getCurrentPosition(async function(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            setLocation('clock-in-location', latitude, longitude);

            const polylinePoints = await getHighwayPath(startLocation, endLocation, apiKey);
            const kmMarkers = generateKmMarkers(polylinePoints, 1000); // 1 km interval

            const userLocation = { latitude: latitude, longitude: longitude };
            const maxDistanceMeters = 500;

            if (isValidLocation(userLocation, kmMarkers, maxDistanceMeters)) {
                const nearestKm = findNearestKmMarker(userLocation, kmMarkers);
                console.log(`The user is nearest to km marker: ${nearestKm}`);
                sendClockData('{{ route('clockin') }}', time, latitude, longitude, user.id);
            } else {
                console.log('User location is invalid (more than 500 meters from the road).');
                sendClockData('{{ route('clockin') }}', time, latitude, longitude, user.id);
            }
        });
    });




    document.getElementById('clock-in-button').addEventListener('click', function() {
        let now = new Date();
        let time = formatTime(now);
        document.getElementById('clock-in-time').textContent = time;

        navigator.geolocation.getCurrentPosition(function(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            setLocation('clock-in-location', latitude, longitude);

            // Send clock-in data to Laravel backend
            sendClockData('{{ route('clockin') }}', time, latitude, longitude);
        });
    });

    document.getElementById('clock-out-button').addEventListener('click', function() {
        let now = new Date();
        let time = formatTime(now);
        document.getElementById('clock-out-time').textContent = time;

        navigator.geolocation.getCurrentPosition(function(position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            setLocation('clock-out-location', latitude, longitude);

            // Send clock-out data to Laravel backend
            sendClockData('{{ route('clockout') }}', time, latitude, longitude);
        });
    });

</script>
@endsection

