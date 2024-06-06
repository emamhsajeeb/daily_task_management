@extends('layouts.app',['user' => $user])

@section('work_locations')
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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                    <li class="breadcrumb-item active">{{ $title }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">{{ $title }}</h4>

                                @role('admin')
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button title="Add Work Location" class="btn btn-outline-primary btn-icon waves-effect waves-light" id="showAddModalBtn"><i class="ri-add-box-line align-bottom me-1"></i></button>
                                    </div>
                                </div>
                                @endrole

                            </div><!-- end card header -->

                            <div class="card-body">

                                <div class="live-preview">
                                    <div class="table-responsive table-card">
                                        <table id="workLocationTable" class="table align-middle table-nowrap table-hover table-striped-columns mb-0">
                                            <thead id="workLocationTableHead" class="table-light">
                                            </thead>
                                            <tbody id="workLocationTableBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->

    <div class="modal fade zoomIn" id="showAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="exampleModalLabel">Add WorkLocation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form class="tablelist-form" autocomplete="off" id="addWorkLocationForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="work_location_name" class="form-label">Location Name</label>
                                <input type="text" name="work_location_name" id="work_location_no" class="form-control" placeholder="Enter Work Location Name..." required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="start_chainage" class="form-label">Start Chainage</label>
                                <input type="text" name="start_chainage" id="start_chainage" class="form-control" placeholder="Enter Start Chainage..." required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="end_chainage" class="form-label">End Chainage</label>
                                <input type="text" name="end_chainage" id="end_chainage" class="form-control" placeholder="Enter End Chainage..." required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="incharge" class="form-label">WorkLocation Type</label>
                                <select name="incharge" class="form-control" id="incharge" required>
                                    <option selected value="Structure">Structure</option>
                                    <option value="Embankment">Embankment</option>
                                    <option value="Pavement">Pavement</option>
                                </select>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="addWorkLocation">Add Work Location</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal-->

    <div class="modal modal-lg zoomIn" id="workLocationDetailsModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workLocationNumber"></h5><h5 class="modal-title" id="workLocationDate"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div  class="modal-body">
                    <h6 id="workLocationDate" class="fs-15">Details:</h6>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2 ">
                            <p id="workLocationDetails" class="text-muted mb-0"></p>
                        </div>
                    </div>
                    <h6 id="workLocationDate" class="fs-15">Chainages:</h6>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2 ">
                            <p id="workLocationChainages" class="text-muted mb-0"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <script>
            const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};
            var user = {!! json_encode($user) !!};
            var work_locations;
            var preloader = document.getElementById('preloader');


            async function updateWorkLocationList() {
                var header = `
                    <tr>
                        <th scope="col">Location</th>
                        <th scope="col">Start Chainage</th>
                        <th scope="col">End Chainage</th>
                        <th scope="col">Incharge</th>
                        <th scope="col" style="width: 150px;">Action</th>
                    </tr>
                    `;

                $('#workLocationTableHead').html(header).css('text-align', 'center');

                await $.ajax({
                    url: '{{ route("allWorkLocations") }}',
                    method: 'GET',
                    dataType: 'json',
                    success: async function (response) {
                        work_locations = response.work_locations;

                        // Initialize an empty string to store the HTML for rows
                        var rowsHTML = '';

                        // Iterate over each WorkLocation workLocationect and construct HTML for each row
                        work_locations.forEach(function (workLocation) {
                            // var iconHtml = `
                            //         <span icon-task-id="${workLocation.id}">
                            //             <i  style="${workLocation.status === 'Closed' ? 'color: green' :
                            //     workLocation.status === 'Partially Closed' ? 'color: orange' :
                            //         workLocation.status === 'Open' ? 'color: red' : ''}"
                            //                 class="${workLocation.status === 'Closed' ? 'ri-checkbox-circle-line fs-17 align-middle' :
                            //     workLocation.status === 'Partially Closed' ? 'ri-timer-2-line fs-17 align-middle' :
                            //         workLocation.status === 'Open' ? 'ri-close-circle-line fs-17 align-middle' : ''}"></i>
                            //         </span>
                            //     `;
                            // var statusOptions = `
                            //         <select id="status-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="${workLocation.id}">
                            //             <option value="Closed" ${workLocation.status === 'Closed' ? 'selected' : ''}>Closed</option>
                            //             <option value="Partially Closed" ${workLocation.status === 'Partially Closed' ? 'selected' : ''}>Partially Closed</option>
                            //             <option value="Open" ${workLocation.status === 'Open' ? 'selected' : ''}>Open</option>
                            //         </select>
                            //     `;
                            rowsHTML += `
                                <tr>
                                    <td>${workLocation.location}</td>
                                    <td>${workLocation.start_chainage}</td>
                                    <td>${workLocation.end_chainage}</td>
                                    <td>${workLocation.incharge}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">

                                            <a href="javascript:void(0);" onclick="editWorkLocation(${workLocation.id})" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
                                            <a href="javascript:void(0);" onclick="deleteWorkLocation(${workLocation.id})" class="link-danger fs-15"><i class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });


                        // Add the generated HTML for rows to the table body
                        $('#workLocationTableBody').html(rowsHTML);

                        // Set text-align to center for the table body
                        $('#workLocationTableBody').css('text-align', 'center');

                        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
                        preloader.style.visibility = 'hidden'; // Set visibility to visible

                    },
                    error: function(xhr, status, error) {
                        return error;
                    }
                });

            }

            // Function to handle form submission via AJAX
            async function addWorkLocation() {
                // Get form data
                var formData = new FormData(document.getElementById('addWorkLocationForm'));

                // AJAX request
                $.ajax({
                    url: '{{ route('addWorkLocation') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: async function (response) {
                        var preloader = document.getElementById('preloader');
                        toastr.success(response.message);
                        $("#showAddModal").modal('hide');

                        preloader.style.opacity = '1'; // Set opacity to 1 to make it visible
                        preloader.style.visibility = 'visible'; // Set visibility to visible
                        console.log(response.work_locations);
                        const workLocations = response.work_locations;

                        await updateWorkLocationList(workLocations);

                        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
                        preloader.style.visibility = 'hidden'; // Set visibility to visible

                    },
                    error: function(xhr, status) {
                        console.log(xhr.responseText)
                        // Handle error
                        var errorData = JSON.parse(xhr.responseText).error;
                        var delay = 300;
                        for (var error in errorData) {
                            (function(error) { // Closure to capture the current value of 'error'
                                setTimeout(function() {
                                    toastr.error(errorData[error], {
                                        "closeButton": true,
                                        "debug": false,
                                        "newestOnTop": false,
                                        "progressBar": false,
                                        "positionClass": "toast-top-center",
                                        "preventDuplicates": false,
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    });
                                }, delay);
                            })(error); // Pass the current value of 'error' to the closure
                            delay += 300;
                        }
                    }
                });
                // Once filtering is done, restore the button
                $('#addWorkLocation').html('Add WorkLocation');
                $('#addWorkLocation').prop('disabled', false);
            }

            async function editWorkLocationRemarks(element) {
                element.removeAttribute('onclick');
                var taskId = element.getAttribute('data-task-id');
                var inspectionText = element.querySelector('.inspection-text');
                var inspectionInput = element.querySelector('.inspection-input');
                var saveBtn = element.querySelector('.save-btn');

                inspectionText.style.display = 'none';
                inspectionInput.value = inspectionText.textContent === 'N/A' ? '' : inspectionText.textContent;
                inspectionInput.style.display = 'block';
                saveBtn.style.display = 'block';
                $(saveBtn).on('click', async function () {
                    await updateInspectionDetails(element, taskId, inspectionText, inspectionInput, saveBtn);
                })
            }

            // Function to handle status update
            async function updateWorkLocationStatus(taskId, status) {
                $.ajax({
                    url : "{{ route('updateTaskStatus') }}",
                    type:"POST",
                    data: {
                        id: taskId,
                        status: status
                    },
                    success:function (data) {
                        var icon = document.querySelector(`[icon-task-id="${taskId}"]`);
                        icon.innerHTML = '';
                        var newIcon = (status) => {
                            return status === 'new' ? '<i icon-task-id="${ taskId }" style="color: blue" class="ri-add-circle-line fs-17 align-middle"></i>' :
                                status === 'resubmission' ? '<i icon-task-id="${ taskId }" style="color: orange" class="ri-timer-2-line fs-17 align-middle"></i>' :
                                    status === 'completed' ? '<i icon-task-id="${ taskId }" style="color: green" class="ri-checkbox-circle-line fs-17 align-middle"></i>' :
                                        status === 'emergency' ? '<i icon-task-id="${ taskId }" style="color: red" class="ri-information-line fs-17 align-middle"></i>' : ''
                        };
                        toastr.success(data.message+status);
                        icon.innerHTML = newIcon(status);
                        status === 'completed' ? $('#completionDateTime').click() : '';
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                })
            }

            // Function to handle editing a task
            async function editWorkLocation(workLocationId) {
                // Implement your logic here for editing the task
                // For example, you can use AJAX to send a request to the server to edit the task
                // Replace the URL with your actual endpoint for editing a task
                $.ajax({
                    url: "{{ route('updateWorkLocation') }}",
                    type: "POST",
                    data: {
                        id: workLocationId
                    },
                    success: function(data) {
                        // Handle success response
                        console.log("WorkLocation updated successfully");
                        // You can add further actions as needed after editing the task
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to handle deleting a task
            async function deleteWorkLocation(workLocationId) {
                $.ajax({
                    url: "{{ route('deleteWorkLocation') }}",
                    type: "POST",
                    data: {
                        id: workLocationId
                    },
                    success: async function (response) {
                        await updateWorkLocationList();
                        // Handle success response
                        console.log(response.message);
                        // You can add further actions as needed after deleting the task
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to fetch and display WorkLocation details
            async function workLocationDetails(workLocation) {
                // Update modal body with WorkLocation details
                $('#workLocationDetailsModal').find('#workLocationNumber').text(workLocation.work_location_no);
                // Apply inline CSS
                $('#workLocationDetailsModal').find('#workLocationDetails').html('<pre style="font-family: Arial, sans-serif; font-size: 14px; color: #333; text-wrap: wrap;">' + workLocation.details + '</pre>');
                $('#workLocationDetailsModal').find('#workLocationChainages').html('<pre style="font-family: Arial, sans-serif; font-size: 14px; color: #333; text-wrap: wrap;">' + workLocation.chainages + '</pre>');
                $("#workLocationDetailsModal").modal('show');
            }

            $( document ).ready(async function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                await updateWorkLocationList();

                $("#showAddModalBtn").click(function () {
                    $("#showAddModal").modal('show');
                });

                $('#addWorkLocation').click(async function (e) {
                    e.preventDefault();
                    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
                    $(this).prop('disabled', true);
                    await addWorkLocation();
                });

                $(document).on('click', '.work-location-details-btn', async function () {
                    const workLocationId = parseInt($(this).attr('work-location-id'));
                    console.log("work-location-id attribute value:", workLocationId); // Debugging
                    const workLocation = workLocations.find(item => item.id === workLocationId);
                    console.log("workLocation found:", workLocation); // Debugging
                    await workLocationDetails(workLocation);
                });
            });



            // // Event listener for dropdown change
            // $(document).on('input', '#status-dropdown', async function (e) {
            //     var taskId = e.target.getAttribute('data-task-id');
            //     var status = e.target.value;
            //     await updateTaskStatus(taskId, status);
            // });
            //
            // $(document).on('input', '#rfiSubmissionDate', async function (e) {
            //     var taskId = e.target.getAttribute('data-task-id');
            //     var date = e.target.value;
            //     await updateRfiSubmissionDate(taskId, date)
            // });
            //
            // $(document).on('input', '#completionDateTime', async function (e) {
            //     var taskId = e.target.getAttribute('data-task-id');
            //     var dateTime = e.target.value;
            //     await updateCompletionDateTime(taskId, dateTime)
            // });

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

        </script>

        <style>





        </style>
@endsection
