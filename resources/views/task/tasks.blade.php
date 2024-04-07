@extends('layouts.app',['user' => $user])
@section('tasks')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid" style="max-width: 100% !important;">
            <!-- start page title -->
            @role('admin')
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $title }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            @endrole
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="tasksList">
                        <div class="card-header border-0" style="padding-bottom: 0 !important;">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">{{ $title }}</h5>

                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        @can('addTaskSE')
                                            <button title="Add Task" class="btn btn-outline-primary btn-icon waves-effect waves-light" id="showAddModalBtn"><i class="ri-add-box-line align-bottom me-1"></i></button>
                                        @endcan
                                        @can('addTask')
                                            <button title="Add Task" class="btn btn-outline-primary btn-icon waves-effect waves-light" id="showAddModalBtn"><i class="ri-add-box-line align-bottom me-1"></i></button>
                                        @endcan
                                        @role('admin')
                                        <a title="Import Tasks" href="{{ route('importTasks') }}" class="btn btn-outline-warning btn-icon waves-effect waves-light"><i class="ri-upload-2-line align-bottom me-1"></i></a>
                                        <a title="Export Tasks" href="{{ route('exportTasks') }}" class="btn btn-outline-success btn-icon waves-effect waves-light"><i class="ri-download-2-line align-bottom me-1"></i></a>
                                        @endrole
                                    </div>
                                </div>

                            </div>
                        </div>
                        @role('admin')
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form id="filterTaskForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-xxl-3 col-sm-4">
                                        <input type="text" name="dateRange" class="form-control bg-light border-light" id="dateRangePicker"  placeholder="Select date range" />
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-4">
                                        <div class="input-light">
                                            <select name="status" class="form-control" id="taskStatus">
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="all">All</option>
                                                <option value="completed">Completed</option>
                                                <option value="new">New</option>
                                                <option value="resubmission">Resubmission</option>
                                                <option value="emergency">Emergency</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-4">
                                        <div class="input-light">
                                            <select name="incharge" class="form-control" id="taskIncharge">
                                                <option value="" disabled selected>Select Incharge</option>
                                                <option value="all">All</option>
                                                @foreach($incharges as $incharge)
                                                <option value="{{$incharge->user_name}}">{{$incharge->first_name.' '.$incharge->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-1 col-sm-4">
                                        <button type="button" class="btn btn-primary w-100" id="filterTasks">
                                            <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                            Filter
                                        </button>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        @endrole
                        <!--end card-body-->
                        <div class="card-body" style="{{ $user->hasRole('se') ? 'padding-top: 0 !important;' : '' }}">
                            <div class="table-responsive">
                                <div>
                                    <table id="taskTable" class="dt[-head]-center table-bordered column-order table-nowrap display compact align-middle">
                                        <thead id="taskListHead">
                                        </thead>
                                        <tbody id="taskListBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

<div class="modal fade zoomIn" id="showAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" id="addTaskForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="tasksId" />
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <label for="date" class="form-label">RFI Date</label>
                            <input type="date" name="date" id="date" class="form-control"  required />
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <div>
                                <label for="number" class="form-label">RFI Number</label>
                                <input name="number" type="text" id="number" class="form-control" placeholder="Enter RFI Number..." required />
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="time" class="form-label">Planned Time</label>
                            <input type="time" name="time" id="time" class="form-control"  required />
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" class="form-control" id="type" required>
                                <option value="Structure">Structure</option>
                                <option value="Embankment">Embankment</option>
                                <option value="Pavement">Pavement</option>
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="Enter location..." required />
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" id="description" class="form-control" placeholder="Enter descriptions..." required />
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="side" class="form-label">Road Type</label>
                            <select name="side" class="form-control" id="side" required>
                                <option value="SR-R">SR-R</option>
                                <option value="SR-L">SR-L</option>
                                <option value="TR-R">TR-R</option>
                                <option value="TR-L">TR-L</option>
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="qty_layer" class="form-label">Quantity/Layer No.</label>
                            <input type="text" name="qty_layer" id="qty_layer" class="form-control" placeholder="Enter quantity/layer number..." />
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="completion_time" class="form-label">Completion Date/Time</label>
                            <input type="datetime-local" name="completion_time" id="completion_time" class="form-control"/>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="state" class="form-label">Status</label>
                            <select name="status" class="form-control" id="state" required>
                                <option value="completed">Completed</option>
                                <option value="resubmission">Resubmission</option>
                                <option value="emergency">Emergency</option>
                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <label for="inspection_details" class="form-label">Comments</label>
                            <textarea class="form-control" name="inspection_details" id="inspection_details" rows="3" placeholder="Write comments..."></textarea>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="addTask">Add Task</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal-->
<script>

// Function to get the tasks dynamically
const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};
var user = {!! json_encode($user) !!};
const incharges = {!! json_encode($incharges) !!};

async function updateTaskListBody(tasks) {
    // Loop through tasks and create table rows
    var taskRow = '';
    $.each(tasks, function(index, task) {
        taskRow += `
            <tr>
                <td style="text-align: center" class="due_date">${task.date}</td>
                <td style="text-align: center" class="id">${task.number}</td>
                <td style="text-align: center" class="status" >
                    <span icon-task-id="${task.id}">
                    <i  style="${task.status === 'new' ? 'color: blue' :
            task.status === 'resubmission' ? 'color: orange' :
                task.status === 'completed' ? 'color: green' :
                    task.status === 'emergency' ? 'color: red' : ''}"
                        class="${task.status === 'new' ? ' ri-add-circle-line fs-17 align-middle' :
            task.status === 'resubmission' ? 'ri-timer-2-line fs-17 align-middle' :
                task.status === 'completed' ? 'ri-checkbox-circle-line fs-17 align-middle' :
                    task.status === 'emergency' ? 'ri-information-line fs-17 align-middle' : ''}"></i>
                    </span>
                    <select ${admin ? 'disabled' : ''} id="status-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="${task.id}">
                        <option value="new" ${task.status === "new" ? 'selected' : ''}>New</option>
                        <option value="resubmission" ${task.status === "resubmission" ? 'selected' : ''}>Resubmission</option>
                        <option value="completed" ${task.status === "completed" ? 'selected' : ''}>Completed</option>
                        <option value="emergency" ${task.status === "emergency" ? 'selected' : ''}>Emergency</option>
                    </select>
                </td>
                <td style="text-align: center" class="client_name">${task.type}</td>
                <td>
                    <div class="d-flex">
                        <div style="cursor: pointer; width: 200px; ${admin ? 'overflow: hidden; text-overflow: ellipsis' : 'overflow: auto;' }" title="${task.description}" class="flex-grow-1 tasks_name">${task.description}</div>
                    </div>
                </td>
                <td style="text-align: center" class="client_name">${task.location}</td>
                <td style="text-align: center" class="client_name">${task.side}</td>
                <td style="text-align: center" class="client_name">${task.qty_layer ? task.qty_layer : ''}</td>
                <td style="text-align: center" class="client_name">${task.planned_time}</td>
                `;

        if (admin) {
            // Find the incharge object that matches the task's incharge property
            var matchingIncharge = incharges.find(function (incharges) {
                return incharges.user_name === task.incharge;
            });
            var imagePath = "{{ asset("assets/images/users") }}" + "/" + matchingIncharge.user_name + ".jpg";
            taskRow += `
                        <td style="text-align: center" class="incharge">
                            <div class="avatar-group">
                                <a
                                    href="#"
                                    class="avatar-group-item"
                                    style="border: 2px solid #fff0; border-radius: 50%;"
                                    data-bs-trigger="hover"
                                    data-bs-placement="top"
                                    id="inchargeTooltip"
                                    title="${matchingIncharge.first_name}">
                                <img id="inchargeImage" src="${imagePath}" alt="" class="rounded-circle avatar-xxs" />
                                <span id="inchargeFirstName">${matchingIncharge.first_name}</span>
                                </a>
                            </div>
                        </td>
                            `;
        }

        taskRow += `
            <td style="text-align: center" class="client_name">
                <input data-task-id="${task.id}" value="${task.completion_time ? task.completion_time : ''}" style="border: none; outline: none; background-color: transparent;" type="datetime-local" id="completionDateTime" name="completion_time">
            </td>
            <td ${task.inspection_details ? `title="${task.inspection_details}"` : ''} class="client_name">
                <div style="cursor: pointer; width: 200px; ${task.inspection_details ? '' : 'text-align: center;'}" class="inspection-details" id= "inspectionDetails" ${admin ? '' : 'onclick="editInspectionDetails(this)"'}  data-task-id="${task.id}">
                    <span class="inspection-text" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 2; line-clamp: 2; " >${task.inspection_details ? task.inspection_details : 'N/A'}</span>
                    <textarea class="inspection-input" style="display: none; margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent;"></textarea>
                    <button style="display: none;" type="button" class="save-btn btn btn-light btn-sm">Save</button>
                </div>
            </td>
            <td style="text-align: center" class="client_name" title="${task.resubmission_date}">${task.resubmission_count ? (task.resubmission_count > 1 ? task.resubmission_count + " times" : task.resubmission_count + " time") : ''}</td>`;
        if(admin) {
            taskRow += `
                    <td style="text-align: center" class="client_name">
                        <input ${admin ? '' : 'disabled'} value="${task.rfi_submission_date ? task.rfi_submission_date : ''}" data-task-id="${task.id}" style="border: none; outline: none; background-color: transparent;" type="date" id="rfiSubmissionDate" name="rfi_submission_date">
                    </td>
                `;
        }
        if (admin) {
            taskRow += `
                    <td>Click</td>
                    </tr>
                    `;
        }
    });
    $('#taskListBody').html(taskRow);
    $('#taskTable').DataTable({
        processing: true,
        language: {
            processing: "<i class='fa fa-refresh fa-spin'></i>",
        },
        destroy: true,
        order: [[0,'desc']],
        scrollCollapse: true,
        scroller: true,
        scrollY: 500,
        deferRender: true,
        fixedHeader: {
            header: true,
            footer: true
        }
    });
}

async function updateTaskList() {
    var header = `
        <tr>
        <th>Date</th>
        <th>RFI NO</th>
        <th>Status</th>
        <th>Type</th>
        <th>Description</th>
        <th>Location</th>
        <th>Road Type</th>
        <th>Quantity/Layer No.</th>
        <th>Planned Time</th>
        ${admin ? `
        <th>In-charge</th>
        ` : ''}
        <th>Completion Date/Time</th>
        <th>Comments</th>
        <th>Resubmitted</th>
        ${admin ? `
        <th>RFI Submission Date</th>` : ''}
        ${admin ? `
        <th>Edit</th>
        ` : ''}
        </tr>
        `;

    $('#taskListHead').html(header);

    var preloader = document.getElementById('preloader');
    var url = admin ? '{{ route("allTasks") }}' : '{{ route("allTasksSE") }}';

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: async function (response) {
            var tasks = response;
            // Extracting dates from tasks
            const dates = tasks.map(task => new Date(task.date));

            // Finding the first and last dates
            const firstDate = new Date(Math.min(...dates));
            const lastDate = new Date(Math.max(...dates));
            console.log(firstDate, lastDate);

            await updateTaskListBody(tasks);
            $('#dateRangePicker').daterangepicker({
                minDate: firstDate,
                maxDate: lastDate,
            });

            // flatpickr("#dateRangePicker", {
            //     minDate: new Date(firstDate),
            //     maxDate: new Date(lastDate),
            //     mode: 'range', // Specify 'range' mode as a string
            // });
            preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
            preloader.style.visibility = 'hidden'; // Set visibility to visible
        },
        error: function(xhr, status, error) {
            return error;
        }
    });

}

async function filterTaskList() {

    // Get start and end dates from the date range picker
    var startDate = document.getElementById('dateRangePicker').value.split(" - ")[0];
    var endDate = document.getElementById('dateRangePicker').value.split(" - ")[1];
    var taskStatus = document.getElementById('taskStatus').value;
    var taskIncharge = document.getElementById('taskIncharge').value;

    try {
        await $.ajax({
            url : "{{ route('filterTasks') }}",
            type:"POST",
            data: {
                start: startDate,
                end: endDate,
                status: taskStatus,
                incharge: taskIncharge,
            },
            success:async function (response) {
                var preloader = document.getElementById('preloader');
                preloader.style.opacity = '1'; // Set opacity to 1 to make it visible
                preloader.style.visibility = 'visible'; // Set visibility to visible
                toastr.success(response.message);
                $('#taskTable').DataTable().clear().destroy();

                const tasks = response.tasks;

                await updateTaskListBody(tasks);
                preloader.style.opacity = '0'; // Set opacity to 1 to make it visibl
                preloader.style.visibility = 'hidden'; // Set visibility to visible
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    } finally {
        // Once filtering is done, restore the button
        $('#filterTasks').html('<i class="ri-equalizer-fill me-1 align-bottom"></i>Filter');
        $('#filterTasks').prop('disabled', false);
    }
}

// Function to handle form submission via AJAX
async function addTask() {
    setTimeout(function() {

        // Get form data
        var formData = new FormData(document.getElementById('addTaskForm'));

        // AJAX request
        $.ajax({
            url: admin ? '{{ route('addTask') }}' : '{{ route('addTaskSE') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: async function (response) {
                var preloader = document.getElementById('preloader');
                toastr.success(response.message);
                $("#showAddModal").modal('hide');
                $('#taskTable').DataTable().clear().destroy();
                preloader.style.opacity = '1'; // Set opacity to 1 to make it visible
                preloader.style.visibility = 'visible'; // Set visibility to visible
                console.log(response.tasks);
                const tasks = response.tasks;

                // Extracting dates from tasks
                const dates = tasks.map(task => new Date(task.date));

                // Finding the first and last dates
                const firstDate = new Date(Math.min(...dates));
                const lastDate = new Date(Math.max(...dates));

                $('#dateRangePicker').daterangepicker({
                    minDate: firstDate,
                    maxDate: lastDate,
                    opens: 'left'
                });

                // flatpickr("#dateRangePicker", {
                //     minDate: new Date(firstDate),
                //     maxDate: new Date(lastDate),
                //     mode: 'range', // Specify 'range' mode as a string
                //     // This onChange event handler will be triggered whenever the date range changes
                //     onClose: async function (selectedDates, dateStr, instance) {
                //         // Assuming you want to get the first and last dates from the selected date range
                //         var start = selectedDates[0];
                //         var end = selectedDates[selectedDates.length - 1];
                //
                //         // Call the updateTaskList function with the updated dates
                //         await updateTaskList(start, end);
                //     }
                // });

                await updateTaskListBody(tasks);
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
        $('#addTask').html('Add Task');
        $('#addTask').prop('disabled', false);
    }, 2000);
}

// Call the function when the page loads
$( document ).ready(async function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    await updateTaskList();

    $("#showAddModalBtn").click(function () {
        $("#showAddModal").modal('show');
    });

    $('#addTask').click(async function (e) {
        e.preventDefault();
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
        $(this).prop('disabled', true);
        await addTask();
    });

    $('#filterTasks').click(async function (e) {
        e.preventDefault();
        $('#filterTasks').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Filtering...');
        $('#filterTasks').prop('disabled', true);
        await filterTaskList();
    });
});

// Function to handle status update
async function updateTaskStatus(taskId, status) {
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

// Event listener for dropdown change
$(document).on('input', '#status-dropdown', async function (e) {
    var taskId = e.target.getAttribute('data-task-id');
    var status = e.target.value;
    await updateTaskStatus(taskId, status);
});


// Function to handle status update
async function updateRfiSubmissionDate(taskId, date) {
    $.ajax({
        url:"{{ route('updateRfiSubmissionDate') }}",
        type:"POST",
        data: {
            id: taskId,
            date: date
        },
        success:async function (data) {
            var status = 'complete';
            await updateTaskStatus(taskId, status);
            $('#status-dropdown').val('completed');
            $('#completionDateTime').click();
            toastr.success(data.message + date);
        }
    })
}

$(document).on('input', '#rfiSubmissionDate', async function (e) {
    var taskId = e.target.getAttribute('data-task-id');
    var date = e.target.value;
    await updateRfiSubmissionDate(taskId, date)
});

async function updateCompletionDateTime(taskId, dateTime) {
    $.ajax({
        url:admin ? "{{ route('updateCompletionDateTime') }}" : "{{ route('updateCompletionDateTimeSE') }}",
        type:"POST",
        data: {
            id: taskId,
            dateTime: dateTime
        },
        success:function (data) {
            toastr.success(data.message+dateTime);
        }
    })
}

$(document).on('input', '#completionDateTime', async function (e) {
    var taskId = e.target.getAttribute('data-task-id');
    var dateTime = e.target.value;
    await updateCompletionDateTime(taskId, dateTime)
});

async function editInspectionDetails(element) {
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

async function updateInspectionDetails(element, taskId, inspectionText, inspectionInput, saveBtn) {
    $.ajax({
        url:"{{ route('updateInspectionDetails') }}",
        type:"POST",
        data: {
            id: taskId,
            inspection_details: inspectionInput.value
        },
        success:function (data) {
            element.setAttribute('onclick', 'editInspectionDetails(this)');
            inspectionText.textContent = inspectionInput.value;
            inspectionText.style.display = 'block';
            inspectionText.style.textOverflow = 'ellipsis';
            inspectionInput.style.display = 'none';
            saveBtn.style.display = 'none';
            toastr.success(data.message);
        }
    })
}



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
@endsection


