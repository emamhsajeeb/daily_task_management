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
                                        <button id="exportToExcel" title="Export Tasks" class="btn btn-outline-success btn-icon waves-effect waves-light"><i class="ri-download-2-line align-bottom me-1"></i></button>
                                        @endrole
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body border-end-0 border-start-0">
                            <form id="filterTaskForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-xxl-2 col-sm-3">
                                        <input type="text" name="dateRange" class="form-control" id="dateRangePicker"  placeholder="Select date range" />
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-1 col-sm-2">
                                        <div class="input-light">
                                            <select style="appearance: none;" name="status" class="form-select" id="taskStatus">
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
                                    <div class="col-xxl-1 col-sm-2">
                                        <div class="input-light">
                                            <select style="appearance: none;" name="incharge" class="form-select" id="taskIncharge">
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
                                    <div class="col-xxl-1 col-sm-2">
                                        <div class="input-light">
                                            <select style="appearance: none;" name="qc_report" class="form-select" id="taskReport">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-1 col-sm-2">
                                        <button disabled type="button" class="btn btn-primary w-100" id="filterTasks">
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
                                    <table id="taskTable" style="background: none;" class="table-bordered column-order table-nowrap display compact align-middle">
                                        <thead id="taskListHead" style="text-align: center">
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
const userIsAdmin = {{$user->hasRole('admin') ? 'true' : 'false'}};
const userIsSe = {{$user->hasRole('se') ? 'true' : 'false'}};
const userIsQciAqci = {{$user->hasRole('qci') || $user->hasRole('qci') ? 'true' : 'false'}};
const user = {!! json_encode($user) !!};
const users = {!! json_encode($users) !!};
const incharges = {!! json_encode($incharges) !!};
const ncrs = {!! json_encode($ncrs) !!};
const objections = {!! json_encode($objections) !!};



async function generateReportOptions() {
    let reportOptions = `<option selected disabled value="">Select Report</option>`;

    ncrs.length > 0 && (reportOptions += `<optgroup label="NCRs">`);
    ncrs.forEach(ncr => reportOptions += `<option value="${'ncr_' + ncr.ncr_no}">${ncr.ncr_no}</option>`);
    ncrs.length > 0 && (reportOptions += `</optgroup>`);

    objections.length > 0 && (reportOptions += `<optgroup label="Objections">`);
    objections.forEach(objection => reportOptions += `<option value="${'obj_' + objection.obj_no}">${objection.obj_no}</option>`);
    objections.length > 0 && (reportOptions += `</optgroup>`);

    $('#taskReport').html(reportOptions);
}

async function updateTaskListBody(tasks, incharges, juniors) {

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
            search: '<span class="mdi mdi-magnify search-widget-icon"></span>',
        },
        destroy: true,
        order: [[0,'desc']],
        scroller: true,
        scrollY: 500,
        deferRender: true,
        fixedHeader: {
            header: true,
            footer: true
        },
        data: tasks, // Pass tasks data to DataTable
        columnDefs: [
            {
                targets: 1, // Target the date and number columns
                render: function(data, type, row, meta) {
                    // Check if NCRs exist for the current row
                    if (meta.col === 1) {
                        var badgeHTML = '';
                        if (row.ncrs && row.ncrs.length > 0) {
                            row.ncrs.forEach(function(ncr) {
                                badgeHTML += '<div><span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> NCR ' + ncr.ncr_no + '</span></div>';
                            });
                        }
                        if (row.objections && row.objections.length > 0) {
                            row.objections.forEach(function(objection) {
                                badgeHTML += '<div><span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> Objection ' + objection.obj_no + '</span></div>';
                            });
                        }
                        // Return the concatenated badge HTML
                        return data + badgeHTML;
                    }
                    // If no NCRs exist or not in the number column, return the original data
                    return data;
                }
            },
            {
                targets: userIsAdmin ? -2 : userIsSe? -1 : -2, // Target the last column
                render: function(data, type, row, meta) {
                    let reportOptions = `<select style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" class="attachReportDropdown" data-task-id="${row.id}">`;
                    reportOptions += `<option value="none" selected>None</option>`;

                    if (ncrs.length > 0) {
                        reportOptions += `<optgroup label="NCRs">`;
                        ncrs.forEach(ncr => {
                            // Check if the current NCR is selected for the current row
                            let selected = row.ncrs && row.ncrs.some(rowNcr => rowNcr.ncr_no === ncr.ncr_no) ? 'selected="selected"' : '';
                            reportOptions += `<option value="${'ncr_' + ncr.ncr_no}" ${selected}>NCR ${ncr.ncr_no}</option>`;
                        });
                        reportOptions += `</optgroup>`;
                    }

                    if (objections.length > 0) {
                        reportOptions += `<optgroup label="Objections">`;
                        objections.forEach(objection => {
                            // Check if the current Objection is selected for the current row
                            let selected = row.objections && row.objections.some(rowObjection => rowObjection.obj_no === objection.obj_no) ? 'selected="selected"' : '';
                            reportOptions += `<option value="${'obj_' + objection.obj_no}" ${selected}>OBJ ${objection.obj_no}</option>`;
                        });
                        reportOptions += `</optgroup>`;
                    }

                    reportOptions += `</select>`;
                    return reportOptions;
                }
            },
            {
                "targets": userIsSe ? 5 : 4, // Targeting the fifth column (index 4)
                "className": "description-column", // Apply custom CSS class
                "render": function(data, type, row) {
                    return type === 'display' && data.length > 30
                        ? userIsSe || userIsQciAqci
                            ? `<span style="overflow-x: auto; white-space: nowrap; max-width: 30ch; display: inline-block;" title="${data}">${data}</span>`
                            : userIsAdmin
                                ? `<span style="overflow-y: auto; max-height: 30px;" title="${data}">${data.substr(0, 30)}...</span>`
                                : ''
                        : data;
                }
            }

        ],
        columns: [
                { data: 'date', className: 'dataTables-center' },
                { data: 'number', className: 'dataTables-center' },
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
                <select id="status-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="${row.id}" ${userIsAdmin ? 'disabled' : ''}>
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
                userIsSe ?
                {
                    data: 'assigned',
                    render: function(data, type, row) {
                        let assignOptions = !data ? '<option value="" selected disabled>Please select</option>' : '';
                        let avatar = '<img src="{{ asset("assets/images/users/") }}' + (data ? '/' + data : '/user-dummy-img') + '.jpg" alt="' + (data ? data : 'Not assigned') + '" class="avatar rounded-circle avatar-xxs" />';
                        juniors.forEach(function (junior) {
                            assignOptions += '<option value="' + junior.user_name + '" ' + (data === junior.user_name ? 'selected' : '') + '>' + junior.first_name + '</option>';
                        });
                        const assignJunior = '<select id="assign-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="' + row.id + '">' + assignOptions + '</select>';
                        return '<div class="avatar-container">' + avatar + assignJunior + '</div>';
                    },
                    className: 'dataTables-center'
                } : '',
                { data: 'type', className: 'dataTables-center' },
                { data: 'description' },
                { data: 'location', className: 'dataTables-center' },
                {
                    data: 'inspection_details',
                    render: function(data, type, row) {
                        return `
                            <div style="cursor: pointer; width: 200px; ${data ? '' : 'text-align: center;'}" class="inspection-details" id= "inspectionDetails" ${userIsAdmin ? '' : 'onclick="editInspectionDetails(this)"'}  data-task-id="${row.id}">
                                <span class="inspection-text" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 2; line-clamp: 2; " >${data ? data : 'N/A'}</span>
                                <textarea class="inspection-input" style="display: none; margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent;"></textarea>
                                <button style="display: none;" type="button" class="save-btn btn btn-light btn-sm">Save</button>
                            </div>`;
                    }
                },
                { data: 'side', className: 'dataTables-center' },
                { data: 'qty_layer', className: 'dataTables-center' },
                { data: 'planned_time', className: 'dataTables-center' },
                userIsAdmin ?
                    {
                        data: 'incharge',
                        render: function(data, type, row) {
                            let inchargeOptions = !data ? '<option value="" selected disabled>Please select</option>' : '';
                            let avatar = '<img src="{{ asset("assets/images/users/") }}' + (data ? '/' + data : '/user-dummy-img') + '.jpg" alt="' + (data ? data : 'Not assigned') + '" class="avatar rounded-circle avatar-xxs" />';
                            incharges.forEach(function (incharge) {
                                inchargeOptions += '<option value="' + incharge.user_name + '" ' + (data === incharge.user_name ? 'selected' : '') + '>' + incharge.first_name + '</option>';
                            });
                            const assignIncharge = '<select id="incharge-dropdown" style="margin-bottom: 0rem !important; border: none; outline: none; background-color: transparent; text-align: center" data-task-id="' + row.id + '">' + inchargeOptions + '</select>';
                            return '<div class="avatar-container">' + avatar + assignIncharge + '</div>';
                        },
                        className: 'dataTables-center'
                    } : '',
                {
                    data: 'completion_time',
                    render: function(data, type, row) {
                        return `<input data-task-id="${row.id}" value="${data ? data : ''}" style="border: none; outline: none; background-color: transparent;" type="datetime-local" id="completionDateTime" name="completion_time">`;
                    },
                    className: 'dataTables-center'
                },
                {
                    data: 'resubmission_count',
                    render: function(data, type, row) {
                        return data ? `<td style="text-align: center" class="client_name" title="">

                        <button type="button" class="btn btn-sm btn-lg" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" title="Resubmission Dates" data-content="${row.resubmission_date}">${data > 1 ? data + " times" : data + " time"}</button>
                        </td>` : '';
                    },
                    className: 'dataTables-center'
                },
                userIsAdmin ?
                {
                    data: 'rfi_submission_date',
                    render: function(data, type, row) {
                        return `<input ${userIsAdmin ? '' : 'disabled'} value="${data ? data : ''}" data-task-id="${row.id}" data-task-status="${row.status}" style="border: none; outline: none; background-color: transparent;" type="date" id="rfiSubmissionDate" name="rfi_submission_date">`;
                    },
                    className: 'dataTables-center'
                } : '',
                userIsAdmin || userIsSe ?
                {
                    data: null,
                    className: 'dataTables-center',
                    defaultContent: ''
                } : '',
                userIsAdmin ?
                {
                    data: null,
                    className: 'dataTables-center',
                    render: function(data, type, row, meta) {
                        return '<td class="dataTables-center" style="text-align: center;">' +
                            '<div class="hstack gap-3 flex-wrap justify-content-center">' +
                            '<a style="text-align: center" href="javascript:void(0);" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>' +
                            '<a style="text-align: center" href="javascript:void(0);" class="link-danger fs-15"><i class="ri-delete-bin-line"></i></a>' +
                            '</div>' +
                            '</td>';
                    }
                } : '',
            // Define your columns here
        ].filter(Boolean),
        createdRow: function(row, data, dataIndex) {
            // Check if NCRs exist for the current row
            if ((data.ncrs && data.ncrs.length > 0) || (data.objections && data.objections.length > 0)) {
                // Add red font color to the row
                $(row).css('color', 'red');
            }
        }
    });
}

async function isLocalTasksLatest(timeStamp) {
    try {
        // Convert timeStamp to a Date object
        const localTimeStamp = new Date(timeStamp);
        console.log("Local Time Stamp: ",localTimeStamp);
        const response = await $.ajax({
            url: '{{ route("getLatestTimestamp") }}',
            method: 'GET',
            dataType: 'json'
        });

        console.log("Server Time Stamp: ",new Date(response.timestamp));

        if (new Date(response.timestamp) > localTimeStamp) {
            console.info("Local storage data is expired");
            return false;
        } else if (new Date(response.timestamp) < localTimeStamp) {
            console.info("Local storage data is latest");
            return true;
        }
    } catch (error) {
        return error;
    }
}

async function getTasksData() {
    let tasksData = JSON.parse(localStorage.getItem('tasksData'));
    let tasks, incharges, juniors;

    if (tasksData != null && await isLocalTasksLatest(tasksData.timestamp) && (
        (userIsSe && (tasksData.tasks && tasksData.juniors)) ||
        (userIsAdmin && (tasksData.tasks && tasksData.incharges)) ||
        (userIsQciAqci && tasksData.tasks)
    )) {
        console.info("Got tasks data from local storage");
toastr.success("Got tasks data from local storage");
        return tasksData;
    } else {
    try {
        const response = await $.ajax({
            url: userIsAdmin ? '{{ route("allTasks") }}' : '{{ route("allTasksSE") }}',
            method: 'GET',
            dataType: 'json'
        });

        tasks = response.tasks ? response.tasks : null;
        incharges = response.incharges ? response.incharges : null;
        juniors = response.juniors ? response.juniors : null;

        // Update existing tasksData in localStorage
        tasksData = {
            tasks: tasks,
            incharges: incharges,
            juniors: juniors,
            timestamp: new Date().getTime() // Store current timestamp
        };
        localStorage.setItem('tasksData', JSON.stringify(tasksData));
        console.info("Got tasks data from server side");
        toastr.success("Got tasks data from server side");
        return tasksData; // Return the data
    } catch (error) {
        throw error; // Throw error if AJAX call fails
    }
    }
}

async function updateTaskList() {
    var preloader = document.getElementById('preloader');
    var header = `
        <tr>
        <th class="dataTables-center">Date</th>
        <th class="dataTables-center">RFI NO</th>
        <th class="dataTables-center">Status</th>
        ${userIsSe ? `
        <th class="dataTables-center">Assign</th>
        ` : ''}
        <th class="dataTables-center">Type</th>
        <th class="dataTables-center">Description</th>
        <th class="dataTables-center">Location</th>
        <th class="dataTables-center">Comments</th>
        <th class="dataTables-center">Road Type</th>
        <th class="dataTables-center">Quantity/Layer No.</th>
        <th class="dataTables-center">Planned Time</th>
        ${userIsAdmin ? `
        <th class="dataTables-center">In-charge</th>
        ` : ''}
        <th class="dataTables-center">Completion Date/Time</th>
        <th class="dataTables-center">Resubmitted</th>
        ${userIsAdmin ? `
        <th class="dataTables-center">RFI Submission Date</th>` : ''}
        ${userIsAdmin || userIsSe ? `
        <th class="dataTables-center">Attach/Detach Report</th>
        ` : ''}
        ${userIsAdmin ? `
        <th class="dataTables-center">Actions</th>
        ` : ''}
        </tr>
        `;

    $('#taskListHead').html(header).css('text-align', 'center');

        const tasksData = await getTasksData();

        // Extracting dates from tasks
        const dates = tasksData.tasks.map(task => new Date(task.date));

        // Finding the first and last dates
        const firstDate = new Date(Math.min(...dates));
        const lastDate = new Date(Math.max(...dates));

        await updateTaskListBody(tasksData.tasks, tasksData.incharges, tasksData.juniors);

        flatpickr("#dateRangePicker", {
            minDate: new Date(firstDate),
            maxDate: new Date(lastDate),
            mode: 'range', // Specify 'range' mode as a string
        });
        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
        preloader.style.visibility = 'hidden'; // Set visibility to visible
}

async function filterTaskList() {
    let tasksData = await getTasksData();
    try {
        const dateRangeValue = document.getElementById('dateRangePicker').value;
        const startDateValue = dateRangeValue.split(" to ")[0];
        const endDateValue = dateRangeValue.split(" to ")[1] || startDateValue; // Use startDateValue if endDate is null

        const startDate = startDateValue ? new Date(startDateValue) : null;
        const endDate = endDateValue ? new Date(endDateValue) : null;
        const taskStatus = document.getElementById('taskStatus').value;
        const taskIncharge = userIsAdmin ? (document.getElementById('taskIncharge').value || null) : null;
        const taskReport = $('#taskReport').val();
        console.log(taskReport);

        let filteredTasks = tasksData.tasks;

        // Query tasks based on date range
        filteredTasks = filteredTasks.filter(task => (!startDate || !endDate || new Date(task.date) >= startDate && new Date(task.date) <= endDate));
        // Query tasks based on status
        filteredTasks = filteredTasks.filter(task => !taskStatus || task.status === taskStatus);
        // Query tasks based on incharge
        filteredTasks = filteredTasks.filter(task => !taskIncharge || task.incharge === taskIncharge);
        // Query tasks based on reports and date range
        filteredTasks = filteredTasks.filter(task => {
            // Handle cases where taskReport might be empty or undefined
            if (!taskReport) {
                return true; // Include all tasks if no report selected
            }

            // Split taskReport into an array (assuming format "ncr_123" or "obj_456")
            const reportParts = taskReport.split('_');

            if (reportParts.length !== 2) {
                console.warn('Invalid taskReport format. Expected "ncr_" or "obj_" followed by number.');
                return false; // Exclude task if format is invalid
            }

            const reportType = reportParts[0];
            const reportNumber = reportParts[1];

            // Filter based on report type and number
            if (reportType === 'ncr') {
                return task.ncrs.some(ncr => ncr.ncr_no === reportNumber);
            } else if (reportType === 'obj') {
                return task.objections.some(objection => objection.obj_no === reportNumber);
            } else {
                console.warn('Unsupported report type:', reportType);
                return false; // Exclude task if report type is not supported
            }
        });
        console.log('Report filtered: ', filteredTasks);

        // Assign tasksData based on user role
        tasksData.tasks = userIsSe ? filteredTasks : (userIsQciAqci || userIsAdmin ? filteredTasks : []);
        tasksData.juniors = userIsSe ? users.filter(user => user.incharge === user.user_name) : [];
        tasksData.incharges = userIsAdmin ? users.filter(user => user.role === 'se') : [];

        await updateTaskListBody(tasksData.tasks, tasksData.incharges, tasksData.juniors);

    } finally {
        // Change the button to a reset button
        $('#filterTasks').html(`<i class="ri-refresh-line me-1 align-bottom"></i> Reset <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">${tasksData.tasks.length} <span class="visually-hidden">tasks filtered</span></span>`);
        $('#filterTasks').prop('disabled', false);
        $('#filterTasks').off('click'); // Remove previous click event handler
        $('#filterTasks').click(async function (e) {
            e.preventDefault();
            $('#filterTasks').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Resetting...');
            $('#filterTasks').prop('disabled', true);
            await resetTaskList();
        });
    }


}

async function resetTaskList() {
    await updateTaskList();
    flatpickr("#dateRangePicker").clear();
    // Clear values of date range picker, task status, and task incharge
    $('#dateRangePicker, #taskStatus, #taskIncharge').val('');
    // Once inputs are cleared, restore the button
    $('#filterTasks').html('<i class="ri-equalizer-fill me-1 align-bottom"></i>Filter');
    $('#filterTasks').prop('disabled', true);
}

// Function to handle form submission via AJAX
async function addTask() {
    var preloader = document.getElementById('preloader');
    // Get form data
    var formData = new FormData(document.getElementById('addTaskForm'));

    // AJAX request
    await $.ajax({
        url: userIsAdmin ? '{{ route('addTask') }}' : '{{ route('addTaskSE') }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: async function (response) {
            var preloader = document.getElementById('preloader');
            toastr.success(response.message);
            await updateTaskList();

            // Extracting dates from tasks
            const dates = tasks.map(task => new Date(task.date));

            // Finding the first and last dates
            const firstDate = new Date(Math.min(...dates));
            const lastDate = new Date(Math.max(...dates));


            flatpickr("#dateRangePicker", {
                minDate: new Date(firstDate),
                maxDate: new Date(lastDate),
                mode: 'range', // Specify 'range' mode as a string
            });

            preloader.style.opacity = '0.4'; // Set opacity to 1 to make it visible
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
}

async function exportToExcel() {
    try {
        // Get the HTML table element
        var table = document.getElementById("taskTable");

        // Create an empty Excel Workbook
        var excelData = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        excelData += '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>';
        excelData += '<body>';
        excelData += '<table>';

        // Add the table rows and cells to the Excel data
        for (var i = 0; i < table.rows.length; i++) {
            excelData += '<tr>';
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                excelData += '<td>' + table.rows[i].cells[j].innerHTML + '</td>';
            }
            excelData += '</tr>';
        }

        excelData += '</table>';
        excelData += '</body>';
        excelData += '</html>';

        // Create a data URI
        var uri = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(excelData);

        // Create a new window and open the data URI
        var link = document.createElement('a');
        link.href = uri;
        link.style = "visibility:hidden";
        link.download = "Tasks.xls";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } finally {
        $('#exportToExcel').html('<i class="ri-download-2-line align-bottom me-1"></i>');
        $('#exportToExcel').prop('disabled', false);
    }
}

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

            document.querySelector('#status-dropdown[data-task-id="' + taskId + '"]').value = status;
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    })
}

// Function to handle status update
async function assignTask(taskId, userName) {
    $.ajax({
        url : "{{ route('assignTask') }}",
        type:"POST",
        data: {
            task_id: taskId,
            user_name: userName
        },
        success:function (response) {
            toastr.success(response.message);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    })
}

// Function to handle status update
async function assignIncharge(taskId, userName) {
    $.ajax({
        url : "{{ route('assignIncharge') }}",
        type:"POST",
        data: {
            task_id: taskId,
            user_name: userName
        },
        success:function (response) {
            toastr.success(response.message);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    })
}

// Function to handle status update
async function updateRfiSubmissionDate(taskId, date, status) {
    $.ajax({
        url:"{{ route('updateRfiSubmissionDate') }}",
        type:"POST",
        data: {
            id: taskId,
            date: date
        },
        success:async function (data) {
            toastr.success(data.message+date);
            // Check if status is not 'complete'
            if (!(status === 'completed')) {
                await updateTaskStatus(taskId, 'completed');
            }

            // Check if status is 'complete' and #completionDateTime has no value
            if (status === 'completed' && !$('#completionDateTime').val()) {
                $('#completionDateTime').click();
            }

        }
    })
}

async function updateCompletionDateTime(taskId, dateTime) {
    $.ajax({
        url: userIsAdmin ? "{{ route('updateCompletionDateTime') }}" : "{{ route('updateCompletionDateTimeSE') }}",
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


// AJAX request to update task_has_ncr table
async function attachReport(taskId, selectedReport) {
    $.ajax({
        url : "{{ route('attachReport') }}",
        type:"POST",
        data: {
            task_id: taskId,
            selected_report: selectedReport
        },
        success:function (response) {
            toastr.success(response.message);

            // Update row data and appearance
            var table = $('#taskTable').DataTable();
            var index = table.row(function (idx, data, node) {
                return data.id === taskId; // Assuming 'id' is the task ID property in your data
            }).index();
            table.row(index).data(response.updatedRowData).draw(false);
            var rowData = table.row(index).data();
            var rowNode = table.row(index).node();
            if ((rowData.ncrs && rowData.ncrs.length > 0) || (rowData.objections && rowData.objections.length > 0)) {
                rowNode.style.color = 'red';
            } else {
                rowNode.style.color = '';
            }
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    })
}


// AJAX request to update task_has_ncr table
async function detachReport(taskId) {
    $.ajax({
        url : "{{ route('detachReport') }}",
        type:"POST",
        data: {
            task_id: taskId
        },
        success:function (response) {
            toastr.success(response.message);

            // Update row data and appearance
            var table = $('#taskTable').DataTable();
            var index = table.row(function (idx, data, node) {
                return data.id === taskId; // Assuming 'id' is the task ID property in your data
            }).index();
            table.row(index).data(response.updatedRowData).draw(false);
            var rowData = table.row(index).data();
            var rowNode = table.row(index).node();
            if (rowData.ncrs && rowData.ncrs.length > 0) {
                rowNode.style.color = 'red';
            } else {
                rowNode.style.color = '';
            }
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    })
}


// Call the function when the page loads
$( document ).ready(async function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    await generateReportOptions();

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


    await $('#exportToExcel').click(async function (e) {
        e.preventDefault();
        $('#exportToExcel').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#exportToExcel').prop('disabled', true);
        await exportToExcel();
    });
});

$('#dateRangePicker, #taskStatus, #taskIncharge, #taskReport').on('change', function() {
    $('#filterTasks').off('click'); // Remove previous click event handler
    $('#filterTasks').html('<i class="ri-equalizer-fill me-1 align-bottom"></i>Filter');
    $('#filterTasks').prop('disabled', false);
    $('#filterTasks').click(async function (e) {
        e.preventDefault();
        $('#filterTasks').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Filtering...');
        $('#filterTasks').prop('disabled', true);
        await filterTaskList();
    });
});

// Event listener for dropdown change
$(document).on('input', '#status-dropdown', async function (e) {
    const taskId = e.target.getAttribute('data-task-id');
    const status = e.target.value;
    await updateTaskStatus(taskId, status);
});

$(document).on('input', '#assign-dropdown', async function (e) {
    const selectedUsername = $(this).val();
    const selectedRow = $(this).closest('tr'); // Get the closest parent row

    // Construct the avatar source path and alt text
    const selectedAvatarSrc = "{{ asset('assets/images/users') }}/" + selectedUsername + ".jpg";
    const selectedAvatarAlt = selectedUsername;

    // Find the avatar element within the selected row
    const selectedAvatar = selectedRow.find('.avatar');

    // Update the src and alt attributes of the avatar
    selectedAvatar.attr('src', selectedAvatarSrc);
    selectedAvatar.attr('alt', selectedAvatarAlt);

    const taskId = e.target.getAttribute('data-task-id');
    const user_name = e.target.value;
    await assignTask(taskId, user_name);
});

$(document).on('input', '#incharge-dropdown', async function (e) {
    const selectedUsername = $(this).val();
    const selectedRow = $(this).closest('tr'); // Get the closest parent row

    // Construct the avatar source path and alt text
    const selectedAvatarSrc = "{{ asset('assets/images/users') }}/" + selectedUsername + ".jpg";
    const selectedAvatarAlt = selectedUsername;

    // Find the avatar element within the selected row
    const selectedAvatar = selectedRow.find('.avatar');

    // Update the src and alt attributes of the avatar
    selectedAvatar.attr('src', selectedAvatarSrc);
    selectedAvatar.attr('alt', selectedAvatarAlt);

    // Get the task ID and username for further processing
    const taskId = e.target.getAttribute('data-task-id');
    const user_name = e.target.value;

    // Call the assignIncharge function asynchronously
    await assignIncharge(taskId, user_name);
});

$(document).on('input', '#rfiSubmissionDate', async function (e) {
    const taskId = e.target.getAttribute('data-task-id');
    const taskStatus = e.target.getAttribute('data-task-status');
    const date = e.target.value;
    await updateRfiSubmissionDate(taskId, date, taskStatus)
});

$(document).on('input', '#completionDateTime', async function (e) {
    var taskId = e.target.getAttribute('data-task-id');
    var dateTime = e.target.value;
    await updateCompletionDateTime(taskId, dateTime)
});

$(document).on('input', '.attachReportDropdown', async function (e) {
    const selectedReport = $(this).val();
    const taskId = e.target.getAttribute('data-task-id');

    console.log("Selected Report: "+selectedReport);
    console.log("Selected Task ID: "+taskId);

    selectedReport === "none" ? await detachReport(taskId) : await attachReport(taskId,selectedReport);
});


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


