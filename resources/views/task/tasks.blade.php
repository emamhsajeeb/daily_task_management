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
                                    @role('admin')
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
                                    @endrole
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
                        <!--end card-body-->
                        <div class="card-body" style="{{ $user->hasRole('se') ? 'padding-top: 0 !important;' : '' }}">
                            <div class="table-responsive">
                                <div>
                                    <table id="taskTable" class="dt[-head|-body]-center table-bordered column-order table-nowrap display compact align-middle">
                                        <thead id="taskListHead" style="text-align-all: center">
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
    var preloader = document.getElementById('preloader');
    if ($.fn.DataTable.isDataTable('#taskTable')) {
        $('#taskTable').DataTable().destroy();
    }
    // Ensure tasks is an array of objects
    if (!Array.isArray(tasks)) {
        // If tasks is not an array, try to extract the array of tasks from it
        tasks = tasks.data; // Assuming tasks is an object with a 'data' property containing the array of tasks
    }

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
        },
        data: tasks, // Pass tasks data to DataTable
        columns: [
                { data: 'date', searchable: true, className: 'dataTables-center' },
                { data: 'number', searchable: true, className: 'dataTables-center' },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        var iconHtml = `
                <span icon-task-id="${row.id}">
                    <i  style="${row.status === 'new' ? 'color: blue' :
                            row.status === 'resubmission' ? 'color: orange' :
                                row.status === 'completed' ? 'color: green' :
                                    row.status === 'emergency' ? 'color: red' : ''}"
                        class="${row.status === 'new' ? 'ri-add-circle-line fs-17 align-middle' :
                            row.status === 'resubmission' ? 'ri-timer-2-line fs-17 align-middle' :
                                row.status === 'completed' ? 'ri-checkbox-circle-line fs-17 align-middle' :
                                    row.status === 'emergency' ? 'ri-information-line fs-17 align-middle' : ''}"></i>
                </span>
            `;
                        var statusOptions = `
                <select id="status-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="${row.id}" ${admin ? 'disabled' : ''}>
                    <option value="new" ${data === 'new' ? 'selected' : ''}>New</option>
                    <option value="resubmission" ${data === 'resubmission' ? 'selected' : ''}>Resubmission</option>
                    <option value="completed" ${data === 'completed' ? 'selected' : ''}>Completed</option>
                    <option value="emergency" ${data === 'emergency' ? 'selected' : ''}>Emergency</option>
                </select>
            `;
                        return iconHtml + statusOptions;
                    },
                    className: 'dataTables-center'
                },
                { data: 'type', className: 'dataTables-center' },
                { data: 'description' },
                { data: 'location', className: 'dataTables-center' },
                { data: 'side', className: 'dataTables-center' },
                { data: 'qty_layer', className: 'dataTables-center' },
                { data: 'planned_time', className: 'dataTables-center' },
                admin ?
                    {
                        data: 'incharge',
                        render: function(data, type, row) {
                            // Find the incharge object that matches the task's incharge property
                            var matchingIncharge = incharges.find(function(incharge) {
                                return incharge.user_name === data;
                            });
                            // Generate image path
                            var imagePath = "{{ asset("assets/images/users") }}" + "/" + matchingIncharge.user_name + ".jpg";
                            // Generate HTML for incharge cell
                            return `
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
                        },
                        className: 'dataTables-center'
                    } : null,
                {
                    data: 'completion_time',
                    render: function(data, type, row) {
                        return `<input data-task-id="${row.id}" value="${data ? data : ''}" style="border: none; outline: none; background-color: transparent;" type="datetime-local" id="completionDateTime" name="completion_time">`;
                    },
                    className: 'dataTables-center'
                },
                {
                    data: 'inspection_details',
                    render: function(data, type, row) {
                        return `
                            <div style="cursor: pointer; width: 200px; ${data ? '' : 'text-align: center;'}" class="inspection-details" id= "inspectionDetails" ${admin ? '' : 'onclick="editInspectionDetails(this)"'}  data-task-id="${row.id}">
                                <span class="inspection-text" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 2; line-clamp: 2; " >${data ? data : 'N/A'}</span>
                                <textarea class="inspection-input" style="display: none; margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent;"></textarea>
                                <button style="display: none;" type="button" class="save-btn btn btn-light btn-sm">Save</button>
                            </div>`;
                    }
                },
                admin ?
                {
                    data: 'resubmission_count',
                    render: function(data, type, row) {
                        return `<td style="text-align: center" class="client_name" title="${row.resubmission_date}">${data ? (data > 1 ? data + " times" : data + " time") : ''}</td>`;
                    },
                    className: 'dataTables-center'
                } : null,
                {
                    data: 'rfi_submission_date',
                    render: function(data, type, row) {
                        return `<input ${admin ? '' : 'disabled'} value="${data ? data : ''}" data-task-id="${row.id}" style="border: none; outline: none; background-color: transparent;" type="date" id="rfiSubmissionDate" name="rfi_submission_date">`;
                    },
                    className: 'dataTables-center'
                },
                admin ?
                {
                    data: null,
                    defaultContent: '<td>Click</td>',
                    className: 'dataTables-center'
                } : null,
            // Define your columns here
        ]

    });
}

async function updateTaskList() {
    var header = `
        <tr>
        <th class="dataTables-center">Date</th>
        <th class="dataTables-center">RFI NO</th>
        <th class="dataTables-center">Status</th>
        <th class="dataTables-center">Type</th>
        <th class="dataTables-center">Description</th>
        <th class="dataTables-center">Location</th>
        <th class="dataTables-center">Road Type</th>
        <th class="dataTables-center">Quantity/Layer No.</th>
        <th class="dataTables-center">Planned Time</th>
        ${admin ? `
        <th class="dataTables-center">In-charge</th>
        ` : ''}
        <th class="dataTables-center">Completion Date/Time</th>
        <th class="dataTables-center">Comments</th>
        <th class="dataTables-center">Resubmitted</th>
        ${admin ? `
        <th class="dataTables-center">RFI Submission Date</th>` : ''}
        ${admin ? `
        <th class="dataTables-center">Edit</th>
        ` : ''}
        </tr>
        `;

    $('#taskListHead').html(header).css('text-align', 'center');

    var url = admin ? '{{ route("allTasks") }}' : '{{ route("allTasksSE") }}';

    await $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: async function (response) {
            var tasks = response.tasks;
            // Extracting dates from tasks
            const dates = tasks.map(task => new Date(task.date));

            // Finding the first and last dates
            const firstDate = new Date(Math.min(...dates));
            const lastDate = new Date(Math.max(...dates));
            console.log(firstDate, lastDate);

            await updateTaskListBody(tasks);

            flatpickr("#dateRangePicker", {
                minDate: new Date(firstDate),
                maxDate: new Date(lastDate),
                mode: 'range', // Specify 'range' mode as a string
            });
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
    var startDate = document.getElementById('dateRangePicker').value.split(" to ")[0];
    var endDate = document.getElementById('dateRangePicker').value.split(" to ")[1] ? document.getElementById('dateRangePicker').value.split(" to ")[1] : startDate;
    var taskStatus = document.getElementById('taskStatus').value;
    var taskIncharge = admin? document.getElementById('taskIncharge').value : null;

    try {
        await $.ajax({
            url : admin? "{{ route('filterTasks') }}" : "{{ route('filterTasksSE') }}",
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
                // $('#taskTable').DataTable().clear().destroy();

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

                // $('#dateRangePicker').daterangepicker({
                //     minDate: firstDate,
                //     maxDate: lastDate,
                //     opens: 'left'
                // });

                flatpickr("#dateRangePicker", {
                    minDate: new Date(firstDate),
                    maxDate: new Date(lastDate),
                    mode: 'range', // Specify 'range' mode as a string
                });

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

    <style>
        .dataTables-center {
            text-align: center;
        }
    </style>
@endsection


