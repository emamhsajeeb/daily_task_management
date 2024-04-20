@extends('layouts.app',['user' => $user])

@section('attendance')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

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

                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button title="Add NCR" class="btn btn-outline-primary btn-icon waves-effect waves-light" id="showAddModalBtn"><i class="ri-add-box-line align-bottom me-1"></i></button>
                                    </div>
                                </div>

                            </div><!-- end card header -->

                            <div class="card-body">

                                <div class="live-preview">
                                    <div class="table-responsive table-card">
                                        <table id="attendanceTable" style="table-border: 1px solid black">
                                            <thead>
                                            <tr>
                                                <td rowspan="2">SL</td>
                                                <td rowspan="2">Name</td>
                                                <!-- Date columns -->
                                                <td colspan="30">Date: 01.04.2024 - 30.04.2024</td>
                                                <!-- Reason for leave columns -->
                                                <td colspan="8">Reason for leave (days)</td>
                                                <td>Remark</td>
                                            </tr>
                                            <tr>
                                                <!-- Date headers -->
                                                <!-- Insert date headers dynamically using JavaScript -->
                                                <!-- Leave reason headers -->
                                                <td colspan="30">
                                                    <!-- Insert date numbers dynamically using JavaScript -->
                                                </td>
                                                <td>Absence</td>
                                                <td>Personal</td>
                                                <td>Sick</td>
                                                <td>Marital</td>
                                                <td>Funeral</td>
                                                <td>Maternity</td>
                                                <td>Annual Holiday</td>
                                                <td>Festival Holiday</td>
                                                <td></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!-- Table body content will be populated dynamically -->
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <!-- Remark footer -->
                                                <td colspan="41">Remark: Symbol description: “√” attendance, “§” personal leave, “×” sickness, “◎” maternity leave, “■” funeral leave, “△” annual holiday, “□” marital leave, “☆” late, “*” leave early, “○” business trip, “▼” absence, “/” weekend, “#” festival holiday.</td>
                                            </tr>
                                            </tfoot>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add NCR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form class="tablelist-form" autocomplete="off" id="addNcrForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="ncr_no" class="form-label">NCR Number</label>
                                <input type="text" name="ncr_no" id="ncr_no" class="form-control" placeholder="Enter NCR Number..." required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="ref_no" class="form-label">Reference Number</label>
                                <input type="text" name="ref_no" id="ref_no" class="form-control" placeholder="Enter Reference Number..." required />
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="ncr_type" class="form-label">NCR Type</label>
                                <select name="ncr_type" class="form-control" id="ncr_type" required>
                                    <option selected value="Structure">Structure</option>
                                    <option value="Embankment">Embankment</option>
                                    <option value="Pavement">Pavement</option>
                                </select>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <label for="ncrStatus" class="form-label">Status</label>
                                <select name="status" class="form-control" id="ncrStatus" required>
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
                            <button type="button" class="btn btn-success" id="addNcr">Add NCR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal-->

    <div class="modal modal-lg zoomIn" id="ncrDetailsModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ncrNumber"></h5><h5 class="modal-title" id="ncrDate"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div  class="modal-body">
                    <h6 id="ncrDate" class="fs-15">Details:</h6>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2 ">
                            <p id="ncrDetails" class="text-muted mb-0"></p>
                        </div>
                    </div>
                    <h6 id="ncrDate" class="fs-15">Chainages:</h6>
                    <div class="d-flex mt-2">
                        <div class="flex-shrink-0">
                            <i class="ri-checkbox-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-2 ">
                            <p id="ncrChainages" class="text-muted mb-0"></p>
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
            var ncrs;

            async function updateAttendance() {
                // Initialize DataTables
                var table = $('#attendanceTable').DataTable();

                // Example data
                var attendanceData = [
                    // Sample data for a single person
                    // Replace this with your actual data fetched from your source
                    {
                        name: "Md. Hafizur Rahman",
                        attendance: ["√", "√", "√", "√", "/", "√", "#", "√", "#", "#", "#", "#", "#", "#", "#", "√", "√", "√", "√", "/", "√", "√", "√", "√", "√", "√", "/", "√", "√", "√", "√", "-", "-", "-", "-", "-", "-", "-", "-", "7", ""]
                    }
                    // Add more data objects for additional persons
                ];

                // Populate table body
                attendanceData.forEach(function(person) {
                    var row = $('<tr>');
                    row.append('<td>1</td>'); // Sample SL value, replace as needed
                    row.append('<td>' + person.name + '</td>'); // Person's name

                    // Attendance data
                    person.attendance.forEach(function(attendance) {
                        row.append('<td>' + attendance + '</td>');
                    });

                    // Append row to table body
                    $('#attendanceTable tbody').append(row);
                });

                // Insert date numbers dynamically into the date columns
                var dateColumns = $('#attendanceTable thead tr:nth-child(2) td[colspan="30"]');
                dateColumns.each(function(index) {
                    $(this).text(index + 1); // Assuming dates start from 1st of the month
                });

                preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
                preloader.style.visibility = 'hidden'; // Set visibility to visible
            }


            async function updateNCRList() {
                var header = `
    <tr>
        <th scope="col">NCR No.</th>
        <th scope="col">Reference No.</th>
        <th scope="col">Date</th>
        <th scope="col">NCR Type</th>
        <th scope="col">Status</th>
        <th scope="col">Remarks</th>
        <th scope="col" style="width: 150px;">Action</th>
    </tr>
    `;

                $('#ncrTableHead').html(header).css('text-align', 'center');

                await $.ajax({
                    url: '{{ route("allNCRs") }}',
                    method: 'GET',
                    dataType: 'json',
                    success: async function (response) {
                        ncrs = response.ncrs;

                        // Initialize an empty string to store the HTML for rows
                        var rowsHTML = '';

                        // Iterate over each NCR object and construct HTML for each row
                        ncrs.forEach(function (ncr) {
                            var iconHtml = `
                <span icon-task-id="${ncr.id}">
                    <i  style="${ncr.status === 'Closed' ? 'color: green' :
                                ncr.status === 'Partially Closed' ? 'color: orange' :
                                    ncr.status === 'Open' ? 'color: red' : ''}"
                        class="${ncr.status === 'Closed' ? 'ri-checkbox-circle-line fs-17 align-middle' :
                                ncr.status === 'Partially Closed' ? 'ri-timer-2-line fs-17 align-middle' :
                                    ncr.status === 'Open' ? 'ri-close-circle-line fs-17 align-middle' : ''}"></i>
                </span>
            `;
                            var statusOptions = `
                <select id="status-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="${ncr.id}">
                    <option value="Closed" ${ncr.status === 'Closed' ? 'selected' : ''}>Closed</option>
                    <option value="Partially Closed" ${ncr.status === 'Partially Closed' ? 'selected' : ''}>Partially Closed</option>
                    <option value="Open" ${ncr.status === 'Open' ? 'selected' : ''}>Open</option>
                </select>
            `;
                            rowsHTML += `
                <tr>
                    <td>${ncr.ncr_no}</td>
                    <td>${ncr.ref_no}</td>
                    <td>${ncr.issue_date}</td>
                    <td>${ncr.ncr_type}</td>
                    <td>${ iconHtml + statusOptions}</td>
                    <td>${ncr.remarks}</td>
                    <td>
                        <button type="button" ncr-id=${ncr.id} class="btn btn-sm btn-light ncr-details-btn">Details</button>
                    </td>
                </tr>
            `;
                        });

                        // Add the generated HTML for rows to the table body
                        $('#ncrTableBody').html(rowsHTML);

                        // Set text-align to center for the table body
                        $('#ncrTableBody').css('text-align', 'center');

                        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
                        preloader.style.visibility = 'hidden'; // Set visibility to visible

                    },
                    error: function(xhr, status, error) {
                        return error;
                    }
                });

            }

            // Function to handle form submission via AJAX
            async function addNCR() {
                // Get form data
                var formData = new FormData(document.getElementById('addNcrForm'));

                // AJAX request
                $.ajax({
                    url: '{{ route('addNCR') }}',
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
                        console.log(response.ncrs);
                        const ncrs = response.ncrs;

                        await updateNCRList(ncrs);

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
                $('#addNcr').html('Add NCR');
                $('#addNcr').prop('disabled', false);
            }

            async function editNCRRemarks(element) {
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
            async function updateNCRStatus(taskId, status) {
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

            // Function to fetch and display NCR details
            async function ncrDetails(ncr) {
                // Update modal body with NCR details
                $('#ncrDetailsModal').find('#ncrNumber').text(ncr.ncr_no);
                // Apply inline CSS
                $('#ncrDetailsModal').find('#ncrDetails').html('<pre style="font-family: Arial, sans-serif; font-size: 14px; color: #333; text-wrap: wrap;">' + ncr.details + '</pre>');
                $('#ncrDetailsModal').find('#ncrChainages').html('<pre style="font-family: Arial, sans-serif; font-size: 14px; color: #333; text-wrap: wrap;">' + ncr.chainages + '</pre>');
                $("#ncrDetailsModal").modal('show');
            }

            $( document ).ready(async function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                await updateAttendance();

                $("#showAddModalBtn").click(function () {
                    $("#showAddModal").modal('show');
                });

                $('#addNcr').click(async function (e) {
                    e.preventDefault();
                    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
                    $(this).prop('disabled', true);
                    await addNCR();
                });

                $(document).on('click', '.ncr-details-btn', async function () {
                    const ncrId = parseInt($(this).attr('ncr-id'));
                    console.log("ncr-id attribute value:", ncrId); // Debugging
                    const ncr = ncrs.find(item => item.id === ncrId);
                    console.log("ncr found:", ncr); // Debugging
                    await ncrDetails(ncr);
                });

                $('#filterTasks').click(async function (e) {
                    e.preventDefault();
                    $('#filterTasks').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Filtering...');
                    $('#filterTasks').prop('disabled', true);
                    await filterTaskList();
                });

                await $('#exportToExcel').click(async function (e) {
                    e.preventDefault();
                    $('#exportToExcel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    $('#exportToExcel').prop('disabled', true);
                    await exportToExcel();
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
