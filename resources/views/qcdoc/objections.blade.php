@extends('layouts.app',['user' => $user])

@section('objections')
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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">QC Reports</a></li>
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
                                        <button title="Add Objection" class="btn btn-outline-primary btn-icon waves-effect waves-light" id="showAddModalBtn"><i class="ri-add-box-line align-bottom me-1"></i></button>
                                    </div>
                                </div>
                                @endrole

                            </div><!-- end card header -->

                            <div class="card-body">

                                <div class="live-preview">
                                    <div class="table-responsive table-card">
                                        <table id="objTable" class="table align-middle table-nowrap table-hover table-striped-columns mb-0">
                                            <thead id="objTableHead" class="table-light">
                                            </thead>
                                            <tbody id="objTableBody">
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Objection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form class="tablelist-form" autocomplete="off" id="addObjectionForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="obj_no" class="form-label">Objection Number</label>
                                <input type="text" name="obj_no" id="obj_no" class="form-control" placeholder="Enter Objection Number..." required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="ref_no" class="form-label">Reference Number</label>
                                <input type="text" name="ref_no" id="ref_no" class="form-control" placeholder="Enter Reference Number..." required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="obj_type" class="form-label">Objection Type</label>
                                <select name="obj_type" class="form-control" id="obj_type" required>
                                    <option selected value="Structure">Structure</option>
                                    <option value="Embankment">Embankment</option>
                                    <option value="Pavement">Pavement</option>
                                </select>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="objStatus" class="form-label">Status</label>
                                <select name="status" class="form-control" id="objStatus" required>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Partially Closed">Partially Closed</option>
                                </select>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="issue_date" class="form-label">Issue Date</label>
                                <input type="date" name="issue_date" id="issue_date" class="form-control" required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <label for="chainages" class="form-label">Chainages</label>
                                <textarea class="form-control" name="chainages" id="chainages" rows="4" placeholder="Enter Chainages..."></textarea>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <label for="details" class="form-label">Details</label>
                                <textarea class="form-control" name="details" id="details" rows="4" placeholder="Enter details..."></textarea>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Enter Remarks..." />
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="addObjection">Add Objection</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal-->

    <div class="modal modal-lg zoomIn" id="objDetailsModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="objNumber"></h5><h5 class="modal-title" id="objDate"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div  class="modal-body">
                    <h6 id="objDate" class="fs-15">Details:</h6>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2 ">
                            <p id="objDetails" class="text-muted mb-0"></p>
                        </div>
                    </div>
                    <h6 id="objDate" class="fs-15">Chainages:</h6>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2 ">
                            <p id="objChainages" class="text-muted mb-0"></p>
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
            var objections;


            async function updateObjectionList() {
                var header = `
    <tr>
        <th scope="col">Objection No.</th>
        <th scope="col">Reference No.</th>
        <th scope="col">Date</th>
        <th scope="col">Objection Type</th>
        <th scope="col">Status</th>
        <th scope="col">Remarks</th>
        <th scope="col" style="width: 150px;">Action</th>
    </tr>
    `;

                $('#objTableHead').html(header).css('text-align', 'center');

                await $.ajax({
                    url: '{{ route("allObjections") }}',
                    method: 'GET',
                    dataType: 'json',
                    success: async function (response) {
                        objs = response.objections;

                        // Initialize an empty string to store the HTML for rows
                        var rowsHTML = '';

                        // Iterate over each Objection object and construct HTML for each row
                        objs.forEach(function (obj) {
                            var iconHtml = `
                <span icon-task-id="${obj.id}">
                    <i  style="${obj.status === 'Closed' ? 'color: green' :
                                obj.status === 'Partially Closed' ? 'color: orange' :
                                    obj.status === 'Open' ? 'color: red' : ''}"
                        class="${obj.status === 'Closed' ? 'ri-checkbox-circle-line fs-17 align-middle' :
                                obj.status === 'Partially Closed' ? 'ri-timer-2-line fs-17 align-middle' :
                                    obj.status === 'Open' ? 'ri-close-circle-line fs-17 align-middle' : ''}"></i>
                </span>
            `;
                            var statusOptions = `
                <select id="status-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="${obj.id}">
                    <option value="Closed" ${obj.status === 'Closed' ? 'selected' : ''}>Closed</option>
                    <option value="Partially Closed" ${obj.status === 'Partially Closed' ? 'selected' : ''}>Partially Closed</option>
                    <option value="Open" ${obj.status === 'Open' ? 'selected' : ''}>Open</option>
                </select>
            `;
                            rowsHTML += `
                <tr>
                    <td>${obj.obj_no}</td>
                    <td>${obj.ref_no}</td>
                    <td>${obj.issue_date}</td>
                    <td>${obj.obj_type}</td>
                    <td>${ iconHtml + statusOptions}</td>
                    <td>${obj.remarks ? obj.remarks : "N/A" }</td>
                    <td>
                        <button type="button" obj-id=${obj.id} class="btn btn-sm btn-light obj-details-btn">Details</button>
                        <div class="hstack gap-3 flex-wrap">
                            <a href="javascript:void(0);" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
                            <a href="javascript:void(0);" class="link-danger fs-15"><i class="ri-delete-bin-line"></i></a>
                        </div>
                    </td>
                </tr>
            `;
                        });


                        // Add the generated HTML for rows to the table body
                        $('#objTableBody').html(rowsHTML);

                        // Set text-align to center for the table body
                        $('#objTableBody').css('text-align', 'center');

                        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
                        preloader.style.visibility = 'hidden'; // Set visibility to visible

                    },
                    error: function(xhr, status, error) {
                        return error;
                    }
                });

            }

            // Function to handle form submission via AJAX
            async function addObjection() {
                // Get form data
                var formData = new FormData(document.getElementById('addObjectionForm'));

                // AJAX request
                $.ajax({
                    url: '{{ route('addObjection') }}',
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
                        console.log(response.objections);
                        const objs = response.objections;

                        await updateObjectionList(objs);

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
                $('#addObjection').html('Add Objection');
                $('#addObjection').prop('disabled', false);
            }

            async function editObjectionRemarks(element) {
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
            async function updateObjectionStatus(taskId, status) {
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

            // Function to fetch and display Objection details
            async function objDetails(obj) {
                // Update modal body with Objection details
                $('#objDetailsModal').find('#objNumber').text(obj.obj_no);
                // Apply inline CSS
                $('#objDetailsModal').find('#objDetails').html('<pre style="font-family: Arial, sans-serif; font-size: 14px; color: #333; text-wrap: wrap;">' + obj.details + '</pre>');
                $('#objDetailsModal').find('#objChainages').html('<pre style="font-family: Arial, sans-serif; font-size: 14px; color: #333; text-wrap: wrap;">' + obj.chainages + '</pre>');
                $("#objDetailsModal").modal('show');
            }

            $( document ).ready(async function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                await updateObjectionList();

                $("#showAddModalBtn").click(function () {
                    $("#showAddModal").modal('show');
                });

                $('#addObjection').click(async function (e) {
                    e.preventDefault();
                    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
                    $(this).prop('disabled', true);
                    await addObjection();
                });

                $(document).on('click', '.obj-details-btn', async function () {
                    const objId = parseInt($(this).attr('obj-id'));
                    console.log("obj-id attribute value:", objId); // Debugging
                    const obj = objs.find(item => item.id === objId);
                    console.log("obj found:", obj); // Debugging
                    await objDetails(obj);
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
